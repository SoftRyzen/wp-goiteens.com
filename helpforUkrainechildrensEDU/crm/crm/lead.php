<?php
$token = 'DNBC-3VgDWLIIrpyBab0l9bISr0C-0VO';
$inputJSON = file_get_contents('php://input');
$input = json_decode($inputJSON, true);
logRequest($input);
echo send($token, ['Lead' => $input]);


function send($token, $data)
{
    $ch = curl_init();
    $curl_options = [];
    $url = 'https://crm.goit.ua/api/v1/lead/create';
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
    logResponse($msg, $log);
    return $body;

}

function logResponse($msg, $response)
{
    $file = fopen('response.log', 'a+');
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
    $file = fopen('request.log', 'a+');
    $date = date(DATE_RFC822);

    $string = [
        'date' => $date,
        'input' => $request,
    ];
    fwrite($file, json_encode($string, JSON_UNESCAPED_UNICODE) . ",");
    fclose($file);
}