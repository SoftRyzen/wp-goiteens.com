<?php


class contact
{


    public function searchContact()
    {
        if (!empty($this->data['email']) ) {
            $criteria = "select Email from Contacts where Email = '" . $this->data['email'] . "' limit 1";

        }
        if (!empty($criteria)) {
            $this->data['contact_id'] = $this->zohoCrmApi->searchBy('Contacts', $criteria, 'id');
        }
    }

    //Create contact and set id
    public function createContact()
    {
        $contact_data = array(
            "Last_Name" => "_",
            "Email" => $this->data['email'],
            "Owner" => "1819773000001861117",
            "Layout" => "1819773000000091033"
        );
        $contact_data['First_Name'] = (string)$this->data['name'];


        $this->data['contact_id'] = $this->zohoCrmApi->createRecord('Contacts', $contact_data, 'id', 'approval, workflow, blueprint');
    }
}