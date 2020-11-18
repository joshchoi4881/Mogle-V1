<?php
    require "vendor/autoload.php";
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__, "../.env");
    $dotenv->load();
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
    require("PHPMailer-master/src/Exception.php");
    require("PHPMailer-master/src/PHPMailer.php");
    require("PHPMailer-master/src/SMTP.php");
    class Mail {
        public static function sendMail($subject, $body, $address) {
            $mail = new PHPMailer();
            $mail->isSMTP();
            $mail->SMTPAuth = true;
            $mail->IsHTML(true);
            $mail->SMTPSecure = "ssl";
            $mail->Host = "smtp.gmail.com";
            $mail->Port = "465";
            $mail->isHTML();
            $mail->Username = $_ENV["EMAIL_USERNAME"];
            $mail->Password = $_ENV["EMAIL_PASSWORD"];
            $mail->SetFrom("no-reply@mogleapp.com");
            $mail->Subject = $subject;
            $mail->Body = $body;
            $mail->AddAddress($address);
            $mail->Send();
        }
    }
?>