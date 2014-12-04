<?php

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
        $userId = Session::get('userId');


        if(isset($_FILES['resume'])){

            $resume = $_FILES['resume']['tmp_name'];
            $resumeName = $userId . '_' . $_FILES['resume']['name'];
            $resumeName = str_replace(" ","_",$resumeName);
            
            $full_path = $_SERVER['DOCUMENT_ROOT'] . '/comjob/cs411_project/public/resume/' . $resumeName;
            
            if(!move_uploaded_file($resume, $full_path)){
                return false;
            }
            else{
                $query = "UPDATE STUDENT SET firstname = '$firstname', lastname = '$lastname', personalLink = '$personalLink', phoneNumber = '$phoneNumber', 
                    address = '$address', visaStatus = '$visa', school = '$school', resume = '$resumeName' WHERE userID = '$userId'";
            }
        }else{
            $query = "UPDATE STUDENT SET firstname = '$firstname', lastname = '$lastname', phoneNumber = '$phoneNumber', personalLink = '$personalLink', 
                school = '$school', visaStatus = '$visa', address = '$address' WHERE userID = '$userId'";
        }

        $statement = $this->db->prepare($query);
        $statement->execute();

        if($statement){
            return true;
        }
        else{
            return false;
        }
    }
    
    public function updateRecruiterInfo()
    {
        $firstname = $_POST['firstname'];
        $lastname = $_POST['lastname'];
        $personalLink = $_POST['website'];
        $companyId = $_POST['company_list'];
        $userID = Session::get('userId');
        
        $statement = $this->db->prepare("
            UPDATE Recruiter 
            SET firstname = '$firstname', lastname = '$lastname', personalLink = '$personalLink'
            WHERE userID = $userID;
        ");
        $statement->execute();
        
        $relation_statement = $this->db->prepare("
            UPDATE RelationCompanyRecruiter
            SET companyId = $companyId
            WHERE recruiterId = $userID;
        ");
        $relation_statement->execute();
        $add_statement;
        
        if ($relation_statement->rowCount() < 1) {
            $add_statement = $this->db->prepare("INSERT INTO RelationCompanyRecruiter (recruiterId,companyId) VALUES (:recruiterId,:companyId)");
            $add_statement->execute(array(':recruiterId'=>$userID, ':companyId'=>$companyId));
        }

        if($statement && ($relation_statement || $add_statement)){
            return true;
        }
        else{
            return false;
        }
    }
    
    public function getCompanyList($isStudent)
    {
        if ($isStudent) {
            //TODO: error msg
            echo 'Invalid Access!\n'
               . '\tgetCompanyList() in Setting Model\n'
               . '\t\tindex() in Setting Controller';
            exit;
        }
        
        //TODO: give back the compnay list
        $statement = $this->db->prepare("
                        SELECT name, companyId
                        FROM Company
                    ");

        $success = $statement->execute();
        $companies = $statement->fetchAll();
        $result = Array();
        
        foreach ($companies as $company) {
            $format = '{"name": "' . $company['name'] .'", "id": "' . $company['companyId'] . '"}';
            array_push($result, json_decode($format, true));
        }
        
        if (!$success) {
            echo 'Error Occurs while query company data\n'
                .'\tgetCompanyList() in Setting Model\n'
                .'\t\tindex() in Setting Controller';
        }
        
        return json_decode(json_encode($result), true);
    }
    
    public function addCompany()
    {
        $name = $_POST['company_name'];
        $description = $_POST['company_description'];
        $url = $_POST['company_url'];
        $result;
        $statement = $this->db->prepare("
                SELECT name
                FROM Company
                WHERE name = '$name'
        ");
        $success = $statement->execute();

        if ($success && !empty($statement->fetchAll())) {  
            $result = '{"error_msg": "Company is already existed"}';
        }
        else {
            $query_company = "INSERT INTO Company (name,description,url) VALUES (:name,:description,:url)";
            $q_company = $this->db->prepare($query_company);
            $q_company->execute(array(':name'=>$name, ':description'=>$description, ':url'=>$url));
            $companyId = $this->db->lastInsertId();
            
//            $query_relation = "INSERT INTO RelationCompanyRecruiter (recruiterId,companyId) VALUES (:recruiterId,:companyId)";
//            $q_relation = $this->db->prepare($query_relation);
//            $q_relation->execute(array(':recruiterId'=>Session::get('userId'), ':companyId'=>$companyId));

            if (!$q_company) {
                $result = '{"error_msg": "Error occurs while inserting company info into db."}';
            }
            else {
                $result = '{"error_msg": "", "company": "'.$name.'", "id": '.$companyId.'}';
            }
        }
        
        return $result;
    }

    public function getProfile($userId)
    {
        $query = "SELECT firstname, lastname, personalLink, phoneNumber, address, visaStatus, school, resume FROM STUDENT WHERE userID = '$userId'";
        $statement = $this->db->prepare($query);
        $statement->execute();
        $profile = $statement->fetch();
        
        $result = Array();
        
        array_push($result, $this->profileFormatter($profile['firstname'], $profile['lastname'], $profile['personalLink'], 
           $profile['phoneNumber'], $profile['address'], $profile['visaStatus'], $profile['school'], $profile['resume']));
        
        return $result;

    }

    public function getPreference($userId)
    {
        $query = "SELECT * FROM PREFERENCE WHERE uID = $userId";
        $statement = $this->db->prepare($query);
        $statement->execute();
        $preference = $statement->fetch();
        
        $result = Array();
        
        array_push($result, $this->preferenceFormatter($preference['minSalary'], $preference['primarySkill'], $preference['area'], 
           $preference['level'], $preference['position'], $preference['visa']));
        
        return $result;

    }

    private function preferenceFormatter($salary, $skill, $area, $level, $position, $visa) 
    {
        $result = '{
                        "salary": "' . $salary . '",
                        "skill": "' . $skill . '",
                        "area": "'. $area . '",
                        "level": "'. $level . '",
                        "position": "' . $position . '",
                        "visa": "' . $visa . '"';
        $result .=  ' }';
        
        return json_decode($result, true);
    }

    private function profileFormatter($firstname, $lastname, $link, $number, $address, $visa, $school, $resume) 
    {
        $result = '{
                        "firstname": "' . $firstname . '",
                        "lastname": "' . $lastname . '",
                        "personalLink": "'. $link . '",
                        "phoneNumber": "'. $number . '",
                        "address": "' . $address . '",
                        "visaStatus": "' . $visa . '",
                        "school": "' . $school . '",
                        "resume": "' . $resume . '"';
        $result .=  ' }';
        
        return json_decode($result, true);
    }
}