<?php

namespace Settings\Models;

use Core\SApplication;
use Matrix\Exception;

class Settings extends \Core\SModel
{
    public function __construct(bool $paginatorEnabled = true)
    {
        parent::__construct($paginatorEnabled);
    }

    public function setStatus(string $name): bool
    {
        try {
            $sql_q = "INSERT INTO `data_statuses`(`name`, `icon`) VALUES (".SApplication::$DB->quote($name).", '/')";

            $st = SApplication::$DB->query($sql_q)->execute();

            if ($st === false) {
                throw new Exception('error while setting status. (Settings100)', 100);
            }

            return true;

        } catch (Exception $e) {
            throw new Exception($e->getMessage(), 101);
        }
    }

    public function setSurgency(string $name): bool
    {
        try {
            $sql_q = "INSERT INTO `data_urgency`(`name`, `icon`) VALUES (".SApplication::$DB->quote($name).", '/')";

            $st = SApplication::$DB->query($sql_q)->execute();

            if ($st === false) {
                throw new Exception('error while setting status. (Settings100)', 100);
            }

            return true;

        } catch (Exception $e) {
            throw new Exception($e->getMessage(), 101);
        }
    }

    public function setRoles(string $name): bool
    {
        try {
            $sql_q = "INSERT INTO `data_roles`(`name`, `access_id`) VALUES (".SApplication::$DB->quote($name).", '1')";

            $st = SApplication::$DB->query($sql_q)->execute();

            if ($st === false) {
                throw new Exception('error while setting status. (Settings100)', 100);
            }

            return true;

        } catch (Exception $e) {
            throw new Exception($e->getMessage(), 101);
        }
    }

    public function setUser(string $name, string $surname, string $patronymic, string $birthday, string $login,
                                         string $password, string $phone_number, int $role_id, string $email): bool
    {
        try {
            $sql_q = "INSERT INTO `data_users`(`name`, `surname`, `patronymic`, `birthday`, 
                         `login`, `password`, `phone_number`, `role_id`, `email`) 
                    VALUES (
                            ".SApplication::$DB->quote($name).",
                            ".SApplication::$DB->quote($surname).",
                            ".SApplication::$DB->quote($patronymic).",
                            ".SApplication::$DB->quote((new \DateTime($birthday))->format("Y-m-d")).",
                            ".SApplication::$DB->quote($login).",
                            ".SApplication::$DB->quote(base64_encode(\Models\SCommon::encrypt($password))).",
                             ".SApplication::$DB->quote(preg_replace('(^8|7|\+7)((\d{10})|(\s\(\d{3}\)\s\d{3}\s\d{2}\s\d{2})', $phone_number)).",
                             $role_id,
                              ".SApplication::$DB->quote($email)."
                    )";

            $st = SApplication::$DB->query($sql_q)->execute();

            if ($st === false) {
                throw new Exception('error while setting status. (Settings100)', 100);
            }

            return true;

        } catch (Exception $e) {
            throw new Exception($e->getMessage(), 101);
        }
    }

    public function setProject(string $name, int $user_id): bool
    {
        try {
            $sql_q = "INSERT INTO `data_projects`(`name`, `userID`, `icon`)
                VALUES (
                    ".SApplication::$DB->quote($name).",
                    $user_id,
                    '/'                                                         
                )";

            $st = SApplication::$DB->query($sql_q);

            if ($st === false) {
                throw new Exception('error while setting status. (Settings100)', 100);
            }

            return true;

        } catch (Exception $e) {
            throw new Exception($e->getMessage(), 101);
        }
    }
}