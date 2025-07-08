<?php

namespace Auth\Controllers;

use Core\SModulesController;
use Core\SRoute;
use Core\SViews;

class Main extends SModulesController
{

    private \Auth\Models\Auth $e;
    public function __construct($action = null)
    {
        parent::__construct(__CLASS__ . ':' . $action);
        $this->e = new \Auth\Models\Auth();

    }

    public function main(): void
    {
        if($_SESSION) {
            SRoute::redirect('/home');
        }
        SViews::setJS('Application/src/js/jquery-3.7.1.js', 'Auth_MODULE');
        SViews::setJS('Application/src/js/notify.js', 'Auth_MODULE');
        SViews::setJS('Application/SModules/Auth/src/js/main.js', 'Auth_MODULE');
        SViews::setCss('Application/SModules/Auth/src/css/style.css');
        SViews::setCss('Application/src/css/style.css');
        $this->Views->setTitle('Вход в аккаунт');
        $this->Views->build('Application/SModules/Auth/Views/main.php', [], []);
    }

    public function post_auth(): void
    {
        $params = SRoute::$PARAMS['POST'];
        $data = $this->e->auth($params['login'], $params['password']);
        self::showJson(
            false !== $data
                ? self::buildSuccess(['data' => $data])
                : self::buildError(['data' => $data])
        );
    }
}