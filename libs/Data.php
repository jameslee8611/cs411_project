<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Data {
    
    static $username;
    
    function __construct() {
        
    }


    static function setUsername($username)
    {
        self::$username = $username;
    }
    
    static function getUsername()
    {
        return self::$username;
    }

}