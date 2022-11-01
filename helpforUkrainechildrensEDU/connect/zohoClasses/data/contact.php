<?php


class contact
{
    private $data;
    private $zoho;
    public $contact_id;

    public function __construct(array $data, $zoho)
    {
        $this->data = $data;
        $this->zoho = $zoho;
        $this->searchContact();
        if (empty($this->data['contact_id'])) {
            //create contact
            $this->createContact();
        }
        $this->contact_id=$this->data['contact_id'];
    }

    public function searchContact()
    {
        if (!empty($this->data['email'])) {
            $criteria = "select Email from Contacts where Email = '" . $this->data['email'] . "' limit 1";

        }
        if (!empty($criteria)) {
            $this->data['contact_id'] = $this->zoho->searchBy('Contacts', $criteria, 'id');
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


        $this->data['contact_id'] = $this->zoho->createRecord('Contacts', $contact_data, 'id', 'approval, workflow, blueprint');
    }
}