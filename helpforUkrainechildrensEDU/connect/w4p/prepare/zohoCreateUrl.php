<?php

class ZohoCreateUrl
{
    public $ZohoCreateUrl_checkout = array();
    public function __construct(array $data)
    {
        $this->createPostArray($data);

    }

    private function createPostArray(array $data)
    {
        $this->ZohoCreateUrl_checkout['amount'] = $data['sum'];
        $this->ZohoCreateUrl_checkout['order_desc'] = 'Payment for order  ' . $data['invoice_id'] . '_' . strtolower($data['randInv']);
        $this->ZohoCreateUrl_checkout['currency'] = $data['curr'];
        $this->ZohoCreateUrl_checkout['merchant_id'] = $data['cred']['merchant_id'];
        $this->ZohoCreateUrl_checkout['invoice_id'] = $data['invoice_id'];
        $this->ZohoCreateUrl_checkout['order_id'] = $data['invoice_id'] . '_' .strtolower($data['randInv']);
    }



}