<?php
// Include PHPMailer files
require 'vendor/phpmailer/phpmailer/src/Exception.php';
require 'vendor/phpmailer/phpmailer/src/PHPMailer.php';
require 'vendor/phpmailer/phpmailer/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

function sendWelcomeEmail($email, $name) {
    $mail = new PHPMailer(true);

    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host = 'smtp.zoho.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'uemf.contact@zohomail.com';
        $mail->Password = 'x6CDfV^dl6pLg$8v';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->Port = 465;

        // Recipients
        $mail->setFrom('uemf.contact@zohomail.com', 'Ryhze Team');
        $mail->addAddress($email, $name);

        // Content
        $mail->isHTML(true);
        $mail->Subject = 'Welcome to Ryhze!';

        // Get email template
        ob_start();
        include 'email.php';
        $emailBody = ob_get_clean();
        
        $mail->Body = $emailBody;
        $mail->AltBody = strip_tags($emailBody);

        $mail->send();
        return true;
    } catch (Exception $e) {
        error_log("Message could not be sent. Mailer Error: {$mail->ErrorInfo}");
        return false;
    }
}

// Example usage:
// if ($_SERVER['REQUEST_METHOD'] === 'POST') {
//     $email = $_POST['email'];
//     $name = $_POST['name'];
//     if (sendWelcomeEmail($email, $name)) {
//         echo "Email sent successfully!";
//     } else {
//         echo "Failed to send email.";
//     }
// }
?> 