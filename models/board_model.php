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
    
    private function formatter($title, $companyName) 
    {
        $result = '{
                        "title": "' . $title . '",
                        "companyName": "'. $companyName . '"';
        $result .=  ' }';
        
        return json_decode($result, true);
    }
}
