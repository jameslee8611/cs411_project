<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of jobboard_model
 *
 * @author jameslee8611
 */
class board_model extends Model {
    
    function __construct() {
        parent::__construct();
    }
    
    public function getJob()
    {
        $username = Session::get('username');

        $statement = $this->db->prepare("
            SELECT userID FROM Student WHERE email = '$username'
        ");
        $success = $statement->execute();
        $uID = $statement->fetch()['userID'];
        
        if (!$success) {
            echo 'Error occurred while getting userID!<br />';
            echo '- in getjob() at board_model from board_controller<br />';
            exit;
        }

        $statement = $this->db->prepare("
            SELECT * FROM PREFERENCE WHERE uID = '$uID'
        ");
        $success = $statement->execute();
        $preference = $statement->fetch();
        
        if (!$success) {
            echo 'Error occurred while getting userID from PREFERENCE!<br />';
            echo '- in getjob() at board_model from board_controller<br />';
            exit;
        }

        $category = array('salary', 'requiredSkill', 'area', 'level', 'type','seekerVisaType');
        $query = $this->createFilterQuery($preference, $category);
        $statement = $this->db->prepare($query);
        $success = $statement->execute();
        
        $result = array();
        
        if ($success) {
            $query = $statement->fetchAll();

            foreach ($query as $row) 
            {
                array_push($result, $this->formatter($row['jobID'], $row['title'], $row['companyName'], $row['description'], $row['location'], $row['postedDate']));
            }
        } 
        else 
        {
            echo 'Error occurred while getting createFilterQuery!<br />';
            echo '- in getjob() at board_model from board_controller<br /><br />';
            echo 'Possible error detail: <br />';
            echo '1. query statement<br />';
            echo $this->createFilterQuery($preference, $category) . '<br />';
            exit;
        }

        return $result;
    }
    
    public function getJobRecruiter()
    {
        $recruiterId = Session::get('userId');
        
        $statement = $this->db->prepare("SELECT * FROM Job WHERE recruiterID = $recruiterId");
        $success = $statement->execute();
        
        if (!$success) {
            echo 'Error occurred while getting job query for recruiter!<br />';
            echo '- in getJobRecruiter() at board_model from board_controller<br /><br />';
            echo 'Possible error detail: <br />';
            echo '1. query statement<br />';
            echo 'SELECT * FROM Job WHERE jobID = $recruiterId <br />';
            exit;
        }
        
        $query = $statement->fetchAll();
        $result = Array();
        foreach ($query as $row) 
        {
            array_push($result, $this->formatter($row['jobID'], $row['title'], $row['companyName'], $row['description'], $row['location'], $row['postedDate']));
        }
        
        return $result;
    }
    
    public function getUserInfo()
    {
        $status = (Session::get('isStudent')) ? 'Student' : 'Recruiter';
        $email = Session::get('userId');
        $statement = $this->db->prepare("
                        SELECT *
                        FROM $status
                        WHERE userId = '$email';
                    ");
        $success = $statement->execute();
        $user = $statement->fetchAll();
        
        if (!$success || empty($user)) {
            echo "Error Occurs while query user data\r\n"
                ."\t getUserInfo() in Board Model\r\n"
                ."\t\t recruiterBoard() or jobBoard() in Board Controller";
            exit;
        }
        
        $result = '{}';
        if (!Session::get('isStudent')) {
            $result = '{"firstname": "'. $user[0]['firstname'] .'", "lastname": "'. $user[0]['lastname'] .'", "email": "'. $user[0]['email'] .'", "personalLink": "'. $user[0]['personalLink'] .'"}';
        }
        else {
            
        }
        
        return json_decode($result, true);
    }
    
    public function findJobById()
    {
        $jobID = $_POST['jobID'];
        $query = "SELECT * FROM JOB WHERE jobID = $jobID";
        $statement = $this->db->prepare($query);
        $statement->execute();
        $job = $statement->fetch();

        return $job;
    }
    
    public function getJobById($jobId)
    {
        
    }
    
    public function getCompanyInfo()
    {
        $status = (Session::get('isStudent')) ? 'Student' : 'Recruiter';
        if($status) {
            echo "Error Occurs while query user data\r\n"
                ."\t status Var contains wrong value\r\n"
                ."\t\t getCompanyInfo() in Board Model";
            exit;
        }
        $email = Session::get('userId');
        $statement = $this->db->prepare("
                SELECT companyId
                FROM RelationCompanyRecruiter
                WHERE recruiterId = '$email';
            ");
        $success = $statement->execute();
        $companyInfo = $statement->fetchAll();
        if(!$success || empty($companyInfo)) {
            echo "Error Occurs while query company ID\r\n"
                ."\t getUserInfo() in Board Model\r\n"
                ."\t\t recruiterBoard() in Board Controller";
            exit;
        }

        $statement = $this->db->prepare("
                SELECT name
                FROM Company
                WHERE companyId = '$companyInfo';
            ");
        $success = $statement->execute();
        $companyName = $statement->fetchAll();
        if(!$success || empty($companyName)) {
            echo "Error Occurs while query company's name\r\n"
                ."\t getUserInfo() in Board Model\r\n"
                ."\t\t recruiterBoard() in Board Controller";
            exit;
        }

        $result = '{}';
        $result = '{"companyName": "'. $companyName[0][0] .'}';

        return json_decode($result, true);


    }
    
    // private functions
    
    private function formatter($jobID, $title, $companyName, $description, $location, $postedDate) 
    {
        $result = '{
                        "jobID": "' . $jobID . '",
                        "title": "' . $title . '",
                        "companyName": "'. $companyName . '",
                        "description": "'. $description . '",
                        "location": "' . $location . '",
                        "postedDate": "' . $postedDate . '"';
        $result .=  ' }';
        
        return json_decode($result, true);
    }

    private function createFilterQuery($preference, $category)
    {
        $length = count($category);
        $query = "SELECT jobID, title, companyName, location, description, postedDate FROM Job WHERE salary >= $preference[0]";

        for($i=1; $i<$length; $i++){
            if($preference[$i] != NULL or $preference[$i] != ''){
                $query = $query . " AND $category[$i] = '$preference[$i]'";
            }
        }

        return $query;
    }
}
