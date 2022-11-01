<?php

class signature
{
    public $signature_array=array(
        'request_status' => '',
        'signed_key' => '',
        'module' => 'signature',
        'message'=>''
    );
    const FIELDS_DELIMITER = ';';
    const DEFAULT_CHARSET = 'utf8';


    /**
     * @param array $input_data
     * @return array
     */
    public function __construct(array $fieldsValues, $secret)
    {

        if ($this->dataIsArray($fieldsValues)){
            $key= $this->calculateSignature($fieldsValues,$secret);
            $this->signature_array['request_status']='ok';
            $this->signature_array['signed_key']=$key;
        } else {
            $this->signature_array['request_status']='error';
            $this->signature_array['message']='Input data not array!';
        }

    }

    private function calculateSignature(array $fieldsValues, $secret)
    {
        $keys_string = implode(self::FIELDS_DELIMITER, $fieldsValues);
        return hash_hmac('md5', $keys_string, $secret);
    }

    private function dataIsArray($data)
    {
        if (is_array($data)) {
            return true;
        } else {
            return false;
        }
    }
}