<?php
/**
 * Created by PhpStorm.
 * User: wildan
 * Date: 9/29/16
 * Time: 11:57 AM.
 */
namespace Controller;

use Model\Books_typeModel;

class Books extends BaseController
{
    public function __construct()
    {
        parent::__construct();
        $this->loadModel('books');
    }

    public function index()
    {
        $this->view->render('books/index');
    }

    public function get()
    {
        $this->view->render('books/get');
    }

    public function add()
    {
        if (isset($_POST['submit'])) {

//            echo '<script language="javascript">';
//            echo 'alert("message successfully sent")';
//            echo '</script>';

//            header("index.html");
            unset($_POST['submit']);

            $this->view->id = $this->model->addNewBooks($_POST);
        }
        $type_data = (new Books_typeModel())->listBooksType();

        $this->view->type_data = $type_data;

        $this->view->render('books/add');
    }
}
