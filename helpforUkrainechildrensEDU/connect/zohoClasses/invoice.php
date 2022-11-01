<?php


class invoice
{
    public $return_array = array(
        "request_status" => "",
        "module" => "Invoices",
        "message" => "",
        "invoice_id" => ""
    );


    private $zohoCrmApi;

    public function __construct(array $data, $zoho)
    {
        $this->zohoCrmApi = $zoho;
        //first ivoice due data +1 day, autocheck enabled
        $this->formPostArray($data, 'f');
        $invdata = $this->insertNewInvoiceCRM($this->invoice_post_array, $this->zohoCrmApi);
        $invparse = $this->checkAPIAnser($invdata);
        if ($invparse != false) {
            $this->return_array['invoice_id'] = $invparse;
        }
        $this->return_array['request_status'] = 'ok';

    }

    private function formPostArray(array $data, $inv_number)
    {

        $price=floatval(number_format($data['price'],'0','',''));
        $this->invoice_post_array['Potential']['id'] = $data['potential_id'];
        $this->invoice_post_array['Contract'] = $data['contact_id'];
        $this->invoice_post_array['Contact_Name']['id'] = intval($data['contact_id']);
        $this->invoice_post_array['Final_Cost_Currency'] = $price;
        $this->invoice_post_array['Name_for_1C'] = $data['cred']['product']['product_name'];
        $this->invoice_post_array['Grand_Total'] = $price;
        $this->invoice_post_array['Grand_Total_dec'] = $price;
        $this->invoice_post_array['Invoice_Date'] = $this->getDueDate('c');
        $this->invoice_post_array['Product_Details'][0]['product']['id'] = $data['cred']['product']['product_id'];
        $this->invoice_post_array['Product_Details'][0]['net_total'] = $price;
        $this->invoice_post_array['Product_Details'][0]['list_price'] = $price;
        $this->invoice_post_array['Product_Details'][0]['total'] = $price;
        $this->invoice_post_array['Requisite'] = $data['cred']['merchant']['id'];
        $this->invoice_post_array['Subject'] = $data['contact_firstname'].'_'.$data['contact_lastname'] . '_' . $data['cred']['product']['product_name'];
        $this->invoice_post_array['Due_Date'] = $this->getDueDate('f');
    }

    private function getDueDate($datetype)
    {
        switch ($datetype) {
            case 'f':
                return date("Y-m-d", strtotime("+1 day"));
            case 'c':
                return date("Y-m-d");
            default:
                return date("Y-m-d");
        }
    }

    private function insertNewInvoiceCRM($invoice_data)
    {
        $api_answer = $this->zohoCrmApi->updateRecord('Invoices', $invoice_data, 'id', 'approval, workflow, blueprint');
        return $api_answer;
    }

    private function checkAPIAnser($data)
    {
        if ($data != null ) {
            return $data;
        } else {
            $this->return_array['request_status'] = 'error';
            $this->return_array['message'] = 'Error creationg Invoice!';
            return false;
        }
    }

    public function updateInvoice($invoice_id, $payment_url, $order_id)
    {
        if (empty($order_id)) {
            return array(
                'request_status' => 'error',
                'module' => 'insert url to crm',
                'message' => 'order_id empty!'
            );
        }
        if (empty($invoice_id)) {
            return array(
                'request_status' => 'error',
                'module' => 'insert url to crm',
                'message' => 'invoice_id empty!'
            );
        }

        $request = [
            'Payment_url_w4p' => stripcslashes($payment_url),
            'orderReference_w4p' => strtolower($order_id)
        ];

        $invoice = ($this->zohoCrmApi->updateRecord('Invoices', $invoice_id, $request, '', 'approval, workflow, blueprint'));

        if ((isset($invoice['data'][0]['status']) && $invoice['data'][0]['status'] == "error") || (isset($invoice['status']) && $invoice['status'] == "error")) {
            $this->return_array['request_status'] = 'error';
            $this->return_array['message'] = 'updating Invoice ' . $invoice_id . ' failed';

        } else {
            $this->return_array['request_status'] = 'ok';
        }
    }


}