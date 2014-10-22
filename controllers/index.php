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
}