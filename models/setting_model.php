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

    public function updatePreference()
    {
        $username = Session::get('username');
        $minSalary = $_POST['min-salary'];
        $primarySkill = $_POST['skill-primary'];
        $area = $_POST['area'];
        $level = $_POST['level'];
        $position = $_POST['position'];
        $visa = $_POST['visa'];

        $statement = $this->db->prepare("
            SELECT userID FROM Student WHERE email = '$username'
        ");
        $statement->execute();
        $uID = $statement->fetch()['userID'];

        $statement = $this->db->prepare("
            UPDATE PREFERENCE SET minSalary = '$minSalary', primarySkill = '$primarySkill', area = '$area', 
            level = '$level', position = '$position', visa = '$visa' WHERE uID = '$uID'
        ");
        $statement->execute();

        if($statement){
            return true;
        }
        else{
            return false;
        }
    }

    public function updateProfile()
    {
        $username = Session::get('username');
        $firstname = $_POST['firstname'];
        $lastname = $_POST['lastname'];
        $phoneNumber = $_POST['phonenum'];
        $personalLink = $_POST['personallink'];
        $address = $_POST['address'];
        $school = $_POST['school'];
        $visa = $_POST['profile-visa'];

        $statement = $this->db->prepare("
            UPDATE STUDENT SET firstname = '$firstname', lastname = '$lastname', phoneNumber = '$phoneNumber', personalLink = '$personalLink', 
            school = '$school', visaStatus = '$visa', address = '$address' WHERE email = '$username'
        ");
        $statement->execute();

        if($statement){
            return true;
        }
        else{
            return false;
        }
    }
}