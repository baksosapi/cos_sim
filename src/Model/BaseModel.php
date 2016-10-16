<?php
/**
 * Created by PhpStorm.
 * User: wildan
 * Date: 9/29/16
 * Time: 3:53 PM.
 */
namespace Model;

abstract class BaseModel
{
    public function __construct()
    {
        $this->db = new Database(DB_VENDOR, DB_HOST, DB_NAME, DB_USER, DB_PASSWD);
    }
}
