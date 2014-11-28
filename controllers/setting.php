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
        $this->view->render('setting/index');
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
            header('Location: ' .URL.'jobboard/');
            exit;
        }
        else
        {
            header('Location: ' .URL.'error/login');
            exit;
        }
    }
    
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
            header('Location: ' .URL.'setting');
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
            header('Location: ' .URL.'setting');
            exit;
        }
        else
        {
            header('Location: ' .URL.'error/login');
            exit;
        }
    }
}