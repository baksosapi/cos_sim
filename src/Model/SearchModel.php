<?php
/**
 * Created by PhpStorm.
 * User: wildan
 * Date: 10/1/16
 * Time: 3:20 PM
 */

namespace Model;


class SearchModel extends BaseModel
{
    public function __construct()
    {
        parent::__construct();
//        print_r(__CLASS__);

        $this->wordsProcessor();
    }

    private function wordsProcessor()
    {
        header("Content-type: text/html; charset=utf-8");
        if (!empty($_POST['search'])) {
            $search = $_POST['search'];
            $search = addslashes($search);
            $search = htmlspecialchars($search);
            $search = stripslashes($search);
            $words  = preg_split("/[[:space:],]+/", $search);  // Parse into Words
            print_r($words);
        } else {
            die("<h3>Masukkan kata ...</h3>");
        }

    }

}