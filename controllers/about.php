<?php
/**
 * @author  Seungchul Lee
 * @date    August 16, 2014
 */

class About extends Controller {

    function __construct() {
        parent::__construct();
    }

    function index() {
        $this->view->render('about/index');
    }
}
