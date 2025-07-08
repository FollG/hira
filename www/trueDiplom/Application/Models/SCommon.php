<?php
namespace Models;

use Core\SApplication;
use Core\SRoute;

class SCommon
{
    private static $version_cache = [];

    public static function findEmailsInString(string $str): ?array
    {
        $r = '/[\w\-]+@[\w\-]+\.\w{2,}[\.\w\-]*/';
        $res = [];
        if (preg_match_all($r, $str, $matches)) {
            foreach ($matches[0] as $candidate)
                if (filter_var($candidate, FILTER_VALIDATE_EMAIL))
                    $res[] = $candidate;
        }

        return empty($res) ? null : array_unique($res);
    }

    public static function findPhonesInString(string $str): ?array
    {
        $r = '/[(\d\ )\-]{7,}/';
        $res = [];
        if (preg_match_all($r, $str, $matches)) {
            foreach ($matches[0] as $candidate)
                if (!empty(self::sanitizePhoneNumber($candidate, $inter)))
                    $res[] = $inter;
        }

        return empty($res) ? null : array_unique($res);
    }

    public static function intersectKeyMulti(array $array, array $keys) :array
    {
        $res = [];
        foreach ($array ?? [] AS $k => $v) {
            $res[$k] = array_intersect_key($v, array_flip($keys));
        }

        return $res;
    }

    public static function intersectKeySingle(array $array, array $keys) :array
    {
        $res = array_intersect_key($array, array_flip($keys));;

        return $res;
    }

    public static function formatPhoneNumber($phone)
    {
        try {

            $phone = self::getNumbersOnly($phone);

            if(!empty($phone)) {
                $phone = self::sanitizePhoneNumber($phone);

                $phoneUtil = PhoneNumberUtil::getInstance();

                $phoner = $phoneUtil->parse($phone, 'RU');
                $isValid = $phoneUtil->isValidNumber($phoner);

                if ($isValid) {

                    $res = $phoneUtil->format($phoner, PhoneNumberFormat::INTERNATIONAL);
                }
            }
            return $res ?? null;
        } catch (\Exception $e) {
            return null;
        }

    }

    public static function money(float $m, $decimals = 2): string
    {
        return number_format($m, $decimals, ',', ' ');
    }


    public static function formatDate($date, $real_mask = 'Y-m-d', $new_mask = 'Y-m-d 00:00:00', $use_russian_if_possible = true, $disable_strict = false) {
        try {
            if (!$date && !strlen(trim($date))) {
                throw new \Exception('Error input date');
            }
            $array_date = date_parse_from_format($real_mask, $date);
            if(!empty($array_date['errors']) && !$disable_strict) {
                throw new \Exception('Discrepancy mask and date');
            }

            $d = new \DateTime();
            var_dump($d);
            $d->setDate($array_date['year'], $array_date['month'], $array_date['day']);
            $d->setTime($array_date['hour'], $array_date['minute'], $array_date['second']);
            var_dump($d);exit();
            if($use_russian_if_possible){
                $MonthNames=array("января", "февраля", "марта", "апреля", "мая", "июня", "июля", "августа", "сентября", "октября", "ноября", "декабря");
                $new_mask = str_replace('M', $MonthNames[date('n',$d->getTimestamp())-1], $new_mask);
            }

            $date = $d->format($new_mask);

            return $date;
        } catch (\Exception $e) {
            var_dump($e);exit();
            return null;
        }
    }

    public static function translit($s)
    {
        $s = (string)$s; // преобразуем в строковое значение
        $s = trim($s); // убираем пробелы в начале и конце строки
        $s = function_exists('mb_strtolower') ? mb_strtolower($s) : strtolower($s); // переводим строку в нижний регистр (иногда надо задать локаль)
        $s = strtr($s, array('а' => 'a', 'б' => 'b', 'в' => 'v', 'г' => 'g', 'д' => 'd', 'е' => 'e', 'ё' => 'e', 'ж' => 'j', 'з' => 'z', 'и' => 'i', 'й' => 'y', 'к' => 'k', 'л' => 'l', 'м' => 'm', 'н' => 'n', 'о' => 'o', 'п' => 'p', 'р' => 'r', 'с' => 's', 'т' => 't', 'у' => 'u', 'ф' => 'f', 'х' => 'kh', 'ц' => 'c', 'ч' => 'ch', 'ш' => 'sh', 'щ' => 'shch', 'ы' => 'y', 'э' => 'e', 'ю' => 'yu', 'я' => 'ya', 'ъ' => '', 'ь' => ''));
        return $s; // возвращаем результат
    }

    public static function isCyrillicString($text)
    {
        return preg_match('/[А-Яа-яЁё]/u', $text);
    }

