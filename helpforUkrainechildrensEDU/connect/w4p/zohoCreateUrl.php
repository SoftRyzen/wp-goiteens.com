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
        $this->ZohoCreateUrl_checkout['amount'] = $data['price'];
        $this->ZohoCreateUrl_checkout['order_desc'] = 'Payment for order ' . $data['invoice']['invoice_id'] . '_' . strtolower($data['potential_contract']);
        $this->ZohoCreateUrl_checkout['currency'] = "UAH";
        $this->ZohoCreateUrl_checkout['fopid'] = $data['cred']['merchant']['id'];
        $this->ZohoCreateUrl_checkout['invoice_id'] = $data['potential_id'];
        $this->ZohoCreateUrl_checkout['order_id'] = $data['invoice']['invoice_id'] . '_' . strtolower($data['potential_contract']);
    }

}