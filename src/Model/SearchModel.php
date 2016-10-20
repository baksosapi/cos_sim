<?php
/**
 * Created by PhpStorm.
 * User: wildan
 * Date: 10/1/16
 * Time: 3:20 PM.
 */
namespace Model;

class SearchModel extends BaseModel
{
    public function __construct()
    {
        parent::__construct();
        $this->book = new \Model\BooksModel();

//        $this->wordsProcessor();
    }

    public function getBooksBlurb()
    {
        $a = $this->db->query('SELECT * FROM buku;')->fetchAll(\PDO::FETCH_ASSOC);

        return $a;
    }

    public function wordsProcessor()
    {
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

//        $a = $this->db->query("SELECT * FROM book")->fetchAll(\PDO::FETCH_ASSOC);

        $a = $this->db->query('SELECT * FROM buku;')->fetchAll(\PDO::FETCH_ASSOC);

//        $a =  $this->db->query("SELECT * FROM bukuku;")->fetchAll(\PDO::FETCH_ASSOC);

        $b = $word_qr;

        $res = [$a, $b];

        return $this->res = $res;
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
