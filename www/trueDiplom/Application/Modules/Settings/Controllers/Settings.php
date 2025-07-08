<?php

namespace Settings\Controllers;

use Core\SRoute;
use Core\SViews;
use Tasks\Models\Tasks;

class Settings extends \Core\SModulesController
{
    private \Settings\Models\Settings $settings;
    private \Users\Models\Users $users;
    private \Tasks\Models\Tasks $tasks;
    private \Projects\Models\Projects $projects;

    public function __construct($name_action)
    {
        parent::__construct(__CLASS__.":".$name_action);
        $this->settings = new \Settings\Models\Settings();
        $this->projects = new \Projects\Models\Projects();
        $this->users = new \Users\Models\Users();
        $this->tasks = new \Tasks\Models\Tasks();
    }

    public function main(): void
    {
        if(!isset($_SESSION['auth'])) {
            SRoute::redirect('/auth');
        }

        SViews::setJS('Application/src/js/jquery-3.7.1.js', 'Settings_MODULE');
        SViews::setJS('Application/src/js/micromodal.min.js', 'Settings_MODULE');
        SViews::setCss('Application/Modules/Home/src/css/style.css');
        SViews::setCss('Application/Modules/Settings/src/css/style.css');
        SViews::setCss('Application/src/css/style.css');
        SViews::setJs('Application/Modules/Settings/src/js/main.js', 'Settings_MODULE');
        SViews::setJs('Application/Modules/Home/src/js/main.js', 'Settings_MODULE');
        SViews::setJS('Application/src/js/notify.js', 'Settings_MODULE');

        $this->Views->setTitle('Настройки');
        $this->Views->build('Application/Modules/Settings/Views/main.php', [
            'projects' => $this->projects->get(),
            'tasks' => $this->tasks->get(),
            'statuses' => $this->tasks->getStatuses(),
            'urgency' => $this->tasks->getUrgency(),
            'users' => $this->users->get(),
            'menu' => (new \Home\Models\Home())->getMenu(),
        ], []);
    }

    public function post_setStatus(): void
    {
        $params = SRoute::$PARAMS['POST'];
        $data = $this->settings->setStatus($params['name']);

        self::showJson(
            false !== $data
                    ? self::buildSuccess(['data' => $data])
                    : self::buildError($this->settings->getErrors())
        );
    }

    public function post_setSurgency(): void
    {
        $params = SRoute::$PARAMS['POST'];
        $data = $this->settings->setSurgency($params['name']);

        self::showJson(
            false !== $data
                ? self::buildSuccess(['data' => $data])
                : self::buildError($this->settings->getErrors())
        );
    }

    public function post_setUser(): void
    {
        $params = SRoute::$PARAMS['POST'];
        $data = $this->settings->setUser($params['name'], $params['surname'], $params['patronymic'], $params['birthday'],
            $params['login'], $params['password'], $params['phone_number'], $params['role_id'], $params['email']);

        self::showJson(
            false !== $data
                ? self::buildSuccess(['data' => $data])
                : self::buildError($this->settings->getErrors())
        );
    }

    public function post_setProject(): void
    {
        $params = SRoute::$PARAMS['POST'];
        $params['user_id'] = 1;
        $data = $this->settings->setProject($params['name'], $params['user_id']);

        self::showJson(
            false !== $data
                ? self::buildSuccess(['data' => $data])
                : self::buildError($this->settings->getErrors())
        );
    }

    public function setRole(): void
    {
        $params = SRoute::$PARAMS['POST'];
        $data = $this->settings->setRoles($params['name']);

        self::showJson(
            false !== $data
                ? self::buildSuccess(['data' => $data])
                : self::buildError($this->settings->getErrors())
        );
    }
}