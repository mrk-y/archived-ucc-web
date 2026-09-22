<?php


echo "hello";
use PHPMailer\PHPMailer\PHPMailer;

require "vendor/autoload.php";

$mail = new PHPMailer(true);

$mail->isSMTP();
$mail->Host = "smtp.gmail.com";
$mail->SMTPAuth = true;
$mail->Username = "smtpgmail.mailer@gmail.com";
$mail->Password = "ytzv uibr flbz hjiv";
$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
$mail->Port = 587;
$mail->setFrom("smtpgmail.mailer@gmail.com", "My Website");
$mail->addAddress("");
$mail->Subject = "Test mail";
$mail->Body = "Hello from my PHP application";
$mail->send();

