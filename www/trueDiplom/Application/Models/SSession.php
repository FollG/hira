<?php
namespace Models;

use Core\{SApplication, SModel};

use PDO;

class SSession extends SModel
{
    public ?array $user = null;

    public function __construct()
    {
        parent::__construct();
    }


    public static function isAuth(): bool
    {
        return !empty($_SESSION['user']);
    }

    public static function setRealSession(string $key, $value):void
    {
        $_SESSION[$key] = $value;
    }

    public static function getRealSession(): array
    {
        return $_SESSION;
    }

    public function setSession($value = null, array $keys = null)
    {
        if (!empty($keys)) {
            $keys_a = array_keys($keys);
            $b = null;
            for ($i = 0; $i < count($keys_a); $i++) {
                $current_key = $keys[$keys_a[$i]];

                if ($i === 0) {
                    if (!isset($this->user[$current_key])) {
                        $this->user[$current_key] = null;
                    }
                    $b = &$this->user[$current_key];
                } else {
                    if (!isset($b[$current_key])) {
                        $b[$current_key] = null;
                    }
                    $b = &$b[$current_key];
                }
                if (count($keys_a) - 1 === $i) {
                    $b = $value;
                }
            }
        } else {
            $this->user = $value;
        }
    }

    public function getValueSession(array $keys)
    {
        try {
            $val = null;
            foreach ($keys as $v) {
                if (null === $val && !isset($this->user[$v])) {
                    throw new \Exception('error path key', 1);
                } else if (null === $val) {
                    $val = &$this->user[$v];
                } else if (isset($val[$v])) {
                    $val = &$val[$v];
                } else {
                    throw new \Exception('error path key', 2);
                }
            }
            return $val;
        } catch (\Exception $e) {
            return null;
        }
    }

    public function getSession(): ?array
    {
        return $this->user;
    }
}