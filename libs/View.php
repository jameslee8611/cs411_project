<?php

/**
 * View class will redner header and footer in each page.
 * One neccessary part of MVC structure
 * 
 * @author  Seungchul Lee
 * @date    July 1, 2014
 */

class View {

    function __construct() {
        
    }

    public function render($name, $headerIncludes = false) {
        if($headerIncludes == true)
        {
            require 'views/' . $name . '.php';
        }
        else
        {
            require 'views/header.php';
            // include each css file
            ?><style><?php
                $file = 'public/css/' . $name . '.css';
                if (file_exists($file)) 
                {
                    require $file;
                }
            ?></style><?php
            require 'views/' . $name . '.php';
            
            $php_js_file = 'public/js/php/' . $name . '.php';
            if (file_exists($php_js_file))
            {
                require $php_js_file;
            }
            require 'views/footer.php';
        }
    }
}