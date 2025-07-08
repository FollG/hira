<?php
ini_set('display_errors', 1);
ini_set('error_reporting', E_ALL);

$CONFIG = require_once 'Core/config.php';

(new \Core\SApplication($CONFIG))->run();