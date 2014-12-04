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
        if (!Session::get('isStudent')) {
            header('Location: ' .URL.'error/typeError');
        }
        
        $this->view->data = $this->model->getJob();
        $this->view->like = $this->model->getLikedJob();
        $this->view->render('board/jobBoard');
    }
    
    public function recruiterBoard()
    {
        if (Session::get('isStudent')) {
            header('Location: ' .URL.'error/typeError');
        }
        
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
    
    public function ajax_getJobById($jobId)
    {
        print_r(json_encode($this->model->getJobById($jobId)));
    }

    public function ajax_applyJob()
    {
        $status = $this->model->applyJob();
        print_r($status);
    }
    
    public function ajax_updateProgressStatus($jobId, $studentId, $status)
    {
        if (!Session::get('isStudent')) {
            $result = $this->model->updateProgressStatus($jobId, $studentId, $status);
            echo $result;
        }
        else {
            echo "Invalid Access!";
        }
    }

    public function addJobPost()
    {
        $result = $this->model->addJobPost();
        print_r($result);
    }
}
