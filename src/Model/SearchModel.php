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

//        $this->wordsProcessor();

    }

    public function wordsProcessor()
    {
        header("Content-type: text/html; charset=utf-8");
        if (!empty($_POST['search'])) {

            $search = $_POST['search'];
            $search = addslashes($search);
            $search = htmlspecialchars($search);
            $search = stripslashes($search);
            $word_qr = $search;
            $words  = preg_split("/[[:space:],]+/", $search);  // Parse into Words

        } else {
            die("<h3>Masukkan kata kunci yang dicari...</h3>");
        }

//        $a = $this->db->query("SELECT * FROM book")->fetchAll(\PDO::FETCH_ASSOC);

        $a = $this->db->query("SELECT * FROM buku;")->fetchAll(\PDO::FETCH_ASSOC);

//        $a =  $this->db->query("SELECT * FROM bukuku;")->fetchAll(\PDO::FETCH_ASSOC);

        $b = $word_qr;

        $res = [$a, $b];

        return $res;

    }

}