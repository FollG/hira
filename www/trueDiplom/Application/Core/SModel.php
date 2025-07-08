<?php


namespace Core;

class SModel
{

    public static array $errors = [];
    public static array $code = [];

    protected  bool $paginatorEnabled = true;

    public function __construct(bool $paginatorEnabled = true)
    {
        if (!$paginatorEnabled)
            $this->setPaginatorEnabled($paginatorEnabled);
    }

    public function setPaginatorEnabled(bool $enabled = true) {
        $this->paginatorEnabled = $enabled;
    }


    /*
     * Более правильно использовать SException
     */
    protected function setError(string $code_id, array $message = [])
    {
        self::$errors[] = Lang::t($message[0]);
        self::$code[] = $code_id;

        $this->setLog($code_id, $message);
    }

    private function setLog(string $code_id, array $message = [])
    {
        SApplication::$DB->query('INSERT INTO `system_error` SET `code` = '
            . SApplication::$DB->quote($code_id).', `message` = ' . SApplication::$DB->quote(json_encode($message)));
    }

    public function getErrors(bool $last = false): array
    {
        return $last ? [end(self::$errors)]: self::$errors;
    }

    public function getErrorsCode(bool $last = false): array
    {
        return $last ? [end(self::$code)]: self::$code;
    }

}