<?php

namespace Errors\Controllers;

use Core\SApplication;
use Core\SModulesController;

class E404 extends SModulesController
{
    public function main()
    {
        \Core\SViews::setCss('/SModules/Errors/src/css/main.css', 'Errors_MODULE');

        $this->Views->setTitle('404. ' . SApplication::$SETTINGS['application_name']);
        $this->Views->buildSingle(__DIR__ . '/../Views/e404.php', [
            'link' => '/',
        ], ['fontawesome']);
    }
}