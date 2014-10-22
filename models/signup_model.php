<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of signup_model
 *
 * @author jameslee8611
 */
class signup_model extends Model {
    function __construct() {
        parent::__construct();
    }

    public function signup(){
    	$email = $_POST['email'];
    	$password = md5($_POST['password']);
    	$position = $_POST['position'];

    	$query = "INSERT INTO $position (email, password) VALUES('$email', '$password')";
    	$statement = $this->db->prepare($query);
    	$success = $statement->execute();

    	if($success)
            return TRUE;    
        else 
            return NULL;
    }

}
