<?php
/**
 * @author  Seungchul
 * @date    July 2, 2014
 */

class Setting extends Controller {

    function __construct() {
        parent::__construct();
        
        if(Session::get('loggedIn') == null)
        {
            $this->view->render('error/index');
            exit;
        }
    }

    public function index()
    {
        $this->view->render('setting/index');
    }
}