<?php
/**
 * Created by PhpStorm.
 * User: wildan
 * Date: 9/29/16
 * Time: 10:59 AM
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

    public function addNewBooks($books){
        ksort($books);
        print_r($books);
        $columns = implode(',', array_keys($books));
        print_r($columns);
        $values = ":" . implode(', :', array_keys($books));
        print_r($values);

        $st = $this->db->prepare("INSERT INTO books($columns) VALUES($values);");

        foreach ($books as $k => $v){
            $st->bindValue(":$k", $values);
        }

        $st->execute();

        return $this->db->lastInsertId();
    }

    public function getBooks(){
        return $this->db->query("SELECT * FROM books")->fetchAll(\PDO::FETCH_ASSOC);
    }

}