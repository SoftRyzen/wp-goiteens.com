<?php


class request_payment
{
    public $return_array = array(
        "request_status" => "",
        "module" => "request_payment",
        "message" => "",
        "payment_url" => "",
        "w4p_id" => ""
    );

    public function __construct(array $data, $url)
    {
        $this->return_array['w4p_id'] = $data['orderReference'];
        $apidata = $this->sendRequest($url, $data);
        $this->checkAPIAnswer($apidata);
    }

    private function sendRequest($url, array $post_data)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($post_data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        $result = curl_exec($ch);
        curl_close($ch);
        //echo json_encode($result, JSON_PRETTY_PRINT);
        return json_decode($result, true);
    }

    private function checkAPIAnswer($answer_data)
    {
        if ($answer_data == null) {
            $this->return_array['request_status'] = 'error';
            $this->return_array['message'] = 'w4P api answer error is NULL!';
            return false;
        }

        if (!is_array($answer_data)) {
            $this->return_array['request_status'] = 'error';
            $this->return_array['message'] = 'w4P api answer error not array!';
            return false;
        }

        if ($answer_data["reason"] == "Ok" && $answer_data["reasonCode"] == 1100) {
            $this->return_array['request_status'] = 'ok';
            $this->return_array['payment_url'] = $answer_data["invoiceUrl"];
            return true;
        } else {
            $this->return_array['request_status'] = 'error';
            $this->return_array['message'] = 'w4P api answer error! ' . $answer_data["reasonCode"] . ' ' . $answer_data["reason"];
            return false;
        }
    }


}