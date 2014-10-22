<?php

/**
 * @author  Seungchul
 * @date    July 5, 2014
 */

class RememberMe extends Model {
    private $key = null;

    function __construct($privatekey) 
    {
        parent::__construct();
        $this->key = $privatekey;
    }

    public function auth() 
    {
        if (!Cookie::get('auto')) 
        {
            return false;
        }
        
        if (!$cookie = @json_decode(Cookie::get('auto'), true)) 
        {
            return false;
        }

        if ( ! (isset($cookie['user']) || isset($cookie['token']) || isset($cookie['signature'])) ) 
        {
            return false;
        }

        $var = $cookie['user'] . $cookie['token'];

        if (! $this->verify($var, $cookie['signature'])) 
        {
            throw new Exception("Cokies has been tampared with");
        }

        $info = $this->db->select(array("remember_info"), "users", array("login"), array($cookie['user']));
        if (!$info) 
        {
            return false; // User must have deleted accout
        }
        
        $info = $info->fetchAll();
        $info = $info[0]['remember_info'];
        
        if (empty($info) || !isset($info))
        {
            return false;
        }
        
        if (!$info = json_decode($info, true)) {
            throw new Exception("User Data corrupted");
        }

        if ($info['token'] !== $cookie['token']) {
            throw new Exception("System Hijacked or User use another browser");
        }
        
        return $info;
    }

    public function remember($username) {
        $cookie = [
                "user" => $username,
                "token" => $this->getRand(64),
                "signature" => null
        ];
        $cookie['signature'] = $this->hash($cookie['user'] . $cookie['token']);
        $encoded = json_encode($cookie);
        

        // Add User to database
        $this->db->update("users", 
                        array("remember_info"), 
                        array($encoded), 
                        array("login"), 
                        array($username));

        /**
         * Set Cookies
         * In production enviroment Use
         * setcookie("auto", $encoded, time() + $expiration, "/~root/",
         * "example.com", 1, 1);
         */
        Cookie::remove('auto');
        Cookie::set('auto', $encoded);
        
        $test = @json_decode(Cookie::get('auto'), true);
    }

    public function verify($data, $hash) {
        $rand = substr($hash, 0, 4);
        return $this->hash($data, $rand) === $hash;
    }

    private function hash($value, $rand = null) {
        $rand = $rand === null ? $this->getRand(4) : $rand;
        return $rand . bin2hex(hash_hmac('sha256', $value . $rand, $this->key, true));
    }

    private function getRand($length) {
        switch (true) {
            case function_exists("mcrypt_create_iv") :
                $r = mcrypt_create_iv($length, MCRYPT_DEV_URANDOM);
                break;
            case function_exists("openssl_random_pseudo_bytes") :
                $r = openssl_random_pseudo_bytes($length);
                break;
            case is_readable('/dev/urandom') : // deceze
                $r = file_get_contents('/dev/urandom', false, null, 0, $length);
                break;
            default :
                $i = 0;
                $r = "";
                while($i ++ < $length) {
                    $r .= chr(mt_rand(0, 255));
                }
                break;
        }
        return substr(bin2hex($r), 0, $length);
    }
}