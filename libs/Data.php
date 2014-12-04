<?php

class Data {
    
    static $username;
    
    function __construct() {
        
    }


    static function setUsername($username)
    {
        self::$username = $username;
    }
    
    static function getUsername()
    {
        return self::$username;
    }

}