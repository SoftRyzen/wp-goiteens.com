<?php


class deal
{

    //Create deal and set id
    public function createDeal()
    {
        $deal_data = array(
            "Deal_Name" => sprintf('%s - %s', $this->data['name'], $this->data['product_name']),
            "Contact_Name" => $this->data['contact_id'],
            "Owner" => "1819773000001861117",
            "Email" => $this->data['email'],
            "Stage" => "Distribution",
            "Course" => $this->data['product_id'],
            "Name_for_1C" => (string)$this->data['product_name'],
            "Layout" => "1819773000048296005",
            "Requisite" => "1819773000199044096",
            "field19" => "_",
            "field17" => "Way4Pay",
            "field23" => "Нет данных",
            "Lead_Quality" => "0"
        );
        $this->data['deal_id'] = $this->zohoCrmApi->createRecord('Deals', $deal_data, 'id', 'approval, workflow, blueprint');
    }


}