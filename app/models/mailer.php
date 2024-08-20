<?php

require (__DIR__ . '/../services/PHPMailer/src/Exception.php');
require (__DIR__ . '/../services/PHPMailer/src/PHPMailer.php');
require (__DIR__ . '/../services/PHPMailer/src/SMTP.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class Mailer{

    public function send($to, $subject, $message){
        
        $mail = new PHPMailer(true);
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'expresssale.exsl@gmail.com';
        $mail->Password = 'lovr doed whuz zmhq';
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        $mail->setFrom('expresssale.exsl@gmail.com', 'Express Sale');
        $mail->addAddress($to);
        $mail->Subject = $subject;
        $mail->isHTML(true); 
        $mail->Body = $message;
        $mail->CharSet = 'UTF-8';

        try {
            $mail->send();            
            return ['success' => true, 'message' => 'Correo enviado correctamente.'];
        } catch (Exception $e) {
            return ['success'=> false,'message'=> 'Error al enviar la información.'];
        }
    } 
}   
    