<?php

namespace Users\Controllers;

use Core\SModulesController;
use Core\SRoute;
use Core\SViews;

class Users extends SModulesController
{
    private \Users\Models\Users $users;
    public function __construct($name_action)
    {
        parent::__construct($name_action.":".$name_action);
        $this->users = new \Users\Models\Users();
    }
    public function main(): void
    {
        if(!isset($_SESSION['auth'])) {
            SRoute::redirect('/auth');
        }

        SViews::setJS('Application/src/js/jquery-3.7.1.js', 'Users_MODULE');
        SViews::setCss('Application/Modules/Home/src/css/style.css');
        SViews::setCss('Application/src/css/style.css');
        SViews::setJs('Application/Modules/Home/src/js/main.js', 'Users_MODULE');
        SViews::setJS('Application/src/js/notify.js', 'Users_MODULE');

        $this->Views->build('Application/Modules/Users/Views/main.php', [
            'user' => $this->users->get((int)SRoute::$PARAMS['GET']['user']),
            'menu' => (new \Home\Models\Home())->getMenu(),
        ]);
    }

    public function post_get(): void
    {
        $params = SRoute::$PARAMS['POST'];
        $data = $this->users->get($params['user_id']);

        self::showJson(
            self::buildSuccess(['data' => $data])
        );
    }
}