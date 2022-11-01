<?php

class payment
{
    public $w4p_payment_signature_array;
    public $w4p_payment_url = 'https://api.wayforpay.com/api';
    public $w4p_payment_invoice_id;
    public $w4p_curl_header_data = array(
        "transactionType" => "CREATE_INVOICE",
        "merchantAccount" => "",
        "merchantAuthType" => "SimpleSignature",
        "merchantDomainName" => "payment.goit.ua",
        "returnUrl" => "https://payment.goiteens.ua/checkout_success.php",
        "orderReference" => "",
        "orderDate" => "",
        "apiVersion" => 1,
        "amount" => "",
        "serviceUrl" => "",
        "currency" => "",
        "orderTimeout" => 31104000,
        "productName" => array(),
        "productPrice" => array(),
        "productCount" => array(),
        "defaultPaymentSystem" => "card",
        "merchantSignature" => ""
    );

    public function __construct(array $payment_array)
    {
        $this->setHeaderDataArray($payment_array);
        $this->setSignatureArray();
    }

    private function setHeaderDataArray(array $payment_array)
    {
        $amount = floatval(number_format($payment_array['amount'], 2, '.', ''));
        $this->w4p_curl_header_data['merchantAccount'] = strval($payment_array['fop_key']);
        $this->w4p_curl_header_data['orderReference'] = strval($payment_array['order_id']);
        $this->w4p_curl_header_data['orderDate'] = $this->getDateTimeNowUnix();
        $this->w4p_curl_header_data['amount'] = floatval($amount);
        $this->w4p_curl_header_data['serviceUrl'] = 'https://payment-w4p-if.goiteens.ua/service/?merch_id=' . $payment_array['fopid'] . '&invoice_id=' . $payment_array['invoice_id'] . '&requesttype=payment&w4p_pass=klasjdaklsjdaxvcvhu9h3423';
        $this->w4p_curl_header_data['currency'] = strtoupper($payment_array['currency']);
        $this->w4p_curl_header_data['productName'][] = strval($payment_array['order_desc']);
        $this->w4p_curl_header_data['productPrice'][] = floatval($amount);
        $this->w4p_curl_header_data['productCount'][] = 1;
        $this->w4p_payment_invoice_id = strval($payment_array['invoice']);
    }

    private function getDateTimeNowUnix()
    {
        return time();
    }

    private function setSignatureArray()
    {
        $this->w4p_payment_signature_array = array(
            $this->w4p_curl_header_data['merchantAccount'],
            $this->w4p_curl_header_data['merchantDomainName'],
            $this->w4p_curl_header_data['orderReference'],
            $this->w4p_curl_header_data['orderDate'],
            $this->w4p_curl_header_data['amount'],
            $this->w4p_curl_header_data['currency'],
            $this->w4p_curl_header_data['productName'][0],
            $this->w4p_curl_header_data['productCount'][0],
            $this->w4p_curl_header_data['productPrice'][0]
        );
    }


}