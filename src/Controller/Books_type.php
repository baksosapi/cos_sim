<?php

/**
 * Created by PhpStorm.
 * User: wildan
 * Date: 9/29/16
 * Time: 11:57 AM.
 */
namespace Controller;

class Books_type extends BaseController
{
    public function __construct()
    {
        parent::__construct();
        $this->loadModel('books_type');
    }

    public function index()
    {
        $this->view->render('books_type/index');
    }

    public function get()
    {
        $this->view->render('books_type/get');
    }

    public function lists()
    {
        $books = $this->model->listBooksType();

        $this->view->type_data = $books;

        $this->view->render('books_type/lists');
    }

    public function add()
    {
        if (isset($_POST['submit'])) {

//            echo '<script language="javascript">';
//            echo 'alert("message successfully sent")';
//            echo '</script>';

//            header("index.html");
            unset($_POST['submit']);


            $this->view->id = $this->model->addNewBooksType($_POST);
        } else {
            $this->view->render('books_type/add');
        }
    }
}
