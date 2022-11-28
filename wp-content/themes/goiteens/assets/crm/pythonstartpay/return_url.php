<?php
$postdata = json_encode($_POST);


// урли для перенаправлення після оплати в в4п
$credentialsURL = array(
    "sucessURL" => site_url() . "/course/python-start/python-start-thx/",        // перенаправлення після успішної оплати
    "errorURL" => site_url() . "/course/python-start/python-start-thx/",        // перенаправлення після помилки оплати
);


if (!empty($postdata)) {
    if (checkanswer(json_decode($postdata, true))) {
        header('Location: ' . $credentialsURL['sucessURL']);
    } else {
        header('Location: ' . $credentialsURL['errorURL']);
    }
}


function checkanswer(array $post)
{
    if (array_key_exists('reasonCode', $post) && $post['reasonCode'] == '1100') {
        return true;
    } else {
        return false;
    }
}