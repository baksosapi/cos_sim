<?php

/**
 * Created by PhpStorm.
 * User: wildan
 * Date: 9/29/16
 * Time: 12:04 PM
 */
namespace Controller;

class Session
{

    public static function init()
    {
        @session_start();
    }

    public static function set($key, $value)
    {
        $_SESSION[$key] = $value;
    }

    public static function get($key)
    {
        if(isset($_SESSION[$key])){
            return $_SESSION[$key];
        }
        else{
            return false;
        }
    }

    public static function destroy()
    {
        session_destroy();
    }

}

