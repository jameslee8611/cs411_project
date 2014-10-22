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
    
    function index() {
        $this->view->render('signup/index');
    }
    
    function login() {
        $result = $this->model->login();
        $this->view->data = $result;
        $this->view->render('signup/login');
    }
}
