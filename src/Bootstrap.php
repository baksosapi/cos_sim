<?php

class Bootstrap
{
    public function __construct()
    {
        if(isset($_GET['q'])){
            (new \Controller\Search())->index();
        } else {
            (new \Controller\Books())->index();
        }
    }

    public function controllerExist(){
        $url[0] = "a";

        $file_controller = 'src/Controller/'.ucfirst($url[0]).'.php';

        if (!file_exists($file_controller)) {
            //             echo "File doesn't exist.";
            echo '<img src="assets/img/404.jpg" alt="Page Not Found (404)." style="position: absolute; left: 50%; top: 50%; margin-left: -285px; margin-top: -190px;">';
            echo '<a href="./">Home</a>';

            return false;
        }

        if (!empty($file_controller)) {
            require_once $file_controller;
        }

    }
}
