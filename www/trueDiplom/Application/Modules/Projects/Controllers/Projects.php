<?php

namespace Projects\Controllers;

use Core\SModulesController;
use Core\SRoute;
use Core\SViews;
use Matrix\Exception;

class Projects extends SModulesController
{
    private \Projects\Models\Projects $projects;
    public function __construct($action)
    {
        parent::__construct(__CLASS__.':'.$action);
        $this->projects = new \Projects\Models\Projects();
    }

    /**
     * @throws Exception
     */
    public function main(): void
    {
        if(!isset($_SESSION['auth'])) {
            SRoute::redirect('/auth');
        }

        SViews::setJS('Application/src/js/jquery-3.7.1.js', 'Projects_MODULE');
        SViews::setCss('Application/Modules/Home/src/css/style.css');
        SViews::setCss('Application/src/css/style.css');
        SViews::setJs('Application/Modules/Home/src/js/main.js', 'Projects_MODULE');
        SViews::setJS('Application/src/js/notify.js', 'Projects_MODULE');
        $this->Views->setTitle('Проекты');
        $this->Views->build('Application/Modules/Projects/Views/main.php', [
            'projects' => $this->projects->get(),
            'menu' => (new \Home\Models\Home())->getMenu(),
        ]);
    }

    public function show(): void
    {
        if(!isset($_SESSION['auth'])) {
            SRoute::redirect('/auth');
        }

        SViews::setJS('Application/src/js/jquery-3.7.1.js', 'Projects_MODULE');
        SViews::setCss('Application/Modules/Home/src/css/style.css');
        SViews::setCss('Application/src/css/style.css');
        SViews::setJs('Application/Modules/Home/src/js/main.js', 'Projects_MODULE');
        SViews::setJS('Application/src/js/notify.js', 'Projects_MODULE');

        $project = $this->projects->get((int)SRoute::$PARAMS['GET']['project']);

        $this->Views->setTitle($project[0]['project_name']);
        $this->Views->build('Application/Modules/Projects/Views/show.php', [
            'project' => $project,
            'tasks' => $this->projects->getProjectTasks((int)SRoute::$PARAMS['GET']['project']),
            'menu' => (new \Home\Models\Home())->getMenu(),
        ]);
    }

    public function post_get(): void
    {
        $params = SRoute::$PARAMS['POST'];

        $data = $this->projects->get();

        self::showJson(
            self::buildSuccess(['data' => $data])
        );
    }
}