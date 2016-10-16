<?php
/**
 * Created by PhpStorm.
 * User: wildan
 * Date: 9/29/16
 * Time: 3:55 PM.
 */
namespace Model;

use PDO;

class Database extends PDO
{
    /**
     * Database constructor.
     *
     * @param string $DB_VENDOR
     * @param string $DB_HOST
     * @param string $DB_NAME
     * @param $DB_USER
     * @param $DB_PASSWD
     */
    public function __construct($DB_VENDOR, $DB_HOST, $DB_NAME, $DB_USER, $DB_PASSWD)
    {
        parent::__construct($DB_VENDOR.':host='.$DB_HOST.';dbname='.$DB_NAME, $DB_USER, $DB_PASSWD);
    }
}
