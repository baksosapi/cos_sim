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

    public function __construct()
    {
        parent::__construct();
    }

    public function addNewStopWord($stopWord)
    {
        ksort($stopWord);
        $columns = implode(',', array_keys($stopWord));
        $values = ':'.implode(',:', array_keys($stopWord));

        $st = $this->db->prepare("INSERT INTO books_type($columns) VALUES($values);");

        foreach ($stopWord as $k => $v) {
            $st->bindValue(":$k", $v);
        }

        $st->execute();

        return $this->db->lastInsertId();
    }

    public function liststopWord()
    {
        return $this->db->query('SELECT * FROM stop_word')->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getBooks()
    {
        return $this->db->query('SELECT * FROM stop_word')->fetchAll(\PDO::FETCH_ASSOC);
    }
}
