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

        (!isset($_GET['mod'])) ? $mod = 0 : $mod = $_GET['mod'];

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
//             echo "File doesn't exist.";
            echo "<img src=\"assets/img/404.jpg\" alt=\"Page Not Found (404).\" style=\"position: absolute; left: 50%; top: 50%; margin-left: -285px; margin-top: -190px;\">";
            echo "<a href=\"./\">Home</a>";
            return false;
        }

        require_once $file_controller;

        $controller = "\\Controller\\".ucfirst($url[0]);

//        print_r($url);
//        print_r($mod);


        if(!empty($url[1])){
//            print_r($controller);
            if (isset($controller)) {
//                $controller -> index();
//                print_r($controller);
                if (isset($url[1])) {
//                    if($url[1] == 'add'){
//                        (new $controller()) -> add();
//                    } else {
//                        (new $controller()) -> index();
//                    }
                    (new $controller) -> $url[1]();

                } else {

                    (new $controller()) -> index();

                }
            } else {
                echo 'Controller Not Found';
            }
//            return false;

        } else if(isset($_GET['q'])){
//            print_r($controller);
            (new \Controller\Search()) -> index($mod);
        } else {
            (new $controller()) -> index();
        }

    }
}