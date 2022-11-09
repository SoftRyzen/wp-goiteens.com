<?php
$postdata = json_encode($_POST);


// урли для перенаправлення після оплати в в4п
$credentialsURL = array(
    "sucessURL" => "https://goiteens.com/course/python-start/python-start-thx-test/",        // перенаправлення після успішної оплати
    "errorURL" => "https://goiteens.com/course/python-start/python-start-thx-test/",        // перенаправлення після помилки оплати
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
