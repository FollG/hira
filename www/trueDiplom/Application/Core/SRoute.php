<?php
namespace Core;

use Models\SSession;
use PDO;

class SRoute
{
    private static array $items = [];
    public static array $CURRENT_ROUTE = [];
    private static string $url_prefix = '/';
    public static array $PARAMS;

    public static function set(string $router, array $params): void
    {
        self::$items[strtolower(self::$url_prefix.$router)] = $params;
    }

    public static function setParams(): void
    {
//        var_dump(json_decode(file_get_contents('php://input'), true), $_GET);
        self::$PARAMS = [
            'GET' => $_GET,
            'POST' => json_decode(file_get_contents('php://input'), true) ?? [],
        ];
    }

    public static function getRefillableController(): array
    {
        $query_pos = mb_strpos($_SERVER['REQUEST_URI'], '?');

        $request = $query_pos > 0 ? mb_substr($_SERVER['REQUEST_URI'], 0, $query_pos) : $_SERVER['REQUEST_URI'];
        if (substr($request, strlen($request) - 1) == "#") {
            $request = substr($request, 0, strlen($request) - 1);
        }
        if (substr($request, strlen($request) - 1) == "/") {
            $request = substr($request, 0, strlen($request) - 1);
        }
        if (empty($request)) {
            $request = '/home';
        }
//        if(!isset($_SESSION['auth'])) {
//            $request = '/home';
//        }
        $request = strtolower($request);

        if (!isset(self::$items[$request])) {
            self::error(404, self::$items[$request]['method'] ?? (empty($_POST) ? "GET" : 'POST'));
        }

        $Controller = self::$items[$request]['controller'];
        $action = self::$items[$request]['action'];
//        var_dump($Controller, $action);exit();
        self::$CURRENT_ROUTE = self::$items[$request];
        self::$CURRENT_ROUTE['url'] = $request;

        $method_post = strtoupper(self::$CURRENT_ROUTE['method'] ?? 'GET');

        return [$Controller, $action];
    }

    public static function error(int $code, string $method = 'GET'): void
    {
        switch ($code) {
            case 403:
                if($method === 'GET') {
                    self::redirect('/e403');
                } else {
                    SModulesController::showJson(SModulesController::buildError(['message' => [$code]]));
                }
                break;
            case 404:
                if($method === 'GET') {
                    self::redirect('/e404');
                } else {
                    SModulesController::showJson(SModulesController::buildError(['message' => [$code]]));
                }
                break;
            default: exit((string)$code);
        }

    }

    public static function redirect($location): void
    {
        header("Location: $location");
        exit();
    }

    public static function get(): array
    {
        return self::$items;
    }

    public static function unsetKey(string $path): void
    {
        unset(self::$items[strtolower(self::$url_prefix.$path)]);
    }
}