<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of jobboard
 *
 * @author jameslee8611
 */
class jobboard extends Controller {
    
    function __construct() {
        parent::__construct();
        $this->isLoggedIn();
    }
    
    public function index()
    {
        $this->view->data = $this->model->getJob();
        $this->view->render('jobboard/index');
    }
    
    private function isLoggedIn()
    {
        if (!Session::get('loggedIn'))
        {
            header('Location: ' .URL.'error/login');
            die();
        }
    }
}
