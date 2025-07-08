<?php

namespace Tasks\Models;

use Core\SApplication;
use Matrix\Exception;
use PDO;
class Tasks extends \Core\SModel
{
    public function __construct(bool $paginatorEnabled = true)
    {
        parent::__construct($paginatorEnabled);
    }

    public function get(int $task_id = null): ?array
    {
        $where = [];

        if ($task_id) {
            $where[] = ' t.`id` = '.$task_id;
        }

        $sql_q = "SELECT t.`id`, t.`name` as `task_name`, t.`description` as `task_description`, t.`opdate`, t.`create_date`,
                        s.`name` as `solution_name`, s.`description` as `solution_description`, 
                        CONCAT_WS(' ', us.`name`, us.`surname`) as `user_name`, CONCAT_WS(' ', creator.`name`, creator.`surname`) as `creator_name`, creator.`id` as `creator_id`, p.`id` as `project_id`, st.`name` as `status_name`,
                        ur.`name` as `urgency_name`, p.`name` as `project_name`, us.`id` as `user_id`, s.`id` as `status_id`,
                        	  (SELECT JSON_ARRAYAGG(JSON_OBJECT('text', c.`text`, 'opdate', c.`opdate`, 'name', ta.`name`)) FROM `data_tasks` AS ta
                           	LEFT JOIN `data_comments` as c ON ta.`commentID` = c.`id`
                        LEFT JOIN `data_users` as `user` ON c.`userID` = user.`id`) as `comments`
                        FROM `data_tasks` as t 
                        LEFT JOIN `data_solutions` AS s ON t.`solutionID` = s.`id`
                        LEFT JOIN `data_urgency` as ur ON t.`urgencyID` = ur.`id`
                        LEFT JOIN `data_users` as us ON t.`userID` = us.`id`
                        LEFT JOIN `data_users` as creator ON t.`creator_id` = creator.`id`
                        LEFT JOIN `data_statuses` as st ON t.`statusID` = st.`id`
                        LEFT JOIN `data_projects`as p ON t.`project_id` = p.`id` " . (!empty($where) ? ' WHERE ' . implode(' AND ', $where) : '');

        $res = \Core\SApplication::$DB->query($sql_q)->fetchAll(PDO::FETCH_ASSOC);

        if ($res === false) {
            throw new Exception('error while getting tasks. Tasks(101)', 101);
        }

        return $res;
    }

    public function sendComment(string $text, int $task_id,): bool
    {
        try {
            $sql_q = "INSERT INTO `data_comments`(`text`, `userID`, `opdate`, `task_id`) VALUES (
                            ".SApplication::$DB->quote($text).",
                            ".SApplication::$Session->getSession()['user_id'].",
                            NOW(),
                            $task_id                                                   
            )";

            $st = SApplication::$DB->query($sql_q);

            if($st === false) {
                throw new Exception("error while setting comment. (Task102)", 102);
            }

            return true;
        } catch (Exception $e) {
            throw new Exception($e->getMessage(), 103);
        }
    }

    public function checkOnUser(int $user_id, int $task_id): bool
    {
        try {
            $sql_q = "UPDATE `data_tasks` SET `userID` = $user_id WHERE `id` = $task_id";

            $st = SApplication::$DB->query($sql_q);

            if($st === false) {
                throw new Exception("error while change user. (Task104)", 104);
            }

            return true;
        } catch (Exception $e) {
            throw new Exception($e->getMessage(), 105);
        }
    }

    public function changeUrgency(int $urgency_id, int $task_id): bool
    {
        try {
            $sql_q = "UPDATE `data_tasks` SET `urgencyID` = $urgency_id WHERE `id` = $task_id";

            $st = SApplication::$DB->query($sql_q);

            if($st === false) {
                throw new Exception("error while change urgency. (Task106)", 106);
            }

            return true;
        } catch (Exception $e) {
            throw new Exception($e->getMessage(), 107);
        }
    }

    public function changeStatus(int $status_id, int $task_id): bool
    {
        try {
            $sql_q = "UPDATE `data_tasks` SET `statusID` = $status_id WHERE `id` = $task_id";

            $st = SApplication::$DB->query($sql_q)->execute();

            if($st === false) {
                throw new Exception("error while change status. (Task108)", 108);
            }

            return true;
        } catch (Exception $e) {
            throw new Exception($e->getMessage(), 108);
        }
    }

    public function setTimeTracker(float $time, int $task_id): bool
    {
        try {
            $sql_q = "INSERT INTO `obj_TimeTracker`(`user_id`, `task_id`, `opdate`, `time_count`) VALUES (".SApplication::$Session->getSession()['user_id'].", $task_id, NOW(), $time)";
            $st = SApplication::$DB->query($sql_q);

            if($st === false) {
                throw new Exception("error while adding timeTracker. (Task110)", 110);
            }

            return true;
        } catch (Exception $e) {
            throw new Exception($e->getMessage(), 111);
        }
    }

    public function getUrgency(): ?array
    {
        $sql_q = "SELECT * FROM `data_urgency`";

        return SApplication::$DB->query($sql_q)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getStatuses(): ?array
    {
        $sql_q = "SELECT * FROM `data_statuses`";

        return SApplication::$DB->query($sql_q)->fetchAll(PDO::FETCH_ASSOC);
    }
}