<?php

session_start();

ini_set('display_errors', 1);
ini_set('error_reporting', E_ALL);
ini_set('memory_limit','256M');
ini_set('xdebug.var_display_max_depth', '10');
ini_set('xdebug.var_display_max_children', '256');
ini_set('xdebug.var_display_max_data', '1024');
mb_internal_encoding("UTF-8");

function auto($class_name)
{
    $exploded = explode("\\", $class_name, 2);
    if(count($exploded) != 2)
        return;
    list($folder, $filename) = $exploded;

    $cTemp = strtoupper(substr($filename, 0, 1));
    $filename = $cTemp . substr($filename, 1);
    $file = "Application/$folder/$filename.php";
    if (file_exists($file) == false) {
        return;
    }
    include($file);
}

function autoFastsolCrm($class_name)
{
    if (false === file_exists($path = __DIR__ . '/Application/Modules/' . implode('/', explode("\\", $class_name)) . '.php')) {
        return false;
    }
    include $path;
}

function autoSModuleFastsolCrm($class_name)
{
    if (false === file_exists($path = __DIR__ . '/Application/SModules/' . implode('/', explode("\\", $class_name)) . '.php')) {
        return false;
    }
    include $path;
}


spl_autoload_register('auto');
spl_autoload_register('autoFastsolCrm');
spl_autoload_register('autoSModuleFastsolCrm');
require_once 'vendor/autoload.php';
require_once 'Application/bootstrap.php';