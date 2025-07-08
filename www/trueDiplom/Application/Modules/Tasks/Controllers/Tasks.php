<?php

namespace Tasks\Controllers;

use Core\SModulesController;
use Core\SRoute;
use Core\SViews;

class Tasks extends SModulesController
{
    private \Tasks\Models\Tasks $tasks;
    private \Users\Models\Users $users;

    public function __construct($action)
    {
        parent::__construct(__CLASS__.':'.$action);
        $this->tasks = new \Tasks\Models\Tasks();
        $this->users = new \Users\Models\Users();
    }

    public function main(): void
    {
        if(!isset($_SESSION['auth'])) {
            SRoute::redirect('/auth');
        }

        SViews::setJS('Application/src/js/jquery-3.7.1.js', 'Tasks_MODULE');
        SViews::setJS('Application/src/js/micromodal.min.js', 'Tasks_MODULE');
        SViews::setCss('Application/Modules/Home/src/css/style.css');
        SViews::setCss('Application/src/css/style.css');
        SViews::setJs('Application/Modules/Home/src/js/main.js', 'Tasks_MODULE');
        SViews::setJS('Application/src/js/notify.js', 'Tasks_MODULE');


        $this->Views->setTitle('Ваши задачи');
        $this->Views->build('Application/Modules/Tasks/Views/main.php', [
            'tasks' => $this->tasks->get(),
            'menu' => (new \Home\Models\Home())->getMenu(),
        ]);
    }

    public function show(): void
    {
        if(!isset($_SESSION['auth'])) {
            SRoute::redirect('/auth');
        }

        SViews::setJS('Application/src/js/jquery-3.7.1.js', 'Tasks_MODULE');
        SViews::setJS('Application/src/js/micromodal.min.js', 'Tasks_MODULE');
        SViews::setJs('Application/Modules/Tasks/src/main.js', 'Tasks_MODULE');
        SViews::setCss('Application/Modules/Home/src/css/style.css');
        SViews::setCss('Application/src/css/style.css');
        SViews::setJs('Application/Modules/Home/src/js/main.js', 'Tasks_MODULE');
        SViews::setJS('Application/src/js/notify.js', 'Tasks_MODULE');


        $task = $this->tasks->get(SRoute::$PARAMS['GET']['task']);

        $this->Views->setTitle("Задача №".$task[0]['id'] ?? '');
        $this->Views->build('Application/Modules/Tasks/Views/show.php', [
            'users' => $this->users->get(),
            'statuses' => $this->tasks->getStatuses(),
            'urgency' => $this->tasks->getUrgency(),
            'tasks' => $task,
            'menu' => (new \Home\Models\Home())->getMenu(),
        ]);
    }

    public function post_get(): void
    {
        $params = SRoute::$PARAMS['POST'];
        $data = $this->tasks->get();
        self::showJson(
            self::buildSuccess(['data' => $data])
        );
    }

    public function post_sendcomment(): void
    {
        $params = SRoute::$PARAMS['POST'];
        $data = $this->tasks->sendComment($params['comment'], $params['task_id']);
        self::showJson(
            $data !== false
                ? self::buildSuccess(['data' => $data])
                : self::buildError(__CLASS__)
        );
    }

    public function post_checkonuser(): void
    {
        $params = SRoute::$PARAMS['POST'];
        $data = $this->tasks->checkOnUser($params['user_id'], $params['task_id']);
        self::showJson(
            $data !== false
                ? self::buildSuccess(['data' => $data])
                : self::buildError(__CLASS__)
        );
    }

    public function post_changeUrgency(): void
    {
        $params = SRoute::$PARAMS['POST'];
        $data = $this->tasks->changeUrgency($params['urgency_id'], $params['task_id']);
        self::showJson(
            $data !== false
                ? self::buildSuccess(['data' => $data])
                : self::buildError(__CLASS__)
        );
    }

    public function post_changeStatus(): void
    {
        $params = SRoute::$PARAMS['POST'];
        $data = $this->tasks->changeStatus($params['status_id'], $params['task_id']);
        self::showJson(
            $data !== false
                ? self::buildSuccess(['data' => $data])
                : self::buildError(__CLASS__)
        );
    }

    public function post_setTimeTracker(): void
    {
        $params = SRoute::$PARAMS['POST'];
        $data = $this->tasks->setTimeTracker($params['time'], $params['task_id']);
        self::showJson(
            $data !== false
                ? self::buildSuccess(['data' => $data])
                : self::buildError(__CLASS__)
        );
    }
}