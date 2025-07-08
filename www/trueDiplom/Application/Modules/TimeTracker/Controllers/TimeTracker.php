<?php

namespace TimeTracker\Controllers;

use Core\SModulesController;
use Core\SRoute;
use Core\SViews;

class TimeTracker extends SModulesController
{
    private \TimeTracker\Models\TimeTracker $timeTracker;
    private \Tasks\Models\Tasks $tasks;
    public function __construct($name_action)
    {
        parent::__construct(__CLASS__.":".$name_action);
        $this->timeTracker = new \TimeTracker\Models\TimeTracker();
        $this->tasks = new \Tasks\Models\Tasks();
    }

    public function main()
    {
        if(!isset($_SESSION['auth'])) {
            SRoute::redirect('/auth');
        }

        SViews::setJS('Application/src/js/jquery-3.7.1.js', 'TimeTracker_MODULE');
        SViews::setJS('Application/src/js/micromodal.min.js', 'TimeTracker_MODULE');
        SViews::setCss('Application/Modules/Home/src/css/style.css');
        SViews::setCss('Application/src/css/style.css');
        SViews::setJs('Application/Modules/Home/src/js/main.js', 'TimeTracker_MODULE');
        SViews::setJS('Application/src/js/notify.js', 'TimeTracker_MODULE');
        $this->Views->setTitle('Time Tracker');
        $this->Views->build('Application/Modules/TimeTracker/Views/main.php', [
            'tasks' => 1,
            'projects' => $this->timeTracker->get(),
            'menu' => (new \Home\Models\Home())->getMenu(),
        ]);
    }

    public function post_get():void
    {
        $params = SRoute::$PARAMS['POST'];
        $data = $this->timeTracker->get($params['tt_id']);

        self::showJson(
            self::buildSuccess(
                ['data' => $data]
            )
        );
    }
}