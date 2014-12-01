<?php
/**
 * @author  Seungchul
 * @date    July 2, 2014
 */

class Setting extends Controller {

    function __construct() {
        parent::__construct();
        $this->isLoggedIn();
    }

    public function index()
    {
        if (Session::get('isStudent')) {
            $this->view->profile = $this->model->getProfile(Session::get('userId'));
            $this->view->preference = $this->model->getPreference(Session::get('userId'));
            $this->view->render('setting/studentSet');
        }
        else {
            $this->view->companyList = $this->model->getCompanyList(Session::get('isStudent'));
            $this->view->render('setting/recruiterSet');
        }
    }
    
    public function withdrawAccount()
    {
        $result = $this->model->withdrawAccount();
        
        if ($result)
        {
            header('Location: ' .URL.'index/logout');
            exit;
        }
        else
        {
            header('Location: ' .URL.'error/login');
            exit;
        }
    }
    
    public function changePassword()
    {
        $result = $this->model->changePassword();
        
        if ($result == TRUE)
        {
            header('Location: ' .URL.'board/jobboard/');
            exit;
        }
        else
        {
            header('Location: ' .URL.'error/login');
            exit;
        }
    }
    
    public function updateRecruiterInfo()
    {
        $result = $this->model->updateRecruiterInfo();
        
        if ($result == TRUE)
        {
            header('Location: ' .URL.'board/recruiterBoard/');
            exit;
        }
        else
        {
            header('Location: ' .URL.'error/updateInfo');
            exit;
        }
    }
    
    public function addCompany()
    {
        $result = $this->model->addCompany();
        echo $result;
    }
    
    // private functions
    
    private function isLoggedIn()
    {
        if (!Session::get('loggedIn'))
        {
            header('Location: ' .URL.'error/login');
            exit;
        }
    }

    public function updatePreference()
    {
        $result = $this->model->updatePreference();

        if ($result)
        {
            header('Location: ' .URL.'board/jobboard/');
            exit;
        }
        else
        {
            header('Location: ' .URL.'error/login');
            exit;
        }
    }

    public function updateProfile()
    {
        $result = $this->model->updateProfile();

        if ($result)
        {
            //header('Location: ' .URL.'setting');
            if($result){
                echo("Update Successful!");
            }else{
                echo("Failed to Update!");
            }
            exit;
        }
        else
        {
            header('Location: ' .URL.'error/login');
            exit;
        }
    }
}