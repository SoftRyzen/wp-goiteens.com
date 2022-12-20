<?php
defined('ABSPATH') || exit;

add_filter(
    'wp_php_error_message',
    function( $message, $error )
    {

        $telegramMessage = '<b>Ошибка на сайте</b>' . PHP_EOL . PHP_EOL;
        if ( function_exists('get_the_permalink') )
        {
            $telegramMessage .= 'Страница: <code><a href="' . get_the_permalink() . '">' . get_the_permalink() . '</a></code>' . PHP_EOL;
        }
        $telegramMessage .= 'Сообщение: <code>' . $error['message'] . '</code>' . PHP_EOL;
        $telegramMessage .= 'Файл: <code>' . $error['file'] . '</code>' . PHP_EOL;
        $telegramMessage .= 'Строка: <code>' . $error['line'] . '</code>';

        $getQuery = array(
            "chat_id" 	=> -1001886465230,
            "text"  	=> $telegramMessage,
            "parse_mode" => "html"
        );

        // токен бота
        define('TELEGRAM_TOKEN', '5777708660:AAHA6x-mkOWofYlv74gLD1HStxuy8pMVZkc');

        $ch = curl_init('https://api.telegram.org/bot'.TELEGRAM_TOKEN.'/sendMessage?' . http_build_query($getQuery));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_exec($ch);
        curl_close($ch);

        return $message;
    },
    10,
    2
);
