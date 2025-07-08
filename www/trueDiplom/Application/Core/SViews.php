<?php


namespace Core;


use Diversen\Lang;
use Models\SCommon;
use Symfony\Component\VarDumper\VarDumper;

class SViews
{
    private string $main_template;

    public static array $_MENU = [];
    public static array $init_file_js = [];
    public static array $init_file_css = [];
    public static array $_PARAMS = [];
    public static array $_LIBS = [];

    private $title;

    public function __construct()
    {
        $this->title = '';//SApplication::$SETTINGS['application_name'];
        $this->main_template = 'base';
        $this->init();
    }

    private function init()
    {
        include_once __DIR__.'/../SModules/libs.php';
    }


    public static function getBaseTemplateHead() {

        echo ' <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1">
                <meta name="robots" content="noindex">
                    <link href="https://fonts.googleapis.com/icon?family=Material+Icons"  rel="stylesheet">
            <link rel="icon" href="../src/tpl/icon/siteico.ico" type="image/x-icon">
            <link rel="apple-touch-icon" sizes="180x180" href="../src/tpl/icon/siteico.ico">
            <link rel="icon" type="image/png" sizes="32x32" href="../src/tpl/icon/siteico.ico">
            <link rel="icon" type="image/png" sizes="16x16" href="../src/tpl/icon/siteico.ico">
            <link rel="icon" href="../src/tpl/icon/siteico.ico">
            <link rel="mask-icon" href="../src/tpl/icon/siteico.ico" color="#343a40">
            <link rel="shortcut icon" href="../src/tpl/icon/siteico.ico" type="image/x-icon">
            <meta name="msapplication-TileColor" content="#343a40">
            <meta name="msapplication-config" content="/src/base_tpl/favicon/browserconfig.xml">
            <meta name="theme-color" content="#343a40">
             <!--[if lt IE 9]>
            <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
            <![endif]-->
          ';
    }

    public static function createCache(array $files, string $extension = 'css', bool $cache = true) {
        if (empty($files)) return;

        foreach ($files as $f) {
            switch ($extension) {
                case 'css': ?>
                    <link href="<?= $f ?>" rel="stylesheet"> <?php
                    break;
                case 'js': ?>
                    <script type="text/javascript" src="<?= $f ?>"></script> <?php
                    break;
            }
        }
    }

    public static function getBaseTemplateCss(array $libs, bool $global = true, array $add_files = [])
    {
        $exception = ['fontawesome', 'select2', 'ckeditor4', 'fileinput-krajee'];

        $files_def = [];
        array_push($files_def, ...$add_files, ...[
            '/src/js/plugins/bootstrap-4.1.3-dist/css/bootstrap-reboot.css',
            '/src/js/plugins/bootstrap-4.1.3-dist/css/bootstrap-grid.css',
            '/src/base_tpl/css/normalize.css',
            '/src/base_tpl/css/style.css',
        ]);


        self::createCache($files_def, 'css');

        $uniq = $_files = [];

        foreach ($libs ?? [] as $name) {

            foreach (\Core\SViews::$_LIBS[$name]['css'] ?? [] as $value) {
                if (empty($uniq[md5(trim($value))])) {
                    $uniq[md5(trim($value))] = $value;
                    if(in_array($name, $exception)
                        || false !== stripos($value, 'https://')
                        || false !== stripos($value, 'http://')
                    ) {
                        echo '<link href="' . $value . '" rel="stylesheet">';
                    } else {
                        $_files[] = $value;
                    }
                }
            }
        }

        foreach (self::$init_file_css ?? [] as $name => $files) {
            if (in_array(strtolower($name), $global ? ['_global', strtolower(\Core\SRoute::$CURRENT_ROUTE['module'])] : [strtolower(\Core\SRoute::$CURRENT_ROUTE['module'])] )) {
                foreach ($files as $file) {
                    if (empty($uniq[md5(trim($file))])) {
                        $uniq[md5(trim($file))] = true;
                        if(in_array($name, $exception) || false !== stripos($file, 'https://',)) {
                            var_dump();
                            echo '<link href="' . $file . '" rel="stylesheet">';
                        } else {
                            $_files[] = $file;
                        }
                    }
                }
            }
        }


        self::createCache($_files, 'css');
    }

