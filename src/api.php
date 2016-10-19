<?php
/**
 * Created by PhpStorm.
 * User: wildan
 * Date: 10/9/16
 * Time: 3:25 PM.
 */
require_once '../config.php';
require_once './Model/BaseModel.php';
require_once './Model/Database.php';
require_once './Model/BooksModel.php';

require_once 'CosineSimilarity.php';

class Api extends \Model\BaseModel {
    private $book;

    public function __construct()
    {
        parent::__construct();

        $this->book = new \Model\BooksModel();
    }

    public function word_processor(){
        $all_book = $this->book->getBooks();

        foreach ($all_book as $key => $val){
            foreach ($val as $k => $v){
                $book_words[$key]['id'] = $val['id_buku'];
                $book_words[$key]['words'] = trim($val['judul_buku'])." ".trim($val['keterangan']);

                $data_words[$key] = $book_words[$key]['words'];
            }
        }

        if (!empty($data_words)) {
            return $data_words;
        }
    }
}

$a = new Api();

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
//print_r($a->word_processor());

$cs = new CosineSimilarity($word_qr, $a->word_processor() );

echo '<pre>';
//$cs->getShowResult();
print_r($cs->getShowResult());