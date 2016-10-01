<?php
/**
 * Created by PhpStorm.
 * User: wildan
 * Date: 10/1/16
 * Time: 3:21 PM
 */

namespace Controller;


use CosineSimilarity;
use ShowDisplay;

class Search extends BaseController
{
    public function __construct()
    {
        parent::__construct();
        $this->loadModel('search');
    }

    public function index(){
        $search_data = $this->model->wordsProcessor();
//        echo '<pre>';print_r(sizeof($search_data[0]));
//        echo '<pre>';print_r($search_data);
//        $this->view->seach_data = $search_data;

        foreach ($search_data[0] as $k => $v) {
            $data_num[] = $search_data[0][$k]['keterangan'];
        }

        $data_str = $data_num;

        $qr[] = $search_data[1];

//        echo '<pre>';print_r($data_num);
//        $d[0] = "Shipment of gold,damaged in a fire";
//        $d[1] = "Delivery of silver arrived in a silver truck";
//        $d[2] = "Shipment of gold arrived in a truck";
//        $d[3] = "Delivery and Shipment of gold arrived from a truck";
//        echo '<pre>';print_r($d);
//        echo '<pre>';print_r($qr);
//        $cs = new CosineSimilarity($d,$qr);

        $cs = new CosineSimilarity($data_num,$qr);

        $tableShow = new ShowDisplay($cs);
        $tableShow->TableShow();

// SHOW RESULT
        $tableShow->TableShowResult();
    }

}