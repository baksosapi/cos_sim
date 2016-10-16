<?php

class Bootstrap{

    public function __construct(){

        (new \Controller\Books()) -> index();
    }
}