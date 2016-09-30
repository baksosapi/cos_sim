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
        require_once "src/View/layout/header.php";
        require_once "src/View/".$name.".php";
        require_once "src/View/layout/footer.php";
    }
}