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
class jobboard_model extends Model {
    
    function __construct() {
        parent::__construct();
    }

    function getjob(){
    	$result = array();
    	$query = 'SELECT description, companyName, title, salary, type FROM job';
    	$statement = $this->db->prepare($query);
    	$success = $statement->execute();
    	$temp = $statement->fetchAll();
    	foreach ($temp as $row) {
    		array_push($result, array('title' => $row['title'], 'description' => $row['description'], 'company' => $row['companyName'], 'salary'=> $row['salary'], 'type'=>$row['type']));
    	}
    	return $result;
    }
}
