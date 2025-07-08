<?php

namespace Home\Controllers;

use Core\SApplication;
use Core\SModulesController;
use Core\SRoute;
use Core\SViews;

class Main extends SModulesController
{
    private \Home\Models\Home $home;
    private \Tasks\Models\Tasks $tasks;
    private \Projects\Models\Projects $projects;
    private \Users\Models\Users $users;
    private \TimeTracker\Models\TimeTracker $timeTracker;
    public function __construct($action)
    {
        parent::__construct(__CLASS__ . ':' . $action);
        $this->tasks = new \Tasks\Models\Tasks();
        $this->projects = new \Projects\Models\Projects();
        $this->users = new \Users\Models\Users();
        $this->home = new \Home\Models\Home();
        $this->timeTracker = new \TimeTracker\Models\TimeTracker();
    }

    public function main()
    {
        if(!isset($_SESSION['auth'])) {
            SRoute::redirect('/auth');
        }

        SViews::setJS('Application/src/js/jquery-3.7.1.js', 'Home_MODULE');
        SViews::setCss('Application/Modules/Home/src/css/style.css');
        SViews::setCss('Application/src/css/style.css');
        SViews::setJs('Application/Modules/Home/src/js/main.js', 'Home_MODULE');
        SViews::setJS('Application/src/js/notify.js', 'Home_MODULE');

        $this->Views->setTitle('Рабочий стол');
        $this->Views->build('Application/Modules/Home/Views/main.php', [
            'tasks' => $this->tasks->get(),
            'projects' => $this->projects->get(),
            'user' => $this->users->get(SApplication::$Session->getSession()['user']),
            'menu' => $this->getMenu(),
            'timetracker' => $this->timeTracker->getWeekTime(SApplication::$Session->getSession()['user']),

        ], []);
    }

    public function getMenu(): array
    {
        $data = $this->home->getMenu();

        return $data;
    }

}