    public static function getBaseTemplateJS(array $libs, bool $global = true, array $add_files = [],
                                             bool $base = true)
    {

        $files_def = [];

        array_push($files_def, ...$add_files);

        if($base) {
            array_push($files_def, ...[
                'Application/src/js/jquery-3.7.1.js',
                'Application/src/js/common.js',
            ]);
        }

        self::createCache($files_def, 'js');

        $uniq = $_files = [];
        foreach ($libs ?? [] as $name) {
            foreach (\Core\SViews::$_LIBS[$name]['js'] ?? [] as $value) {
                if(empty($uniq[md5(trim($value))])) {
                    $uniq[md5(trim($value))] = $value;
                    echo '<script type="text/javascript" src="' . $value . '" ></script>';
                }
            }
        }

        foreach (self::$init_file_js ?? [] as $name => $files) {
            if (in_array(strtolower($name), $global ? ['_global', strtolower(\Core\SRoute::$CURRENT_ROUTE['module'])] : [strtolower(\Core\SRoute::$CURRENT_ROUTE['module'])] )) {
                foreach ($files as $file) {
                    if(empty($uniq[md5(trim($file))])) {
                        $uniq[md5(trim($file))] = $file;
                        echo '<script type="text/javascript" src="' . $file . '" ></script>';
                    }
                }
            }
        }
        self::createCache(array_values($_files), 'js');
    }


    public function setTitle(string $title)
    {
        $this->title = $title;
    }

    public static function setLibsDefault(array $files, string $name)
    {
        self::$_LIBS[$name] = $files;
    }

    public static function setJS(string $script,  $moduleName = null) {
        $moduleName = is_array($moduleName) ? $moduleName : [$moduleName];
        foreach ($moduleName AS $v) {
            if(!empty(  self::$init_file_js[$v ?? '_global'][md5($script)])) continue;
            self::$init_file_js[$v ?? '_global'][md5($script)] = $script;
        }
    }

    public static function setCss(string $style, $moduleName = null) {

        $moduleName = is_array($moduleName) ? $moduleName : [$moduleName];
        foreach ($moduleName AS $v) {
            if(!empty(self::$init_file_css[$v ?? '_global'][md5($style)])) continue;
            self::$init_file_css[$v ?? '_global'][md5($style)] = $style;
        }
    }

    public function build(string $template, array $data = null, array $libs = [], string $base_template = 'base')
    {
        $PAGE_MENU = ['main' => $this->getMenu()];

        //bread crumbs
        $BREAD_CRUMBS = [];

        ($f = function ($module, $parent) use (&$BREAD_CRUMBS, &$f) {

            !$parent
                ? $BREAD_CRUMBS[] = ['name' => $module['name'] ?? '', 'url' => $module['url']]
                : array_unshift($BREAD_CRUMBS, ['name' => $module['name'], 'url' => $module['url']]);

            if(!empty($module['parent_module'])) {
                $key = array_search($module['parent_module'].'_MODULE', array_combine(array_keys(SRoute::get()), array_column(SRoute::get(), 'module')));
                if(!empty($key)) {
                    $f(SRoute::get()[$key] + ['url' => $key], true);
                }
            }
        })(SRoute::$CURRENT_ROUTE, false);

        $_title = trim($this->title);
//SApplication::$SETTINGS['application_name']
        $PAGE_TITLE = (
            !empty($_title)
                ? $_title
                : (implode(' | ', array_map(fn($el) => Lang::t($el['name']) , $BREAD_CRUMBS)))
            ).' | ' . (SApplication::$SETTINGS['application_name']);




        foreach (SApplication::$StartPHPScript ?? [] AS $file) {
            include_once $file;
        }

        $PAGE_JS = self::$init_file_js;

        ob_start();
        include $template;
        $_CONTENT = ob_get_contents();
        ob_end_clean();
//        include_once __DIR__.'/../Views/index.php';
    }

    public function buildSingle(string $template, array $data = [], array $libs = []){
        include $template;
    }


    private function getMenu() : array
    {
        $items = SRoute::get();
        $privileges = SApplication::$PRIVILEGES;

        foreach ($items AS $url => $value) {
            $module = $value;
            if (!empty($value['is_menu']) && $value['is_menu'] === true && !empty($value['privilege']) && in_array($value['privilege'], array_keys($privileges))) {
                if ((int)$privileges[$value['privilege']]['default'] === 0) {
                    continue;
                }
            }
            if(!empty($module['is_menu'])) {
                $module['url'] = $url;
                $module['active'] = false;

                if(SRoute::$CURRENT_ROUTE['module'] === $module['module'] && $url === SRoute::$CURRENT_ROUTE['url']) {
                    $module['active'] = true;
                }

                if (!empty($module['parent_module']) && !empty($items['/'.strtolower($value['parent_module'])])) {
                    if (empty(self::$_MENU[$module['parent_module']][0])) {
                        self::$_MENU[$module['parent_module']][0] = $items['/'.strtolower($value['parent_module'])];

                        if(!isset(self::$_MENU[$module['parent_module']]['active'])) {
                            self::$_MENU[$module['parent_module']][0]['active'] =  $module['active'];
                        }
                    }
                    self::$_MENU[$module['parent_module']][0]['parents'][$module['module']][] = $module;

                } else {
                    if(empty(self::$_MENU[$module['module']])) {
                        self::$_MENU[$module['module']] = [];
                    }
                    self::$_MENU[$module['module']][] = $module;
                }
            }
        }
        return self::$_MENU;
    }
}