<?php

class Error extends Controller {

    function __construct() {
        parent::__construct();
    }

    function index() {
        $this->view->msg = "error";
        $this->view->render('error/index');
    }
    
    public function login() {
        $this->view->render('error/login');
    }
    
    public function updateInfo() {
        $this->view->render('error/updateInfo');
    }
}