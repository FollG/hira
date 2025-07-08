<?php

function checkData(array $params, array $optional = [], array $setting = ['empty' => true],
                         $method = 'POST', &$data = null) {
    $error = [];

    if($data) {
        $_VALUES =& $data;
    } else {
        $_VALUES =& \Core\SRoute::$PARAMS[$method];
    }

    $params_no_empty = [];
    if (!function_exists('__htmlspecialchars')) {
        function __htmlspecialchars($val)
        {
            if (!empty($val)) {
                if (is_array($val)) {
                    foreach ($val as &$v) {
                        $v = __htmlspecialchars($v);
                    }
                } else {
                    $val = htmlspecialchars_decode(trim($val));
                    $val = htmlspecialchars(trim($val));
                }
            }
            return $val;
        }
    }

    foreach ($params as $item) {
        $s = explode(':', $item);
        $value = $s[0];
        $type = $s[1] ?? 's';
        if (!isset($_VALUES[$value]) && !in_array($value, $optional)) {
            $error[] = $value;
        } else if(!isset($_VALUES[$value]) || (is_string($_VALUES[$value]) && strlen(trim(strval($_VALUES[$value]))) === 0)) {
            $_VALUES[$value] = null;

            if(!in_array($value, $optional)) {
                $error[] = $value;
            }

        } if (isset($_VALUES[$value])) {
            $_VALUES[$value] = is_string($_VALUES[$value])
                ? trim($_VALUES[$value])
                : $_VALUES[$value];

            switch ($type) {
                case 'i': // int
                    if (is_numeric($_VALUES[$value])) {
                        $_VALUES[$value] = (int)$_VALUES[$value];
                    } else {
                        $error[] = $value;
                    }
                    break;
                case 'd': //date
                    $re = "/^(((0[1-9]|[12]\d|3[01])\.(0[13578]|1[02])\.((19|[2-9]\d)\d{2}))|((0[1-9]|[12]\d|30)\.(0[13456789]|1[012])\.((19|[2-9]\d)\d{2}))|((0[1-9]|1\d|2[0-8])\.02\.((19|[2-9]\d)\d{2}))|(29\.02\.((1[6-9]|[2-9]\d)(0[48]|[2468][048]|[13579][26])|((16|[2468][048]|[3579][26])00))))$/";
                    if(preg_match($re, $_VALUES[$value])) {
                        $_VALUES[$value] = new DateTime($_VALUES[$value]);
                    } else {
                        $error[] = $value;
                    }
                    break;
                case 'dt': //datetime
                    if (DateTime::createFromFormat('d.m.Y H:i',  $_VALUES[$value]) ||
                        DateTime::createFromFormat('Y-m-d H:i',  $_VALUES[$value])
                    ) {
                        $_VALUES[$value] = new DateTime($_VALUES[$value]);
                    } else {
                        $error[] = $value;
                    }

                    break;
                case 'a': //array
                    if(!is_array($_VALUES[$value])) {
                        $error[] = $value;
                    } else {
                        $_VALUES[$value] = __htmlspecialchars($_VALUES[$value]);
                    }
                    break;
                case 'm': //mail
                    if (!filter_var($_VALUES[$value], FILTER_VALIDATE_EMAIL)) {
                        $error[] = $value;
                    } else {
                        $_VALUES[$value] = __htmlspecialchars($_VALUES[$value]);
                    }

                    break;
                case 't': //
                    if(!preg_match("/^(?:2[0-3]|[01][0-9]):[0-5][0-9]$/", $_VALUES[$value])){
                        $error[] = $value;
                    }
                    break;
                case 'mn' : //money
                    $_VALUES[$value] = !empty($_VALUES[$value])
                        ? str_replace(',', '',  $_VALUES[$value]) : null;

                    if (!empty($_VALUES[$value]) && is_numeric($_VALUES[$value])) {
                        $_VALUES[$value] = (float)$_VALUES[$value];
                    } else {
                        $error[] = $value;
                    }

                    break;
                case 'b' : //bool
                    $_VALUES[$value] = filter_var($_VALUES[$value], FILTER_VALIDATE_BOOLEAN);
                    break;
                case 'f': //float
                    if (is_numeric($_VALUES[$value])) {
                        $_VALUES[$value] = (float)$_VALUES[$value];
                    } else {
                        $error[] = $value;
                    }
                    break;
                default:
                    $_VALUES[$value] = __htmlspecialchars($_VALUES[$value]);

            }
            $params_no_empty[] = $_VALUES[$value];
        }
    }

    if (!empty($error) || (false === $setting['empty']) && empty($params_no_empty)) {
        if($method === 'POST') {
            \Core\SModulesController::showJson(
                \Core\SModulesController::buildError(
                    [
                        'message' => [\Diversen\Lang::t('Error input params')],
                        'error' => $error
                    ])
            );
            exit;
        } else {
            die( \Diversen\Lang::t('Error input params'));
        }
    }
}
