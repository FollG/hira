<?php

namespace Users\Models;

use Core\SApplication;
use Core\SModel;
use Matrix\Exception;
use PDO;

class Users extends SModel
{
    public function __construct(bool $paginatorEnabled = true)
    {
        parent::__construct($paginatorEnabled);
    }

    public function get(int $user_id = null): ?array
    {
        $where = [];

        if ($user_id) {
            $where[] = " u.`id` = ".$user_id;
        }

        $sql_q = "SELECT u.`id` as `user_id`, CONCAT_WS(' ',u.`name`, u.`surname`) as `user_name`, u.`birthday`, u.`phone_number`, u.`email`, r.`name` as `role_name` FROM `data_users` as u
        LEFT JOIN `data_roles` AS r ON r.id = u.`role_id`
        ".(!empty($where) ? ' WHERE ' . implode(' AND ', $where) : '');

        $res = SApplication::$DB->query($sql_q)->fetchAll(PDO::FETCH_ASSOC);

        if ($res === false) {
            throw new Exception("error while getting users. (Users101)", 101);
        }

        return $res;
    }
}