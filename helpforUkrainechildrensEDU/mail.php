<?php
if ($_POST) { 
	$name = htmlspecialchars($_POST["name"]); 
	$phone = htmlspecialchars($_POST["email-or-phone"]);
	$message = htmlspecialchars($_POST["message"]);
	$subject = "Subject";
	$body = "\n\n Name: $name \n\n Contact info: $phone \n\n Message: $message";
	$json = array(); 


	function mime_header_encode($str, $data_charset, $send_charset) { 
		if($data_charset != $send_charset)
		$str=iconv($data_charset,$send_charset.'//IGNORE',$str);
		return ('=?'.$send_charset.'?B?'.base64_encode($str).'?=');
	}

	class TEmail {
	public $from_email;
	public $from_name;
	public $to_email;
	public $subject='text/plain';
	public $data_charset='UTF-8';
	public $send_charset='windows-1251';
	public $body='';
	public $type='text/plain';

	function send(){
		$dc=$this->data_charset;
		$sc=$this->send_charset;
		$enc_to=mime_header_encode($this->to_name,$dc,$sc).' <'.$this->to_email.'>';
		$enc_subject=mime_header_encode($this->subject,$dc,$sc);
		$enc_from=mime_header_encode($this->from_name,$dc,$sc).' <'.$this->from_email.'>';
		$enc_body=$dc==$sc?$this->body:iconv($dc,$sc.'//IGNORE',$this->body);
		$headers='';
		$headers.="Mime-Version: 1.0\r\n";
		$headers.="Content-type: ".$this->type."; charset=".$sc."\r\n";
		$headers.="From: ".$enc_from."\r\n";
		return mail($enc_to,$enc_subject,$enc_body,$headers);
	}

	}

	$emailgo= new TEmail; 
	$emailgo->from_email= $phone;
	$emailgo->from_name= $name;
	
	$emailgo->to_email= 'email@gmail.com';
	$emailgo->subject= $subject;
	$emailgo->body= $body; 
	$emailgo->send(); 

	$json['error'] = 0; 

	echo json_encode($json); 
} else { 
	echo 'GET LOST!'; 
}
?>