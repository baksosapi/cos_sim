<?php
/**
 * Created by PhpStorm.
 * User: wildan
 * Date: 10/1/16
 * Time: 3:21 PM
 */

namespace Controller;


class Search extends BaseController
{
    public function __construct()
    {
        parent::__construct();
        $this->loadModel('search');
    }

    public function index(){

    }

}