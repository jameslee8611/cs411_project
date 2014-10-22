<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Error extends Controller {

    function __construct() {
        parent::__construct();
    }

    function index() {
        $this->view->msg = "error";
        $this->view->render('error/index');
    }
}