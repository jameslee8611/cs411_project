<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of signup
 *
 * @author jameslee8611
 */
class signup extends Controller {

    function __construct() {
        parent::__construct();
    }
    
	function post_to_url($url, $data) {

		$post = curl_init();

		curl_setopt($post, CURLOPT_URL, $url);
		curl_setopt($post, CURLOPT_POST, 1);
		curl_setopt($post, CURLOPT_POSTFIELDS, $data);
		curl_setopt($post, CURLOPT_RETURNTRANSFER, 0);

		$result = curl_exec($post);

		curl_close($post);

		return $result;
	}

    public function index() {
        $this->view->render('signup/index');
    }

    public function signup(){
    	$status = $this->model->signup();
    	if($status){
			$result = $this->post_to_url(URL.'index/login', $status);
			header('Location: ' .URL.'index/login');
			die();
    	}
    	else{
    		header('Location: ' .URL.'error/login');
    		die();
    	}
    }

}
