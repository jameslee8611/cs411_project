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
        
    }
    
    public function modifyInfo()
    {
        
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