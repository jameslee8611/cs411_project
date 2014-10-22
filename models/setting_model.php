<?php
/**
 * @author  Seungchul
 * @Date    July 2, 2014
 */

class Setting_Model extends Model {

    function __construct() {
        parent::__construct();
    }
    
    public function withdrawAccount()
    {
        $password = md5($_POST['current_password']);
        $username = Session::get('username');
        
        $statement1 = $this->db->prepare("
            DELETE FROM Student
            WHERE email='$username' AND password='$password'
            ");
        $statement1->execute();
        $statement2 = $this->db->prepare("
            DELETE FROM Recruiter
            WHERE email='$username' AND password='$password'
            ");
        $statement2->execute();
        
        if($statement1->rowCount() != 0 || $statement2->rowCount() != 0)
        { 
            return true;
        }
        else 
        {
            return FALSE;
        }
    }
    
    public function changePassword()
    {
        $current_password = md5($_POST['current_password']);
        $new_password = md5($_POST['new_password']);
        $confirm_password = md5($_POST['confirm_password']);
        
        if (strcmp($new_password, $confirm_password) != 0)
        {
            return false;
        }
        else
        {
            //compare username and password, then update password
            $username = Session::get('username');
            $statement1 = $this->db->prepare("
                UPDATE Student
                SET password = '$new_password'
                WHERE email = '$username' AND password = '$current_password'
            ");
            $statement1->execute();
            
            $statement2 = $this->db->prepare("
                UPDATE Recruiter
                SET password = '$new_password'
                WHERE email = '$username' AND password = '$current_password'
            ");
            $statement2->execute();
            
            if($statement1->rowCount() != 0 || $statement2->rowCount() != 0)
            { 
                return true;
            }
            else 
            {
                return FALSE;
            }
        }
    }
}