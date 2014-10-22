<?php
/**
 * @author  Seungchul
 * @date    July 2, 2014
 */

class Setting extends Controller {

    function __construct() {
        parent::__construct();
    }

    public function index()
    {
        $this->view->render('setting/index');
    }
}