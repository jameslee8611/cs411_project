<?php

class company extends Controller {
    
    function __construct() {
        parent::__construct();
        $this->isLoggedIn();
    }

    public function company()
    {
    	if (!Session::get('isStudent')) {
            header('Location: ' .URL.'error/typeError');
        }
        
        $this->view->data = $this->model->getCompany();
        $this->view->like = $this->model->getLikedCompany();
        $this->view->render('board/companyBoard');
    }

    public function ajax_findCompanyById()
    {
        print_r(json_encode($this->model->findCompanyById()));
    }

    public function ajax_likeCompany()
    {
        $this->model->likeCompany();
    }

    public function ajax_dislikeCompany()
    {
        $this->model->dislikeCompany();
    }

    private function isLoggedIn()
    {
        if (!Session::get('loggedIn'))
        {
            header('Location: ' .URL.'error/login');
            exit;
        }
    }

}