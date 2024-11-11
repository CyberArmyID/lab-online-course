<?php
// Include PHPMailer classes
use PHPMailer\PHPMailer\PHPMailer;

// Load PHPMailer through Composer's autoload
require '../vendor/autoload.php';

// Looking to send emails in production? Check out our Email API/SMTP product!
$mail = new PHPMailer();
$mail->isSMTP();
$mail->Host = 'sandbox.smtp.mailtrap.io';
$mail->SMTPAuth = true;
$mail->Port = 2525;
$mail->Username = '743b89e006c18b';
$mail->Password = '44705eb6c39c92';

// Email sender and recipient settings
$mail->setFrom('info@belajaronline.com', 'Belajar online');
