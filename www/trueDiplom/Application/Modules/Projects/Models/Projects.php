<?php

namespace Projects\Models;

use Core\SApplication;
use Core\SModel;
use Matrix\Exception;
use PDO;
class Projects extends SModel
{
    public function __construct(bool $paginatorEnabled = true)
    {
        parent::__construct($paginatorEnabled);
    }

    public function get(int $project_id = null): ?array
    {
        $where = [];

        if ($project_id) {
            $where[] = " p.`id` = $project_id";
        }

        $sql_q = "SELECT p.`id`, p.`name` as `project_name`, p.`icon`,
                    CONCAT_WS(' ', u.`name`, u.`surname`) as `user`, r.`name` as `role_name`
                        FROM `data_projects` as p
                            LEFT JOIN `data_users` as u ON p.`userID` = u.`id`
                            LEFT JOIN `data_roles` as r ON u.`role_id` = r.`id`
                            " . (!empty($where) ? ' WHERE ' . implode(' AND ', $where) : '');;

        $res = SApplication::$DB->query($sql_q)->fetchAll(PDO::FETCH_ASSOC);

        if ($res === false) {
            throw new Exception('error while getting projects. (Projects101)', 101);
        }

        return $res;
    }

    public function getProjectTasks(int $project_id = null): ?array
    {
        $sql_q = "SELECT t.`name` as `task_name`, CONCAT_WS(' ',u.`name`,u.`surname`)AS `user_name`, s.`name` as `status_name`, t.`opdate` FROM data_tasks AS t
                    LEFT JOIN data_projects AS p ON t.`project_id` = p.`id`
                    LEFT JOIN data_statuses AS s ON t.`statusID` = s.`id`
                    LEFT JOIN data_users AS u ON t.`userID` = u.`id`
                    ".(!empty($project_id) ? "WHERE t.`project_id` = $project_id" : '');

        $res = SApplication::$DB->query($sql_q);

        if($res === false) {
            throw new Exception('error while getting project tasks. (project201)', 201);
        }

        return $res->fetchAll(PDO::FETCH_ASSOC);
    }
}