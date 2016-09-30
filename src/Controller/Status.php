<?php
/**
 * Created by PhpStorm.
 * User: wildan
 * Date: 9/29/16
 * Time: 9:47 PM
 */

namespace Controller;


class Status extends BaseController
{
    public function __construct()
    {
        parent::__construct();
        $this->loadModel('status');
    }

    public function index(){
        $this->view->render("status/index");
    }

}