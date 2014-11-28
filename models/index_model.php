<?php
/**
 * @author Seungchul
 * @date   July 5, 2014
 */

class Index_Model extends Model {

    function __construct() 
    {
        parent::__construct();
    }
    
    public function login()
    {
        $username = $_POST['username'];
        $password = md5($_POST['password']);
        $position = explode("_", $_POST['position'])[0];

        if (empty($username) && empty($password))
        {
            return FALSE;
        }
        else
        {
            $statement;
            if (strcmp($position, 'student') == 0) {
                $statement = $this->db->prepare("
                    SELECT *
                    FROM Student
                    WHERE email = '$username' AND password = '$password'
                ");
                Session::set('isStudent', true);
            }
            else {
                $statement = $this->db->prepare("
                    SELECT *
                    FROM Recruiter
                    WHERE email = '$username' AND password = '$password'
                ");
                Session::set('isStudent', false);
            }

            $success = $statement->execute();
            $result = $statement->fetchAll();

            if ($success && !empty($result)) 
            {
                Session::set('loggedIn', true);
                Session::set('username', $username);
                Session::set('userId', $result[0]['userID']);
                
                return TRUE;
            } 
            else 
            {
                return FALSE;
            }
        }
    }

    public function signup() {
        $email = $_POST['username'];
        $password = md5($_POST['password']);
        $position = $_POST['position'];

        $query = "INSERT INTO $position (email, password) VALUES('$email', '$password')";
        $statement = $this->db->prepare($query);
        $success = $statement->execute();

        if ($success) {
            return true;
        }
        else {
            return false;
        }
    }
}