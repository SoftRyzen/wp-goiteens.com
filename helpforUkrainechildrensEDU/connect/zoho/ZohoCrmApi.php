<?php

class ZohoCrmApi
{
    private $oauth_token = '';
    

    public function __construct()
    {
        $this->oauth_token = $this->getAccessToken();
    }
    
    
    private function getAccessToken()
    {        
        $file_token = dirname(__FILE__).'/token.php';
        
        if (file_exists($file_token) && ((filemtime($file_token) + 1800) > time())) {
            $token = include($file_token);
            
            if (empty($token['token'])) {
                $token['token'] = $this->generateAccessFromRefreshToken();
                
                file_put_contents($file_token, '<?php '.PHP_EOL.'return ' . var_export($token, true) . ';');                
            } 
        } else {
            $token['token'] = $this->generateAccessFromRefreshToken();
            file_put_contents($file_token, '<?php '.PHP_EOL.'return ' . var_export($token, true) . ';');
        }
        return $token['token'];
    }
    
    
    private function generateAccessFromRefreshToken()
    {
        $headers = array(    
            'Content-Type: application/x-www-form-urlencoded'
        );
        
        $post_fields = array(
            'refresh_token' => Constants::ZOHO_REFRESH_TOKEN,
            'client_id'     => Constants::ZOHO_CLIENT_ID,
            'client_secret' => Constants::ZOHO_CLIENT_SECRET,
            'grant_type'    => 'refresh_token'
        );
            
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://accounts.zoho.com/oauth/v2/token");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_MAXREDIRS, 10);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post_fields));
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);       

        $response = curl_exec($ch);
        curl_close($ch);
        
        $response_obj = json_decode($response);
    
        if (isset($response_obj->access_token)) {
            $access_token = $response_obj->access_token;
        } else {
            $access_token = '';
        }
        
        return $access_token;
    }
    
    
    public function getDataFromCrm($url, $param, $method)
    {      
        $headers = array(    
            'Authorization: Zoho-oauthtoken ' . $this->oauth_token,
            'Content-Type: application/json'
        );
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "$method");
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        if (($method == "POST") || ($method == "PUT")) {
            curl_setopt($ch, CURLOPT_POSTFIELDS, $param);
        }
        $result = curl_exec($ch);
        
        if($result === false) {
            file_put_contents(dirname(__FILE__) . '/errorsLog.txt', date('Y-m-d H:i:s') . "Error curl: " . curl_error($ch) . "\n", FILE_APPEND);
        }
        
        curl_close($ch);
        
        return $result;
    }
    
    
    /*
     * Search record
     */
    public function searchBy($module_name, $criteria, $field_name = '')
    {
        $url = "https://www.zohoapis.com/crm/v2/coql";
        
        $module_data = array(
            'select_query' => $criteria
        );
        
        //make request
        $result = $this->getDataFromCrm($url, json_encode($module_data), "POST");
    
        if (isset($result)) {
            $result_array = json_decode($result, true);
            
            if (isset($result_array['status']) && $result_array['status'] == "error") {
                //log error to file
                file_put_contents(dirname(__FILE__) . '/errorsLog.txt', date('Y-m-d H:i:s') . "Error $module_name: " . $result . "\n", FILE_APPEND);
                
            } else {
                return !empty($field_name) ? $this->getByField($result_array, 'search', $field_name) : $result_array;
            }  
        }
        
        return null;  
    }

    
    /*
     * Create record
     */
    public function createRecord($module_name, $module_data, $field_name = '', $trigger = '') //$trigger = approval, workflow, blueprint
    {
        $url = "https://www.zohoapis.com/crm/v2/" . $module_name;
        
        $data = array(
            "data" => array(
                $module_data
            ),
            "trigger" => explode(", ", $trigger)
        );
        //make request
        $result = $this->getDataFromCrm($url, json_encode($data), "POST");

        if (isset($result)) {
            $result_array = json_decode($result, true);
            
            if ((isset($result_array['data'][0]['status']) && $result_array['data'][0]['status'] == "error") || (isset($result_array['status']) && $result_array['status'] == "error")) {
                //log error to file
                file_put_contents(dirname(__FILE__) . '/errorsLog.txt', date('Y-m-d H:i:s') . "Error $module_name: " . $result . ' | ' . json_encode($module_data) . "\n", FILE_APPEND);
                
            } else {
        
                return !empty($field_name) ? $this->getByField($result_array, 'create', $field_name) : $result_array;
            }
        }
            
        return null;
    }
    
    
    /*
     * Get record
     */
    public function getRecord($module_name, $id, $field_name = '')
    {
        $url = "https://www.zohoapis.com/crm/v2/" . $module_name . "/" . $id;
        //make request
        $result = $this->getDataFromCrm($url, array(), "GET");
        
        if (isset($result)) {
            $result_array = json_decode($result, true);
            
            if (isset($result_array['status']) && $result_array['status'] == "error") {
                //log error to file
                file_put_contents(dirname(__FILE__) . '/errorsLog.txt', date('Y-m-d H:i:s') . "Error $module_name: " . $result . "\n", FILE_APPEND);
            } else {
                return !empty($field_name) ? $this->getByField($result_array, 'get', $field_name) : $result_array;
            }
        }
        
        return null;
    }
    
    
    /*
     * Update record
     */
    public function updateRecord($module_name, $id, $module_data, $field_name = '', $trigger = '')
    {
        $url = "https://www.zohoapis.com/crm/v2/" . $module_name . "/" . $id;
        
        $data = array(
            "data" => array(
                $module_data
            ),
            "trigger" => explode(", ", $trigger)
        );

        //make request
        $result = $this->getDataFromCrm($url, json_encode($data), "PUT");
        
        if (isset($result)) {
            $result_array = json_decode($result, true);
            
            if ((isset($result_array['data'][0]['status']) && $result_array['data'][0]['status'] == "error") || (isset($result_array['status']) && $result_array['status'] == "error")) {
                //log error to file
                file_put_contents(dirname(__FILE__) . '/errorsLog.txt', date('Y-m-d H:i:s') . "Error $module_name: " . $result . ' | ' . json_encode($module_data) . "\n", FILE_APPEND);
            } else {
                return !empty($field_name) ? $this->getByField($result_array, 'update', $field_name) : $result_array;
            }
        }
        
        return null;
    }
    
    
    /*
     * Get value by field name or full array
     */
    private function getByField($data = array(), $operation = '', $field_name = '')
    {        
        if ($operation == 'search') {
            
            return isset($data['data'][0][$field_name]) ? $data['data'][0][$field_name] : '';
               
        } else {
            
            return isset($data['data'][0]['details'][$field_name]) ? $data['data'][0]['details'][$field_name] : '';
        }
    }
    
}