<?php
/**
 * Created by PhpStorm.
 * User: wildan
 * Date: 9/29/16
 * Time: 10:59 AM.
 */
namespace Model;

class BooksModel extends BaseModel
{
    //    protected $book_title;
//    private $book_author;
//    protected $book_subtitle;
//    protected $book_publisher;
//    protected $book_isbn;
//    protected $book_year;
//    protected $book_edition;
//    protected $book_page;
//    protected $book_blurb;

    public function __construct()
    {
        parent::__construct();
    }

    public function addNewBooks($book)
    {
        ksort($book);
//        print_r($books);
        $columns = implode(',', array_keys($book));
//        print_r($columns);
        $values = ':'.implode(', :', array_keys($book));
//        print_r($values);

        $st = $this->db->prepare("INSERT INTO book($columns) VALUES($values);");

//        print_r($book['blurb']);

//        $words[] = preg_split('/((^\p{P}+)|(\p{P}*\s+\p{P}*)|(\p{P}+$))/', $book['blurb'], -1, PREG_SPLIT_NO_EMPTY);
//        echo '<pre>';print_r($words);

//        $col = implode(',', array_keys($words));
//        $val = implode(', :', array_keys($words));
//        $st_word = $this->db->prepare("INSERT INTO word($col) VALUES($val);");


        foreach ($book as $k => $v) {
            $st->bindValue(":$k", $v);
        }

        $st->execute();

        return $this->db->lastInsertId();
    }

    public function getBooks()
    {
        return $this->db->query('SELECT * FROM book')->fetchAll(\PDO::FETCH_ASSOC);
    }
}
