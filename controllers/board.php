<?php

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
    
    public function index()
    {
        if (!Session::get('loggedIn'))
        {
            header('Location: ' .URL.'error/login');
            die();
        }
        else if (Session::get('isStudent'))
        {
            $this->jobBoard();
        }
        else
        {
            $this->recruiterBoard();
        }
    }
    
    public function jobBoard()
    {
        if (!Session::get('isStudent')) {
            header('Location: ' .URL.'error/typeError');
        }
        
        $this->view->data = $this->model->getJob();
<<<<<<< HEAD

        //$this->view->like = $this->model->getLikedJob();

=======
//        $this->view->like = $this->model->getLikedJob();
>>>>>>> 4df4d773c19b14692779718aeebd12ffeff404d6
        $this->view->job_data = $this->model->get_applied_job();

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
    
    public function ajax_delete_job_student_relation($jobId, $studentId)
    {
        print_r($this->model->delete_job_student_relation($jobId, $studentId));
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
    
    public function ajax_getHistoryJobById($jobId)
    {
        print_r(json_encode($this->model->getHistoryJobById($jobId)));
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
    
    public function ajax_removeJob($jobId)
    {
        $result = $this->model->removeJob($jobId);
        echo $result;
    }
    
    public function ajax_change_job_process()
    {
        $result = $this->model->change_job_process();
        print_r($result);
    }
}
