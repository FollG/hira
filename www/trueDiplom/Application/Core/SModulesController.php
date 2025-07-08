<?php
namespace Core;

use Models\SHook;
use Models\SPaginator;
use DateTime, Exception;
use PDO;

class SModulesController
{

    private static array $_MIDDLEWARE = [];

    protected SViews $Views;

    protected DateTime $date_from;
    protected DateTime $date_to;

    public function __construct($name_action)
    {
        SPaginator::init();
        foreach (self::$_MIDDLEWARE['*'] ?? [] AS $value) {
            if(is_callable($value)) {
                $value();
            }
        }

        foreach (self::$_MIDDLEWARE[$name_action] ?? [] AS $value) {
            if(is_callable($value)) {
                $value();
            }
        }

        $this->Views = new SViews();

        try {
            $this->date_from = new DateTime(!empty($_GET['date_from']) ? $_GET['date_from'] : 'now');
        } catch (Exception $e) {
            $this->date_from =  new DateTime('now');
            $_GET['date_from'] = null;
        }
        if(empty($_GET['date_from'])) {
            $this->date_from->modify('-1 month');
        }

        try {
            $this->date_to = new DateTime(!empty($_GET['date_to']) ? $_GET['date_to'] : 'now');
        } catch (Exception $e) {
            $this->date_to =  new DateTime('now');
        }
    }

    public static function setMiddleWare(string $key, $callback)
    {
        self::$_MIDDLEWARE[$key][] = $callback;
    }

    public static function getMiddleWare(string $key)
    {
        return self::$_MIDDLEWARE[$key];
    }

    public static function showJson(array $array)
    {
        $array['hook'] = SHook::getInit();
//        header('Content-Type: application/json');
        exit(json_encode($array));
    }

    public static function buildSuccess($content = []): array
    {
        return ['ok' => 1, 'content' => $content];
    }
    public static function buildError($content): array
    {
        return ['ok' => 0, 'content' => $content];
    }
}