<?php

/**
 * Created by PhpStorm.
 * User: wildan
 * Date: 9/29/16
 * Time: 12:00 PM
 */
namespace Controller;

abstract class BaseController
{

    public function __construct()
    {
        $this->view = new BaseView();
        $this->logger = new BaseLogger();
        $this->cache = new BaseCache();
        Session::init();
    }

    public function loadModel($name){

        $modelName = ucfirst($name);
        $path = 'src/Model/'.$modelName.'Model.php';

        if (file_exists($path)){


//            require_once($path);

            $modelName = "\\Model\\".$modelName."Model";

            $this->model = new $modelName();

        } else {
            echo "Model not found!";
        }


    }
}