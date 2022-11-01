<?php
// Файлы phpmailer
require 'phpmailer/PHPMailer.php';
require 'phpmailer/Exception.php';

// Переменные, которые отправляет пользователь
$name = $_POST["name"];
$tel = $_POST["full_phone"];
$email = $_POST["email"];
$social = $_POST["social"];
$message = $_POST["message"];
$file_tmp  = $_FILES['file']['tmp_name'];
$file_name = $_FILES['file']['name'];
$from_name = $name;

// Формирование самого письма
$title = "Project Manager GoITeens Poland";
$body = "\n\n Name: $name \n\n Phone: $tel \n\n Email: $email \n\n Social: $social \n\n Message: $message";

switch (true) {
    case $name:
        break;
    case $tel:
        $from_name = $tel;
        break;
    case $email:
        $from_name = $email;
        break;
    default:
       $from_name = "User";
}


// Настройки PHPMailer
$mail = new PHPMailer\PHPMailer\PHPMailer();
$mail->CharSet = "UTF-8";
try {
    $mail->From = "pm-goiteens-pl-lp@goiteens.com";
    $mail->FromName = $from_name;
    // Получатель письма
    $mail->addAddress('hr@goit.global');

    // Прикрипление файла к письму
$mail->AddAttachment($file_tmp, $file_name);
// Отправка сообщения
$mail->isHTML(false);
$mail->Subject = $title;
$mail->Body = $body;

// Проверяем отравленность сообщения
if ($mail->send()) {$result = "success";}
else {$result = "error";}

} catch (Exception $e) {
    $result = "error";
    $status = "Повідомлення не було відправлено. Причина помилки: {$mail->ErrorInfo}";
}

// Отображение результата
echo json_encode(["result" => $result, "resultfile" => $rfile, "status" => $status]);