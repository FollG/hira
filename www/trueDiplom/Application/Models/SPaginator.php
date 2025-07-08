<?php


namespace Models;


use Core\SApplication;
use Core\SRoute;
use PDO;

class SPaginator
{
    private static int $page = 0;
    private static int $length = 0;
    private static int $rows = 0;

    public static function init(): void
    {
        self::$length = (int)(SRoute::$PARAMS['POST']['length'] ?? (SRoute::$PARAMS['GET']['length'] ?? 0));
        self::$page = (int)(SRoute::$PARAMS['POST']['page'] ?? (SRoute::$PARAMS['GET']['page'] ?? 0));
        switch (self::$length) {
            case 0:
            case 10:
            case 25:
            case 50:
            case 100:
                break;
            default:
                self::$length = 100;
        }
    }

    public static function build(string &$sql_q): void
    {
        if (!empty(self::$length)) {
            $pos = strpos(strtoupper($sql_q), 'SELECT');
            $sql_q = $pos !== false ? substr_replace($sql_q, 'SELECT SQL_CALC_FOUND_ROWS ', $pos, 6) : $sql_q;
            $sql_q .= ' LIMIT ' . (self::$length * (self::$page > 0 ? self::$page - 1 : 0)) . ', ' . self::$length;
        }
    }

    public static function set(): void
    {
        self::$rows = SApplication::$DB->query('SELECT FOUND_ROWS() as `rows`')->fetch(PDO::FETCH_ASSOC)['rows'] ?? 0;
    }

    public static function getPage(): int
    {
        return self::$page;
    }


    public static function setPage($page): void
    {
        self::$page = $page;
    }

    public static function getLength(): int
    {
        return self::$length;
    }
    public static function setLength($length): void
    {
        self::$length = $length;
    }

    public static function setRows(int $rows)
    {
        self::$rows = $rows;
    }

    public static function getRows(): int
    {
        return self::$rows;
    }
}