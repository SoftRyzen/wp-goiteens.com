<?php


namespace components;


class Params
{
    public function save()
    {
        if ($this->validatePassword($_POST['password'])) {
            $file = fopen(dirname(__FILE__, 2) . '/params.ini', 'w+');
            fwrite($file, "PRODUCT_NAME={$_POST['product_name']}\n");
            fwrite($file, "PRODUCT_ID={$_POST['product_id']}\n");
            fwrite($file, "GTM={$_POST['gtm']}\n");
            fwrite($file, "LEELOO_HASH={$_POST['leeloo_hash']}\n");
            fwrite($file, "START_DATE={$_POST['start_date']}\n");
            fclose($file);
        } else {
            echo 'Пароль введен не верно!';
        }
    }

    public function validatePassword($password)
    {
        return password_verify($password, $_ENV['PASSWORD_FORM']);
    }

    public static function getParams()
    {
        return parse_ini_file(dirname(__FILE__, 2) . '/params.ini');

    }

}