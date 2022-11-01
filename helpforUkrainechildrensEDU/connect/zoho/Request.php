<?php

class Request
{
    public $get    = array();
    public $post   = array();
    public $cookie = array();
    public $stream = array();
    
    
    public function __construct() {
        $this->get    = isset($_GET) ? $this->clean($_GET) : array();
        $this->post   = isset($_POST) ? $this->clean($_POST) : array();
        $this->cookie = isset($_COOKIE) ? $this->clean($_COOKIE) : array();
        $this->stream = json_decode(file_get_contents('php://input'), true);
    }
    
    
    public function cleanPhone($phone)
    {
        return preg_replace("/[^0-9]/", '', $phone);
    }
    
    
    public function clean($data) 
    {
        if ((is_array($data)) || (is_object($data))) {
            foreach ($data as $key => $value) {
                unset($data[$key]);
                $data[$this->clean($key)] = $this->clean($value);
            }
        } else {
            $data = trim(urldecode($data));
        }
        
        return $data;
    }
    
}