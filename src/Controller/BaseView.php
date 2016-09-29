<?php

/**
 * Created by PhpStorm.
 * User: wildan
 * Date: 9/29/16
 * Time: 12:04 PM
 */
namespace Controller;

class BaseView
{

    /**
     * BaseView constructor.
     */
    public function __construct()
    {

    }

    public function render($name){
        print_r($name);
        require_once "View/layout/header.php";
        require_once "views/".name.".php";
        require_once "View/layout/footer.php";
    }
}