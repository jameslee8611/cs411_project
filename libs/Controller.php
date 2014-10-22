<?php

/**
 * Controller class is a neccessary part of MVC structure.
 * 
 * @author  Seungchul Lee
 * @date    July 1, 2014
 */

class Controller {
    
    function __construct() {
        $this->view = new View();
    }

    /**
     * load module classs will include controller's model and set in the model in MVC
     * @param string $name model name
     */
    public function loadModule($name) {
        $path = 'models/'. $name . '_model.php';
        
        if (file_exists($path))
        {
            require 'models/'. $name . '_model.php';
            $modelName = $name . '_Model';
            $this->model = new $modelName;
        }
    }
    
    /**
     * It will redirect to error page
     */
    protected function redirect_error()
    {
        require 'controllers/error.php';
        $controller = new Error();
        $controller->index();
        return false;
    }
}