<?php
require_once "/home/teens00/goiteens.com/www/helpforUkrainechildrensEDU/connect/w4p/autoload.php";

class w4pStart
{
    public $final_data;
    public function __construct(array $data)
    {
        $zohourl = new zohoCreateUrl($data);
        $zohourl->ZohoCreateUrl_checkout['fop_key'] = $data['cred']['merchant_Account'];
        $payment = new payment($zohourl->ZohoCreateUrl_checkout);
        $signature = new signature($payment->w4p_payment_signature_array, $data['cred']['merchant_secretkey']);
        $payment->w4p_curl_header_data['merchantSignature'] = $signature->signature_array['signed_key'];
        $request = new request_payment($payment->w4p_curl_header_data, $payment->w4p_payment_url);

        if ($request->return_array['request_status']=="ok") {
            $data['dealW4Purl'] = $request->return_array['payment_url'];
            $data['deal_w4p_invoice'] = $request->return_array['w4p_id'];
        }
        $this->final_data=$data;
    }


}