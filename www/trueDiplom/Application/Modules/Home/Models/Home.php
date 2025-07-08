<?php

namespace Home\Models;
use Core\SApplication, PDO;

class Home extends \Core\SModel
{
    public function __construct(bool $paginatorEnabled = true)
    {
        parent::__construct($paginatorEnabled);
    }

    public function getMenu(): array
    {
        $privilege = [];
        if($_SESSION['admin']) {
            $privilege[] = 1;
        }
        $privilege[] = 0;

        $sql_q = "SELECT * FROM `system_menu` WHERE `for_admin` IN (".implode(' ,',$privilege).")";

        return SApplication::$DB->query($sql_q)->fetchAll(PDO::FETCH_ASSOC);
    }
}