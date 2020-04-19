<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require './PHPMailer-master/vendor/autoload.php';
// require 'vendor/autoload.php';

error_reporting(E_ALL & ~E_NOTICE);

$x = PHPMailer::ENCRYPTION_STARTTLS;
var_dump($x);

function configureMailerSMTPSettings($mailer) {
    $mailer->IsSMTP();
    $mailer->SMTPAuth='true';
    $mailer->SMTPSecure =  PHPMailer::ENCRYPTION_STARTTLS;
    $mailer->Host = 'smtp.gmail.com';
    $mailer->Port = "587"; // 8025, 587 and 25 can also be used. Use Port 465 for SSL.
    $mailer->Username = "developmentequinox@gmail.com";
    $mailer->Password = "!adorabledog1";
}

function getMessageBody() {
    $emailTextHtml .= "<h3>New message from the w3newbie Theme:</h3><hr>";
    $emailTextHtml .= "<table>";
    $expectedFields = array('name' => 'Name:', 'email' => 'Email:', 'message' => 'Message:');
    foreach ($_POST as $key => $value) {
        if (isset($expectedFields[$key])) {
            $emailTextHtml .= "<tr><th>$expectedFields[$key]</th><td>$value</td></tr>";
        }
    }
    $emailTextHtml .= "</table><hr>";
    $emailTextHtml .= "<p>Have a great day!<br><br>Sincerely,<br><br>w3newbie Theme</p>";
    return $emailTextHtml;
}

function setEmailContent($mailer) {
    if (count($_POST) == 0) throw new \Exception('Form is empty');
    $mailer->AddAddress("developmentequinox@gmail.com");
    $mailer->From = $_POST['email'];
    $mailer->FromName = $_POST['name'];
    $mailer->AddReplyTo($_POST['email'], $_POST['name']);
    $mailer->Subject = 'New message from contact form';
    $mailer->Body = getMessageBody();
    $mailer->isHTML(true);
    //$mailer->msgHTML($emailTextHtml); // this will also create a plain-text version of the HTML email, very handy
}

function sendMessage() {
    try {
        if (!$mailer->send()) {
            throw new \Exception('Email send failed. ' . $mailer->ErrorInfo);
        }
    } catch (\Exception $e) {
        return $e->getMessage();
    }
    return null;    
}

$mailer = new PHPMailer(true);
configureMailerSMTPSettings($mailer);
setEmailContent($mailer);
$errorMessage = sendMessage($mailer);
echo($errorMessage ? $errorMessage : 'Message was successfully sent.');

?>