    /**
     * Меняет раскладку текста с латинской на русскую
     * */
    public static function switchTextToRussian($text)
    {
        $str_search = array(
            "q", "w", "e", "r", "t", "y", "u", "i", "o", "p", "[", "]",
            "a", "s", "d", "f", "g", "h", "j", "k", "l", ";", "'",
            "z", "x", "c", "v", "b", "n", "m", ",", ".",

            "Q", "W", "E", "R", "T", "Y", "U", "I", "O", "P", "[", "]",
            "A", "S", "D", "F", "G", "H", "J", "K", "L", ";", "'",
            "Z", "X", "C", "V", "B", "N", "M", ",", "."
        );

        $str_replace = array(
            "й", "ц", "у", "к", "е", "н", "г", "ш", "щ", "з", "х", "ъ",
            "ф", "ы", "в", "а", "п", "р", "о", "л", "д", "ж", "э",
            "я", "ч", "с", "м", "и", "т", "ь", "б", "ю",

            "Й", "Ц", "У", "К", "Е", "Н", "Г", "Ш", "Щ", "З", "Х", "Ъ",
            "Ф", "Ы", "В", "А", "П", "Р", "О", "Л", "Д", "Ж", "Э",
            "Я", "Ч", "С", "М", "И", "Т", "Ь", "Б", "Ю"
        );

        return str_replace($str_search, $str_replace, $text);
    }

    public static function mb_ucfirst($str): string
    {
        $fc = mb_strtoupper(mb_substr($str, 0, 1));
        return $fc . mb_substr($str, 1);
    }

    public static function mb_basename($file): string
    {
        $arr = explode(DIRECTORY_SEPARATOR, $file);
        return end($arr);
    }

    /**
     * Функция склонения числительных в русском языке
     * titles => (1) яблоко, (2) яблока, (5) яблок
     * @param $number
     * @param string[] $titles
     * @return string
     */
    public static function declOfNum($number, $titles = ['штука', 'штуки', 'штук']): string
    {
        $cases = array(2, 0, 1, 1, 1, 2);
        return $titles[($number % 100 > 4 && $number % 100 < 20) ? 2 : $cases[min($number % 10, 5)]];
    }

    public static function sortMultiArray(&$array, $key)
    {
        uasort($array, function ($a, $b) use ($key) {
            return strnatcmp($a[$key], $b[$key]);
        });
    }

    public static function randomPassword(int $length = 8): string
    {
        $alphabet = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789";
        $pass = [];
        $alphaLength = strlen($alphabet) - 1;
        for ($i = 0; $i < $length; $i++) {
            $n = rand(0, $alphaLength);
            $pass[] = $alphabet[$n];
        }
        return implode($pass);
    }

    public static function encrypt(string $string): ?string
    {
        $result = [];

        $first = [
            0=>'q',1=>'w',2=>'e',3=>'r',4=>'t',5=>'y',6=>'u',7=>'i',8=>'o',9=>'p',
            10=>'a',11=>'s',12=>'d',13=>'f',14=>'g',15=>'h',16=>'j',17=>'k',18=>'l',
            19=>'z',20=>'x',21=>'c',22=>'v',23=>'b',24=>'n',25=>'m',
        ];
        $second = [
            0=>'m',1=>'n',2=>'b',3=>'v',4=>'c',5=>'x',6=>'z',
            7=>'l',8=>'k',9=>'j',10=>'h',11=>'g',12=>'f',13=>'d',14=>'s',15=>'a',
            16=>'p',17=>'o',18=>'i',19=>'u',20=>'y',21=>'t',22=>'r',23=>'e',24=>'w',25=>'q'
        ];

        foreach (str_split($string) as $value) {
            $result[] = $second[array_search($value,$first)];
        }

        return implode('', $result);
    }

    public static function decrypt(string $string): ?string
    {
        $result = [];

        $first = [
            0=>'q',1=>'w',2=>'e',3=>'r',4=>'t',5=>'y',6=>'u',7=>'i',8=>'o',9=>'p',
            10=>'a',11=>'s',12=>'d',13=>'f',14=>'g',15=>'h',16=>'j',17=>'k',18=>'l',
            19=>'z',20=>'x',21=>'c',22=>'v',23=>'b',24=>'n',25=>'m',
        ];
        $second = [
            0=>'m',1=>'n',2=>'b',3=>'v',4=>'c',5=>'x',6=>'z',
            7=>'l',8=>'k',9=>'j',10=>'h',11=>'g',12=>'f',13=>'d',14=>'s',15=>'a',
            16=>'p',17=>'o',18=>'i',19=>'u',20=>'y',21=>'t',22=>'r',23=>'e',24=>'w',25=>'q'
        ];

        foreach (str_split($string) as $value) {
            $result[] = $first[array_search($value,$second)];
        }

        return implode('', $result);
    }

}