<?php

namespace Core;

use Diversen\Lang;
use Error, PDO;
use Models\SSession;

class SApplication
{
    public static array $Modules = [];
    public static array $CONFIG = [];
    public static array $StartPHPScript = [];
    public static SDatabase $DB;
    private static SDatabase $CRM_DB;
    public static array $SETTINGS = [];
    public static array $PRIVILEGES = [];
    public static ?SSession $Session = null;
    public static string $LANG = 'ru';
    public static array $ALLOWED_FILES = ['jpg', 'png', 'jpeg', 'zip', 'pdf', 'doc', 'docx', 'bmp', 'tiff', 'xls', 'xlsx', 'heic', 'webp'];
    private static bool $debug = true;
    private array $init_after_load_modules = [
        __DIR__ . '/../Modules/init_after_load_modules.php',
    ];
    private array $mod_setting_default = [
        'version' => null,
        'name' => null,
        'namespace' => null,
        'enabled' => 1,
    ];
    private $mod_routing_setting_default = [
        'is_auth' => true,
        'enabled' => 1,
        'method' => 'GET',
    ];


    public function __construct($CONFIG)
    {
        self::$CONFIG = $CONFIG;
        self::$DB = new SDatabase($CONFIG['DB_HOST'], $CONFIG['DB_NAME'], $CONFIG['DB_USER'], $CONFIG['DB_PASS'], $CONFIG['DB_PORT'] ?? null);
        self::$DB->query('SET SESSION group_concat_max_len = ~0;');
        self::$SETTINGS = [];
        $st = self::$DB->prepare("SELECT * FROM `system_settings`");
        $st->execute();
        if ($st->rowCount()) {
            while ($opt = $st->fetch(PDO::FETCH_ASSOC)) {
                self::$SETTINGS[$opt['name']] = $opt['value'];
            }
        }

        include_once __DIR__ . '/../SModules/init_before_load_modules.php';

        return $this;
    }

    public static function isLoadModule(string $module_name): bool
    {
        return !empty(self::$Modules[$module_name]);
    }


    public function run()
    {
        try {
            $this->getModules(__DIR__ . '/../SModules');
            $this->getModules(__DIR__ . '/../Modules');

            SRoute::setParams();
            $LANG = [];
            $l = new Lang();
            $l->setDirsInsideDir(__DIR__ . "/../Modules");
            $l->setDirsInsideDir(__DIR__ . "/../SModules");
            $l->translateDir = 'src/lang';
            $l->loadLanguage(self::$LANG);

            foreach ($this->init_after_load_modules as $file) {
                if(is_file($file)) {
                    include_once $file;
                }
            }

            //триггеры
            include_once __DIR__ . '/../Core/trigger.php';

            list($Controller, $action) = SRoute::getRefillableController();

            (new $Controller($action))->$action();

        } catch (Error $e) {
            echo self::$debug ? ($e->xdebug_message ?? ('ERROR: ' . $e->getMessage())) : 'ERROR: ' . $e->getMessage();
        }
    }

    private function getModules(string $path, array $modulesNames = [])
    {
        $scandir = scandir($path);

        include_once __DIR__ . '/../Modules/function.php';

        $module_forced_enabled = !empty(SApplication::$SETTINGS['module_forced_enabled']) ?
            json_decode(SApplication::$SETTINGS['module_forced_enabled'], true) : [];
        foreach ($scandir as $module_name) {

            if (!in_array($module_name, ['.', '..'])
                && file_exists($path . '/' . $module_name . '/config.php')) {

                $config = include $path . '/' . $module_name . '/config.php';
                $config = array_merge($this->mod_setting_default, $config);

                if ((empty($modulesNames) || in_array($config['name'], $modulesNames)) && !self::isLoadModule($config['name'])) {
                    if (!empty($config['enabled']) && !in_array($config['name'], $module_forced_enabled)) {
                        //привилегии

                        if(!empty($config['config'])) {
                            self::$CONFIG[$config['name']] = $config['config'];
                        }

                        if (!empty($config['privileges'])) {
                            foreach ($config['privileges'] ?? [] as $key => $value) {
                                self::$PRIVILEGES[$key] = $value;
                            }
                        }
                        //файлы  инициализации
                        if (!empty($config['init_php'])) {
                            $config['init_php'] = is_array($config['init_php']) ? $config['init_php'] : [$config['init_php']];
                            foreach ($config['init_php'] as $f) {
                                if (is_file($f)) {
                                    include_once $f;
                                }
                            }
                        }

                        if (!empty($config['init_after_load_modules_php'])) {
                            array_push($this->init_after_load_modules, ...$config['init_after_load_modules_php']);
                        }

                        //все роуты
                        if (isset($config['route'])) {
                            foreach ($config['route'] as $route => $params) {
                                $params = array_merge($this->mod_routing_setting_default, $params);
                                if (!empty($params['enabled'])) {
                                    $params['module'] = $config['name'];
                                    SRoute::set($route, $params);
                                }
                            }
                        }
                        self::$Modules[$config['name']] = $config;
                        //всех дочерние
                        if (is_dir($path . '/' . $module_name . '/Modules')) {

                            self::getModules($path . '/' . $module_name . '/Modules', $modulesNames);
                        }
                    }
                }
            }
        }
    }

    public static function clearSetting(){
        self::$SETTINGS = [];
        $st = self::$DB->prepare("SELECT * FROM `system_settings`");
        $st->execute();
        if ($st->rowCount()) {
            while ($opt = $st->fetch(PDO::FETCH_ASSOC)) {
                self::$SETTINGS[$opt['name']] = $opt['value'];
            }
        }
    }
}