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

        $statement = $this->db->prepare("
            SELECT * FROM PREFERENCE WHERE uID = '$uID'
        ");
        $success = $statement->execute();
        $preference = $statement->fetch();

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
            echo 'Error occurred while getting Wall!<br /><br />';
            exit;
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
