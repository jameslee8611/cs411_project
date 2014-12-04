<?php

class Index extends Controller {

    function __construct() 
    {
        parent::__construct();
    }

    // public methods
    
    public function index() 
    {   
        if (Session::get('loggedIn'))
        {
            $this->redirecttoJobBoard(Session::get('isStudent'));
        }
        
        $this->view->render('index/index');
    }
    
    public function login() {
        $result = $this->model->login();
        
        if ($result == TRUE)
        {
            $this->redirecttoJobBoard(Session::get('isStudent'));
        }
        else
        {
            header('Location: ' .URL.'error/login');
            exit;
        }
    }
    
    public function logout() {
        Session::destroy();
        
        header('Location: ' .URL);
        exit;
    }
    
    public function signup() {
        $status = $this->model->signup();
        
        if ($status) 
        {
            $this->login();
        } 
        else 
        {
            header('Location: ' . URL . 'error/login');
            die();
        }
    }
    
    // private methods
    
    private function redirecttoJobBoard($isStudent)
    {
        if ($isStudent) {
            header('Location: ' .URL.'board/jobBoard');
        }
        else {
            header('Location: ' .URL.'board/recruiterBoard');
        }
        exit;
    }
}