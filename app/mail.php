<?php
// Include PHPMailer classes
use PHPMailer\PHPMailer\PHPMailer;

// Load PHPMailer through Composer's autoload
require 'vendor/autoload.php';

// Looking to send emails in production? Check out our Email API/SMTP product!
$phpmailer = new PHPMailer();
$phpmailer->isSMTP();
$phpmailer->Host = 'sandbox.smtp.mailtrap.io';
$phpmailer->SMTPAuth = true;
$phpmailer->Port = 2525;
$phpmailer->Username = '296458e6d762df';
$phpmailer->Password = '53399a46203004';
