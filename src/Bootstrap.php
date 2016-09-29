<?php

/**
 * Created by PhpStorm.
 * User: wildan
 * Date: 9/29/16
 * Time: 11:50 AM
 */
class Bootstrap
{

    /**
     * Bootstrap constructor.
     */
    public function __construct()
    {

        if (!isset($_GET['url'])){
            $url = 'books';
        }

        if (!empty($url)) {
            $controller_name = $url;
        }
        $file_controller = "Controller/".$url.".php";

        require_once ($file_controller);

        if (!empty($controller_name)) {
            $controller = new $controller_name;
        }

        if(empty($url[1])){
            if (isset($controller)) {
                $controller->index();
            }
            return false;
        }

        echo '<pre>';print_r($controller);
    }
}