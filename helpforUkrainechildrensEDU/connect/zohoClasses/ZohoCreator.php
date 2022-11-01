<?php
require_once "/home/teens00/goiteens.com/www/helpforUkrainechildrensEDU/connect/zohoClasses/autoload.php";

class ZohoCreator
{
    private $data;
    public $final_data;

    public function __construct(array $data, $zoho)
    {

        $this->data = $data;
        $this->data['randInv'] = $this->generateRandomString(16);
        $cred = new credentials();
        $this->data['cred'] = $cred->cred;
        $this->data['name'] = "donate_" . $this->generateRandomString();
        $contact = new contact($this->data, $zoho);
        $this->data['contact_id'] = $contact->contact_id;
        $deal = new deal($this->data, $zoho);
        $this->data["potential_id"] = $deal->deal_id;
        $invoice = new invoice($this->data, $zoho);
        $this->data['invoice_id'] = $invoice->invoice_id;
        $this->final_data = $this->data;
    }

    private function generateRandomString($length = 12)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyz';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
}