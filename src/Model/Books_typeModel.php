<?php
/**
 * Created by PhpStorm.
 * User: wildan
 * Date: 9/29/16
 * Time: 10:59 AM.
 */
namespace Model;

class Books_typeModel extends BaseModel
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

    public function addNewBooksType($booksType)
    {
        ksort($booksType);
//        print_r($booksType);
        $columns = implode(',', array_keys($booksType));
//        print_r($columns);
        $values = ':'.implode(',:', array_keys($booksType));
//        print_r($values);

        $st = $this->db->prepare("INSERT INTO books_type($columns) VALUES($values);");

        foreach ($booksType as $k => $v) {
            $st->bindValue(":$k", $v);
        }

        $st->execute();

        return $this->db->lastInsertId();
    }

    public function listBooksType()
    {
        return $this->db->query('SELECT * FROM books_type')->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getBooks()
    {
        return $this->db->query('SELECT * FROM books_type')->fetchAll(\PDO::FETCH_ASSOC);
    }
}
