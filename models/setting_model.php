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
                        SELECT name
                        FROM Company
                    ");

        $success = $statement->execute();
        $companies = $statement->fetchAll();
        $result = Array();
        
        foreach ($companies as $company) {
            array_push($result, $company['name']);
        }
        
        if (!$success) {
            echo 'Error Occurs while query company data\n'
                .'\tgetCompanyList() in Setting Model\n'
                .'\t\tindex() in Setting Controller';
        }
        
        return $result;
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
            
            $query_relation = "INSERT INTO RelationCompanyRecruiter (recruiterId,companyId) VALUES (:recruiterId,:companyId)";
            $q_relation = $this->db->prepare($query_relation);
            $q_relation->execute(array(':recruiterId'=>Session::get('userId'), ':companyId'=>$companyId));

            if (!$q_company && !$q_relation) {
                $result = '{"error_msg": "Error occurs while inserting company info into db."}';
            }
            else {
                $result = '{"error_msg": "", "company": "'.$name.'"}';
            }
        }
        
        return $result;
    }
}