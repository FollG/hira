<?php

namespace Errors\Controllers;

use Core\SApplication;
use Core\SModulesController;

class E403 extends SModulesController
{
    public function main()
    {
        \Core\SViews::setCss('/SModules/Errors/src/css/main.css', 'Errors_MODULE');

        $this->Views->setTitle('404. ' . SApplication::$SETTINGS['application_name']);
        $this->Views->buildSingle(__DIR__ . '/../Views/e403.php', [
            'link' => '/',
        ], ['fontawesome']);
    }
}