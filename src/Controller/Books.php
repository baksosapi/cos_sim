<?php

/**
 * Created by PhpStorm.
 * User: wildan
 * Date: 9/29/16
 * Time: 11:57 AM
 */
use Controller\BaseController;

class Books extends BaseController
{
    public function __construct()
    {
        parent::__construct();
        $this->loadModel("book");
    }

    public function index(){
        print_r(__FUNCTION__);
        $this->view->render('books/index');
    }
    public function get(){

        $this->view->render('books/get');
    }
}