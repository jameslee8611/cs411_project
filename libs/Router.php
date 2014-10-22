<?php

/**
 * Router class gets url and handle to use methods in each controller
 * 
 * @author  Seungchul Lee
 * @date    July 1, 2014
 */

class Router {

    function __construct() {
        $url = explode('/', rtrim(isset($_GET['url']) ? $_GET['url'] : null, '/'));
        Session::init();
        
        if (empty($url[0]))
        {
            require 'controllers/index.php';   
            $controller = new Index;
            $controller->loadModule('index');
        }
        else
        {
            $file = 'controllers/' . $url[0] . '.php';
            if (file_exists($file)) 
            {
                require $file;
                $controller = new $url[0];
                $controller->loadModule($url[0]);
            }
            else
            {
                $this->redirect_to_error();
            }
        }
        
        if (count($url) > 5)
        {
            $this->redirect_to_error();
        }
        elseif (isset ($url[4]))
        {
            if (method_exists($controller, $url[1]))
            {
                $controller->{$url[1]}($url[2], $url[3], $url[4]);
            }
            else
            {
                $this->redirect_to_error();
            }
        }
        elseif (isset($url[3]))
        {
            if (method_exists($controller, $url[1]))
            {
                $controller->{$url[1]}($url[2], $url[3]);
            }
            else
            {
                $this->redirect_to_error();
            }
        }
        elseif (isset($url[2])) 
        {
            if (method_exists($controller, $url[1]))
            {
                $controller->{$url[1]}($url[2]);
            }
            else
            {
                $this->redirect_to_error();
            }
        } 
        elseif (isset($url[1])) 
        {
            if (method_exists($controller, $url[1]))
            {
                $controller->{$url[1]}();
            }
            else
            {
                $this->redirect_to_error();
            }
        }
        else
        {
            $controller->index();
        }
    }
    
    /**
     * make error page
     */
    private function redirect_to_error()
    {
        require 'controllers/error.php';
        $controller = new Error();
        $controller->index();
        
        exit;
    }
}
