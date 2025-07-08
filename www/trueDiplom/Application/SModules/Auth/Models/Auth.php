<?php

namespace Auth\Models;

use Core\SApplication;
use Models\SCommon;
use PDO;

class Auth extends \Core\SModel
{

    public function __construct(bool $paginatorEnabled = true)
    {

        parent::__construct($paginatorEnabled);
    }

    public function auth(string $login, string $password): bool
    {
        $sql_q = "SELECT `password`, `name`, `surname`, `id` FROM `data_users` WHERE `login` = ".SApplication::$DB->quote($login);
        $res = \Core\SApplication::$DB->query($sql_q)->fetchAll(PDO::FETCH_ASSOC);

        if(empty($res)) {
            return false;
        }

        if (base64_encode(\Models\SCommon::encrypt($password)) === $res[0]['password']) {
            $_SESSION['auth'] = true;
            $_SESSION['user'] = $res[0]['id'];
            $_SESSION['name'] = $res[0]['name'];
            $_SESSION['surname'] = $res[0]['surname'];
            if($res[0]['id'] === 1) {
                $_SESSION['admin'] = 1;
            } else {
                $_SESSION['admin'] = 0;
            }
            return true;
        } else {
            return false;
        }
    }
}