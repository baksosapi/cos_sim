<?php

/**
 * Created by PhpStorm.
 * User: wildan
 * Date: 9/29/16
 * Time: 11:57 AM.
 */
namespace Controller;

class Stop_word extends BaseController
{
    public function __construct()
    {
        parent::__construct();
        $this->loadModel('stop_word');
    }

    public function index()
    {
        $this->view->render('stop_word/index');
    }

    public function get()
    {
        $this->view->render('stop_word/get');
    }

    public function lists()
    {
        $type_data = $this->model->listStopWord();

        $this->view->type_data = $type_data;

        $this->view->render('stop_word/lists');
    }

    public function add()
    {
        if (isset($_POST['submit'])) {

//            echo '<script language="javascript">';
//            echo 'alert("message successfully sent")';
//            echo '</script>';

//            header("index.html");
            unset($_POST['submit']);


            $this->view->id = $this->model->addNewStopWord($_POST);
        } else {
            $this->view->render('stop_word/add');
        }
    }
}
