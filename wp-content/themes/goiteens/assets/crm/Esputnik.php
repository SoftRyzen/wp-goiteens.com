<?php


class Esputnik
{

    private $apiKey;
    private $login;
    private $import_contacts_url = 'https://esputnik.com/api/v1/contact/subscribe';
    private $request_entity_send;
    public $result;

    private function fillData($array_data)
    {
        $contact = new stdClass();

        $contact->firstName = (array_key_exists('name', $array_data)) ? $array_data['name'] : '';
        $contact->channels = array(
            array('type' => 'email', 'value' => (array_key_exists('email', $array_data)) ? $array_data['email'] : ''),
            array('type' => 'sms', 'value' => (array_key_exists('phone', $array_data)) ? $array_data['phone'] : '')
        );

        $request_entity = new stdClass();
        $request_entity->contact = $contact;
        $request_entity->formType = ['webinarUSA'];

        if (array_key_exists('product_name', $array_data)) {
            $request_entity->groups = array($array_data['product_name']);
        }

        $this->request_entity_send = $request_entity;

    }

    public function __construct($array)
    {
        $esputnik_options = get_option('_esputnik_options');
        if (!$esputnik_options['esputnik_login'] || !$esputnik_options['esputnik_token']) {
            return;
        }
        $this->login = $esputnik_options['esputnik_login'];
        $this->apiKey = $esputnik_options['esputnik_token'];

        $this->fillData($array);
        $this->send_request($this->import_contacts_url, $this->request_entity_send, $this->apiKey, $this->login);
    }


    private function send_request($url, $json_value, $password, $login)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($json_value));
        curl_setopt($ch, CURLOPT_HEADER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER,
            array('Accept: application/json',
                'Content-Type: application/json',
                'Authorization: Basic ' . base64_encode("$login:$password")));
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSLVERSION, 6);
        $output = curl_exec($ch);
        curl_close($ch);
        $this->result = $output;
    }
}
