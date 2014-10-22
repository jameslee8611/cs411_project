<?php

/**
 * Model class.  It will save its db with Database class
 * 
 * @author  Seungchul Lee
 * @date    July 1, 2014
 */

class Model {

    function __construct() {
        $this->db = new Database();
    }

}