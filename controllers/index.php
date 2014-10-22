<?php
/**
 * @author  Seungchul Lee
 * @date    July 5, 2014
 */

class Index extends Controller {

    function __construct() 
    {
        parent::__construct();
    }

    public function index() 
    {   
        $this->view->render('index/index');
    }
    
    public function login() {
        $result = $this->model->login();
        
        if ($result == TRUE)
        {
            header('Location: ' .URL.'jobboard/');
            die();
        }
        else
        {
            header('Location: ' .URL.'error/login');
            die();
        }
    }
}