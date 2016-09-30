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
        else {
            $url = $_GET['url'];
//            $url_do = $_GET['do'];
        }

        if (!empty($url)) {
            $url = explode("/", $url);
//            $controller_name = $url;
        }

//        print_r($url);

        // Check if url empty

        if (empty($url[0])) {
            // set default controller
            $url[0] = "Books";
            $file_controller = "src/Controller/".$url[0].".php";

            require_once ($file_controller);

            (new Books()) ->index();

            return false;

        }

        $file_controller = "src/Controller/".ucfirst($url[0]).".php";

        if (!file_exists($file_controller)){
             echo "File doesn't exist.";
            return false;
        }

        require_once $file_controller;

        $controller = "\\Controller\\".ucfirst($url[0]);

        if(!empty($url[1])){
//            print_r($controller);
            if (isset($controller)) {
//                $controller -> index();
                if (isset($url[1])) {
                    if($url[1] == 'add'){
                        (new $controller()) -> add();
                    } else {
                        (new $controller()) -> index();
                    }
                } else {

                    (new $controller()) -> index();

                }
            } else {
                echo 'Controller Not Found';
            }
            return false;
        } else {
            (new $controller()) -> index();
        }

    }
}