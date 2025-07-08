<?php

namespace Core;

use PDO;
use PDOException;

class SDatabase extends PDO
{
    public function __construct(string $mysql_host, string $mysql_db_name, string $mysql_user, string $mysql_pass, string $mysql_port = null)
    {
        $dsn = 'mysql:host=' . $mysql_host . ';dbname=' . $mysql_db_name .(!is_null($mysql_port) ? (';port='.$mysql_port) : '');

//        var_dump($dsn);exit;
        $user = $mysql_user;
        $password = $mysql_pass;
        parent::__construct($dsn, $user, $password, [PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'UTF8'", PDO::MYSQL_ATTR_LOCAL_INFILE => true]);
        $this->query('SET SESSION group_concat_max_len = ~0;');
    }
}