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
        $statement = $this->db->prepare("
            SELECT title, companyName
            FROM Job
            WHERE 1
        ");

        $success = $statement->execute();
        
        $result = array();
        
        if ($success) {
            $query = $statement->fetchAll();

            foreach ($query as $row) 
            {
                array_push($result, $this->formatter($row['title'], $row['companyName']));
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
    
    private function formatter($title, $companyName) 
    {
        $result = '{
                        "title": "' . $title . '",
                        "companyName": "'. $companyName . '"';
        $result .=  ' }';
        
        return json_decode($result, true);
    }
}