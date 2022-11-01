<?php
require_once('autoload.php');
$post = file_get_contents("php://input");
if (!empty($_POST))
 {
    $data=json_decode($post,true);

} else {
        die('error');
}
$zoho=new ZohoCrmApi();
$cred=new cred();
$data['cred']=$cred->credentials;

$invoice=new Invoice($data, $zoho);
//echo json_encode($invoice->return_array);
$data['invoice']=$invoice->return_array;

// create zohourl arrays
$zohourl = new zohoCreateUrl($data);
$zohourl->ZohoCreateUrl_checkout['fop_key'] = $data['cred']['merchant']['merchantAccount'];

// create payment
$payment = new payment($zohourl->ZohoCreateUrl_checkout);

// create signatures
$signature = new signature($payment->w4p_payment_signature_array, $data['cred']['merchant']['merchantSecretKey']);

//insert signatures into payment arrays
$payment->w4p_curl_header_data['merchantSignature'] = $signature->signature_array['signed_key'];

// get W4P invoiceUrls
$request = new request_payment($payment->w4p_curl_header_data, $payment->w4p_payment_url);
//check W4P invoiceUrls
if (validateRequestStatus($request->return_array)) {
    $data['dealW4Purl'] = $request->return_array['payment_url'];
    $data['deal_w4p_invoice'] = $request->return_array['w4p_id'];
}

// update invoices
$invoice->updateInvoice($data['invoice']['invoice_id'], $data['dealW4Purl'], $data['deal_w4p_invoice']);

//log all data!
file_put_contents('data.php', date('d-m-Y H-m') . '   ' . json_encode($data) . PHP_EOL, FILE_APPEND);
$payment_id=str_replace('','',$data['dealW4Purl']);

//print url for first payment
echo json_encode(array(
    "status" => "ok",
    "url" => $data['dealW4Purl']
));

function validateRequestStatus(array $data)
{
    if (!isset($data['request_status']) || $data['request_status'] != 'ok') {
        echo json_encode(array(
            "status" => "error",
            "url" => ""
        ));
        die();
    } else {
        return true;
    }

}
