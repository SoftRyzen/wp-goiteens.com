<?php


class deal
{
    private $data;
    private $zoho;
    public $deal_id;

    public function __construct(array $data, $zoho)
    {
        $this->data = $data;
        $this->zoho = $zoho;
        $this->createDeal();
        $this->deal_id = $this->data['deal_id'];
    }

    //Create deal and set id
    public function createDeal()
    {
        $deal_data = array(
            "Deal_Name" => sprintf('%s - %s', $this->data['name'], $this->data['cred']['product_name']),
            "Contact_Name" => $this->data['contact_id'],
            "Owner" => "1819773000001861117",
            "Email" => $this->data['email'],
            "Stage" => "Distribution",
            "Course" => $this->data['cred']['product_id'],
            "Name_for_1C" => (string)$this->data['cred']['product_name'],
            "Layout" => "1819773000048296005",
            "Requisite" => $this->data['cred']['merchant_id'],
            "field19" => "_",
            "field17" => "Way4Pay",
            "field23" => "Нет данных",
            "Lead_Quality" => "0"
        );
        $this->data['deal_id'] = $this->zoho->createRecord('Deals', $deal_data, 'id', 'approval, workflow, blueprint');
    }

}