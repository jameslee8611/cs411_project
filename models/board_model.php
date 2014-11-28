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
