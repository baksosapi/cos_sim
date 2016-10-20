<?php
/**
 * Created by PhpStorm.
 * User: wildan
 * Date: 10/1/16
 * Time: 3:21 PM.
 */
namespace Controller;

use CosineSimilarity;
use Model\SearchModel;
use ShowDisplay;

class Search extends BaseController
{
    public function __construct()
    {
        parent::__construct();
        $this->loadModel('search');
    }

    public function index_old()
    {
        $search_data = $this->model->wordsProcessor();
//        echo '<pre>';print_r(sizeof($search_data[0]));
//        echo '<pre>';print_r($search_data);
//        $this->view->seach_data = $search_data;

        foreach ($search_data[0] as $k => $v) {
            $data_num[] = $search_data[0][$k]['keterangan'];
//            $data_num[] = $search_data[0][$k]['id_buku'];
        }

//        $data_str = $data_num;

        $qr[] = $search_data[1];

//        echo '<pre>';print_r($data_num);
//        $d[0] = "Shipment of gold,damaged in a fire";
//        $d[0] = "Shipment of gold,damaged in 1 200 3 10 10/7 a fire";
//        $d[1] = "Delivery of silver arrived in a silver truck";
//        $d[2] = "Shipment of gold arrived in a truck";
//        $d[3] = "Delivery and Shipment of gold arrived from a truck";

        $d[0] = 'Algoritma dan Teknik Pemrograman';
        $d[1] = 'konsep dan aplikasi sistem pendukung keputusan';
        $d[2] = 'sistem neuro fuzzy canggih';
        $d[3] = 'pengantar struktur data dan algoritma';
        $d[4] = 'pengantar logika informatika algoritma';
//        echo '<pre>';print_r($d);
//        echo '<pre>';print_r($qr);

//        $cs = new CosineSimilarity($d,$qr);

        $cs = new CosineSimilarity($qr, $d);

// =========================================================================================
//        Use Database
//        $cs = new CosineSimilarity($data_num,$qr);
//        $cs = new CosineSimilarity($qr, $data_num);

//        Show The result
        $tableShow = new ShowDisplay($cs);

//        echo '<pre>'; print_r($tableShow);

//        $ts = $tableShow->TableShow();

//# SHOW RESULT As List
//        $tsr = $tableShow->TableShowResult();

        $this->view->a = 'aaaaaaaa';

        $this->view->cs = $cs;

        $this->view->render('search/get');
    }

    public function index()
    {

        $a = $this->model->word_processor();


        header('Content-type: text/html; charset=utf-8');

        if (!empty($_GET['q'])) {
            $search = $_GET['q'];
            $search = addslashes($search);
            $search = htmlspecialchars($search);
            $search = stripslashes($search);
            $word_qr[] = $search;
            $words = preg_split('/[[:space:],]+/', $search);  // Parse into Words
        } else {
            die('<h3>Masukkan kata kunci yang dicari...</h3>');
        }

        $cs = new CosineSimilarity($word_qr, $a );

//        $a = $this->model->getBooksBlurb();

        foreach ($a as $k => $v) {
//            foreach ($v as $key => $val) {
//                $res[$k] = $v['judul_buku'];
                $res[$k] = $v;

//            }
        }

//        $this->view->res = $this->model->getBooksBlurb();
        $this->view->res = $cs->getShowResult();
//        $this->view->res = $cs->showResult();

//      Show Result with Form as List
        $tableShow = new ShowDisplay($cs);
        $tableShow->TableShow();
        $this->view->render('search/get');

//      SHOW RESULT
        $tableShow->TableShowResult();
//        $this->view->res_table = $tableShow;
//        (!($mod === 'api')) ? $this->view->render('search/get') : null;
    }
}
