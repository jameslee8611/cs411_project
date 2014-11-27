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
class board extends Controller {
    
    function __construct() {
        parent::__construct();
        $this->isLoggedIn();
    }
    
    public function jobBoard()
    {
        $this->view->data = $this->model->getJob();
        $this->view->render('board/jobBoard');
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
