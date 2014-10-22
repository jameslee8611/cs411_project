<?php

/**
 * Cookie class is static class
 * 
 * @author  Seungchul
 * @date    July 5, 2014
 */

class Cookie {
    
    public static function set($name, $value)
    {
        setcookie($name, $value, time() + 60*60*24*30, '/');
    }
    
    public static function get($name)
    {
        if (!isset($_COOKIE[$name]) || empty($_COOKIE[$name]))
        {
            return false;
        }
        
        return $_COOKIE[$name];
    }

    public static function remove($name)
    {
        setcookie($name, "", time() - 60*60*24*30);
    }
}