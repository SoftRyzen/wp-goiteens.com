<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
header('Access-Control-Allow-Origin: *');
header('Content-Type: text/html; charset=utf-8');
require_once "/home/teens00/goiteens.com/www/helpforUkrainechildrensEDU/connect/autoload.php";

file_put_contents('logdata_post_in.txt', json_encode($_POST) . PHP_EOL . PHP_EOL, FILE_APPEND);
$zoho = new ZohoCrmApi();
$zohoCreator = new ZohoCreator($_POST, $zoho);
$data = $zohoCreator->final_data;
$w4p = new w4pStart($data);
$data['w4p'] = $w4p->final_data;
    $invUpdater=new invoiceUpdater();
$invUpdater->updateInvoice($data['invoice_id'],$data['w4p']['dealW4Purl'],$data['w4p']['deal_w4p_invoice'], $zoho);
file_put_contents("/home/teens00/goiteens.com/www/helpforUkrainechildrensEDU/connect/logs/".date("d-m-Y").".txt",PHP_EOL."----- ".date("H:i:s")." ------".PHP_EOL.json_encode($data).PHP_EOL,FILE_APPEND);
echo json_encode(
    array(
        "status"=>"ok",
        "url"=>$data['w4p']['dealW4Purl']
    )
);
die();
