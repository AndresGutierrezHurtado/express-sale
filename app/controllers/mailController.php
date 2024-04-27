<?php

require_once (__DIR__ . "/../models/mailer.php");

class mailController {  
    private $mailModel;  
    public function __construct() {
        $this -> mailModel = new Mailer();
    }

    public function footerForm (){
        $data = json_decode($_POST["data"], true);
        $to = "andres52885241@gmail.com";
        $subject = "Formulario de envío | ".$_POST['subject'];
        
        $message = "autor = [";
        $message .= "\nid: " . $data['id'] . ",";
        $message .= "\nusername: " . $data['username'] . ",";
        $message .= "\nemail: " . $data['email'] . "\n]";
        
        $message .= "\n\nFORMULARIO DE ENVIO:";
        $message .= "\nNombre: " . $_POST['fullNameFrom'] . ",";
        $message .= "\nCorreo: " . $_POST['emailFrom'];
        $message .= "\n\nMensaje:";
        $message .= "\n" . $_POST['message'];

        $result = $this -> mailModel -> send($to, $subject, $message);

        echo json_encode($result);
    }
}