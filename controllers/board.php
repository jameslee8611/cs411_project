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
    
    public function recruiterBoard()
    {
        $this->view->userInfo = $this->model->getUserInfo();
        $this->view->companyInfo = $this->model->getCompanyInfo();
        $this->view->data = $this->model->getJobRecruiter();
        $this->view->render('board/recruiterBoard');
    }
    
    private function isLoggedIn()
    {
        if (!Session::get('loggedIn'))
        {
            header('Location: ' .URL.'error/login');
            die();
        }
    }

    public function ajax_getJobList()
    {
        print_r(json_encode($this->model->getJob()));
    }

    public function ajax_findJobById()
    {
        print_r(json_encode($this->model->findJobById()));
    }
}
