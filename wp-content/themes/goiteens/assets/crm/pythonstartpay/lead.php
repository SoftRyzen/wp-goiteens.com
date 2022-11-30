<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
header('Access-Control-Allow-Origin: *');
header("Content-type: application/json; charset=utf-8");


$token = 'DNBC-3VgDWLIIrpyBab0l9bISr0C-0VO';
$additionalParameters = array(  // правити для кожного окремого ленда!
    "productID" => 1819773000180826760,                                        // айді продукту з зохо
    "productName" => "GoITeens_UA_PythonStart_1",                            // назва продукту
    "fopID" => 1819773000102087784,                                            // айді фопа з зохо
    "returnURL" =>  get_template_directory_uri() . "/assets/crm/pythonstartpay/return_url.php",        // перевірка статусу оплати
    "productPrice" => 299,                                                     // ціна продукту
    "productCurrency" => "UAH",                                                // валюта продукту
    "promoKey" => "",                                                          // промокод
    "promoDiscount" => 0                                                       // знижка по промокоду (ціна мінус знижка формує ціну! не оце поле!)
);


/*
 *  відсилає дані в x-www-form-urlencoded, тому витягую з $_POST дані
 *  на всякий зберегти
 *
 *
        $inputJSON = file_get_contents('php://input');
        $inputPost = json_decode($inputJSON, true);
*/

$inputPost = $_POST;
$input = createOutputArray($inputPost, $additionalParameters);

/*      формується масив

{
    "first_name": "ihor TEST",
    "phone": "+380930008429",
    "email": "i.fostiak@goit.ua",
    "correct_whois": "kid",
    "utm_source": "",
    "utm_medium": "",
    "utm_term": "",
    "utm_campaign": "",
    "utm_content": "",
    "land": "python",
    "pdf_lang": "ru",
    "correct_course": "uaminijs",
    "city": "",
    "ip": "109.251.24.253",
    "productID": 1819773000312352055,
    "productName": "GoITeens_UA_AutoFE_wishbord",
    "fopID": 1819773000064300183,
    "returnURL":  get_template_directory_uri() . "/assets/crm/autofewishbord/lead.php",
    "productPrice": 399,
    "productCurrency": "UAH",
    "promoKey": "",
    "promoDiscount": 0,
    "promo": ""
}

*/

//file_put_contents('save.txt',json_encode($input));
echo send($token, ['Lead' => $input], $input);


function send($token, $data, $input)
{
    $ch = curl_init();
    $curl_options = [];
    $url = "https://w4ppaymnew.goiteens.ua/loader.php";
    $curl_options[CURLOPT_URL] = $url;
    $curl_options[CURLOPT_RETURNTRANSFER] = true;
    $curl_options[CURLOPT_HEADER] = 0;
    $curl_options[CURLOPT_CUSTOMREQUEST] = "POST";
    $curl_options[CURLOPT_POSTFIELDS] = json_encode($data);
    $headersArray = [];
    $headersArray[] = "Authorization" . ":" . "Bearer " . $token;
    $headersArray[] = "Content-Type: application/json";
    $curl_options[CURLOPT_HTTPHEADER] = $headersArray;

    curl_setopt_array($ch, $curl_options);
    $response = curl_exec($ch);
    echo $response;
    curl_close($ch);
}

function createOutputArray($postArray, $additionalParametersArray)
{
    foreach ($additionalParametersArray as $key => $value) {
        $postArray[$key] = $value;
    }
    return $postArray;
}
