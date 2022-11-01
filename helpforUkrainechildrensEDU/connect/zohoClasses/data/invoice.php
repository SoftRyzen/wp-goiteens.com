<?php


class invoice
{
    private $zohoCrmApi;
    private $invoice_post_array = array(
        "Potential" => array(
            "id" => ""
        ),
        "Currency" => "UAH",
        "New_Currency" => "UAH",
        "Status" => "Expected",
        "Payment_url_w4p" => null,
        "Project" => "GoITeens",
        "Contract" => "",
        "Contact_Name" => array(
            "id" => ""
        ),
        "Final_Cost_Currency" => "",
        "Exchange_Rate" => 1,
        "Grand_Total" => "",
        "Product_Details" => array(
            array("product" => array(
                "id" => ""
            ),
                "quantity" => 1,
                "net_total" => "",
                "Tax" => 0,
                "list_price" => "",
                "total" => ""
            )
        ),
        "Created_By" => array(
            "id" => "1819773000001861117",
        ),
        "how_he_pays_tech" => "Way4Pay",
        "Invoice_Date" => "",
        "field7" => '',
        "Requisite" => array(
            "id" => ""
        ),
        "Due_Date" => "",
        "Grand_Total_dec" => "",
        "Subject" => "",
        "$\approval_state" => "approved"
    );
    public $invoice_id;

    public function __construct(array $data, $zoho)
    {
        $this->zohoCrmApi = $zoho;
        $this->formPostArray($data);
        $invdata = $this->insertNewInvoiceCRM($this->invoice_post_array, $this->zohoCrmApi);
    }

    private function formPostArray(array $data)
    {

        $price = floatval(number_format($data['sum'], "0", "", ""));
        $this->invoice_post_array['Potential']['id'] = $data['potential_id'];
        $this->invoice_post_array['Contract'] = $data['contact_id'];
        $this->invoice_post_array['Currency'] = $data['curr'];
        $this->invoice_post_array['New_Currency'] = $data['curr'];
        $this->invoice_post_array['Contact_Name']['id'] = intval($data['contact_id']);
        $this->invoice_post_array['Final_Cost_Currency'] = $price;
        $this->invoice_post_array['Name_for_1C'] = $data['cred']['product_name'];
        $this->invoice_post_array['Grand_Total'] = $price;
        $this->invoice_post_array['Grand_Total_dec'] = $price;
        $this->invoice_post_array['Invoice_Date'] = date("Y-m-d");
        $this->invoice_post_array['Product_Details'][0]['product']['id'] = $data['cred']['product_id'];
        $this->invoice_post_array['Product_Details'][0]['net_total'] = $price;
        $this->invoice_post_array['Product_Details'][0]['list_price'] = $price;
        $this->invoice_post_array['Product_Details'][0]['total'] = $price;
        $this->invoice_post_array['Requisite'] = $data['cred']['merchant_id'];
        $this->invoice_post_array['Subject'] = $data['name'] . '_' . $data['cred']['product_name'];
        $this->invoice_post_array['Due_Date'] = $this->getDueDate();
    }

    private function getDueDate()
    {
        return date("Y-m-d", strtotime("+3 day"));
    }

    private function insertNewInvoiceCRM($invoice_data)
    {
        $this->invoice_id = $this->zohoCrmApi->createRecord('Invoices', $invoice_data, 'id', 'approval, workflow, blueprint');

    }


}