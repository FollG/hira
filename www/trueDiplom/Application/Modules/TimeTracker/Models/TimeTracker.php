<?php

namespace TimeTracker\Models;

use Core\SApplication;
use Core\SModel;
use Matrix\Exception;
use PDO;

class TimeTracker extends SModel
{
    public function __construct(bool $paginatorEnabled = true)
    {
        parent::__construct($paginatorEnabled);
    }

    public function get(int $user_id = null): ?array
    {
        $where = [];

        if($user_id) {
            $where[] = " u.`id` = $user_id ";
        }
        date('Y-m-d', strtotime('previous monday'));

        $sql_q = "SELECT t.`opdate`, t.`time_count`, 
                    u.`name` as `user_name`, u.`surname`, tas.`name` as `task_name`
                    FROM `obj_TimeTracker` as `t`
                   LEFT JOIN `data_users` AS `u` ON t.`user_id` = u.`id`
                   LEFT JOIN `data_tasks` AS `tas` ON t.`task_id` = tas.`id` ". (!empty($where) ? ' WHERE '.implode(' AND ', $where) : '');

        $res = SApplication::$DB->query($sql_q)->fetchAll(PDO::FETCH_ASSOC);

        if($res === false) {
            throw new Exception('error while getting timetracker rows. (TimeTracker101)', 101);
        }

        return $res;
    }

    public function getWeekTime(int $user_id): ?array {
        $monday = (date('Y-m-d', strtotime('previous monday')));
        $tuesday = (date('Y-m-d', strtotime('previous tuesday')));
        $wednesday = (date('Y-m-d', strtotime('previous wednesday')));
        $thursday = (date('Y-m-d', strtotime('previous thursday')));
        $friday = (date('Y-m-d', strtotime('previous friday')));

        $sql_q = "
            SELECT DISTINCT 
                (SELECT JSON_ARRAYAGG(JSON_OBJECT('task_id', `task_id`, 'time', `time_count`)) FROM obj_TimeTracker WHERE `opdate` between '$monday 00:00:00' AND '$monday 23:59:59' AND `user_id` = $user_id) as `monday`,
                (SELECT JSON_ARRAYAGG(JSON_OBJECT('task_id', `task_id`, 'time', `time_count`)) FROM obj_TimeTracker WHERE `opdate` between '$tuesday 00:00:00' AND '$tuesday 23:59:59' AND `user_id` = $user_id) as `tuesday`,
                (SELECT JSON_ARRAYAGG(JSON_OBJECT('task_id', `task_id`, 'time', `time_count`)) FROM obj_TimeTracker WHERE `opdate` between '$wednesday 00:00:00' AND '$wednesday 23:59:59' AND `user_id` = $user_id) as `wednesday`,
                (SELECT JSON_ARRAYAGG(JSON_OBJECT('task_id', `task_id`, 'time', `time_count`)) FROM obj_TimeTracker WHERE `opdate` between '$thursday 00:00:00' AND '$thursday 23:59:59' AND `user_id` = $user_id) as `thursday`,
                (SELECT JSON_ARRAYAGG(JSON_OBJECT('task_id', `task_id`, 'time', `time_count`)) FROM obj_TimeTracker WHERE `opdate` between '$friday 00:00:00' AND '$friday 23:59:59' AND `user_id` = $user_id) as `friday`
                FROM obj_TimeTracker
        ";

        $res = SApplication::$DB->query($sql_q)->fetchAll(PDO::FETCH_ASSOC);

        if($res === false) {
            throw new Exception('error while getting user work time. (TimeTracker102)', 102);
        }

        return $res;
    }
}