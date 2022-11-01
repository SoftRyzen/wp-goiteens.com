<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

header('Access-Control-Allow-Origin: *');

header('Content-Type: text/html; charset=utf-8');

require_once(dirname(__FILE__) . '/autoload.php');



$data = file_get_contents("php://input");
//file_put_contents('logdata_in.txt', $data);
file_put_contents('logdata_post_in.txt', json_encode($_POST).PHP_EOL.PHP_EOL,FILE_APPEND);
echo json_encode($_POST);
