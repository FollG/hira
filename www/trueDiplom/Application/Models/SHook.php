<?php

namespace Models;

class SHook
{
    private static array $HOOKS = [];
    private static array $HOOKS_INIT = [];
    public static bool $enabled = true;

    public static function init(string $name, array $params)
    {
        if (self::$enabled && isset(self::$HOOKS[$name])) {
            krsort(self::$HOOKS[$name]);
            foreach (self::$HOOKS[$name] as $priority) {
                foreach ($priority as $callback) {
                    $callback($params, $name);
                }
            }
        }

        self::$HOOKS_INIT[] = ['name' => $name, 'hash' => md5($name)];
    }

    public static function set(array $names, $callback, int $priority = 100)
    {
        foreach ($names as $name) {
            self::$HOOKS[$name][$priority][] = $callback;
        }
    }
    public static function getInit()
    {
        return self::$HOOKS_INIT;
    }
}