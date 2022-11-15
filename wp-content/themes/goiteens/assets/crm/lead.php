<?php
require_once "Esputnik.php";
$token = 'DNBC-3VgDWLIIrpyBab0l9bISr0C-0VO';
$inputJSON = file_get_contents('php://input');
$input = json_decode($inputJSON, true);
logRequest($input);
echo send($token, ['Lead' => $input], $input);
$esputnik = new Esputnik($input);


function send($token, $data, $input)
{
	$connID=substr((string)$input['product_id'],0,4);
	if ($connID=="1819"){
		    $url = 'https://universalcrmconnector.goiteens.ua/connector.php';
	} else if ($connID=="4525"){
			$url = 'https://goit-connectors.place/pl/newcrm/goiteens/connectorPL.php';
	} else {
			$url = 'https://universalcrmconnector.goiteens.ua/connector.php';
	}

    $ch = curl_init();
    $curl_options = [];

    $curl_options[CURLOPT_URL] = $url;
    $curl_options[CURLOPT_RETURNTRANSFER] = true;
    $curl_options[CURLOPT_HEADER] = 1;
    $curl_options[CURLOPT_CUSTOMREQUEST] = "POST";
    $curl_options[CURLOPT_POSTFIELDS] = json_encode($data);
    $headersArray = [];
    $headersArray[] = "Authorization" . ":" . "Bearer " . $token;
    $headersArray[] = "Content-Type: application/json";
    $curl_options[CURLOPT_HTTPHEADER] = $headersArray;

    curl_setopt_array($ch, $curl_options);
    $response = curl_exec($ch);
    $header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
    $header = substr($response, 0, $header_size);
    $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $body = substr($response, $header_size);

    $log = [
        'input' => $data,
        'response' => json_decode($body)
    ];
    if ($httpcode !== 200) {
        $msg = 'Error in progress at {date}';
    } else {
        $msg = 'Success send status';
    }
    logResponse($msg, $log, $input);

    sendSalesDoubler($data);

    return $body;
}

function logResponse($msg, $response, $input)
{
    $file = fopen("$input[product_name]_response.log", 'a+');
    $date = date(DATE_RFC822);

    $string = [
        'message' => str_replace('{date}', $date, $msg),
        'data' => $response,
    ];
    fwrite($file, json_encode($string, JSON_UNESCAPED_UNICODE) . ",");
    fclose($file);
}

function logRequest($request)
{
    $file = fopen("$request[product_name].log", 'a+');
    $date = date(DATE_RFC822);

    $string = [
        'date' => $date,
        'input' => $request,
    ];
    fwrite($file, json_encode($string, JSON_UNESCAPED_UNICODE) . ",");
    fclose($file);
}

function logFile($data, $file)
{
    $file = fopen("$file.log", 'a+');
    $date = date(DATE_RFC822);

    $string = [
        'date' => $date,
        'input' => $data,
    ];
    fwrite($file, json_encode($string, JSON_UNESCAPED_UNICODE) . ",");
    fclose($file);
}

function sendSalesDoubler($data)
{
    if (!isset($_COOKIE['sd_user'])) {
        return;
    }

    $click_id = $_COOKIE['sd_user'];

    if (isset($data['Lead']['google_id'])) {
        $google_id = $data['Lead']['google_id'];
    } else {
        $google_id = '';
    }

    $data = [
        'trans_id' => $google_id,
        'token' => 'YS5taWtoQGdvaXRlZW5zLnVh'
    ];


    if ($_COOKIE['utm_medium'] === 'salesdoubler') {
        $response = file_get_contents("https://rdr.fmcgsd.net/in/postback/4770/{$click_id}?" . http_build_query($data));
        logFile($response, 'SalesDoubler');

        setcookie('sd_user', null, -1, '/');
    }
    return '';
}
