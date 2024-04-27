<?php

require_once (__DIR__ . "/../models/mailer.php");
require_once (__DIR__ . "/../models/user.php");

class mailController {  
    private $mailModel;  
    private $userModel;
    public function __construct(mysqli $conn) {
        $this -> mailModel = new Mailer();
        $this ->userModel = new User($conn);
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

    public function recover_account() {
        $email = $_POST['email'] ;
        $user = $this -> userModel -> paginate(1, 1, "WHERE email = '$email'", "WHERE email = '$email'");
        if ($user['rows'] > 0) {
            $to = $email;
            $subject = "Recupera tu cuenta | Express Sale";
            
            $message = "Recupera tu cuenta\n";
            $message .= "Correo: ".$user['data'][0]['email']." \n";
            $message .= "Contraseña: ".$user['data'][0]['password']." \n";

            $result = $this -> mailModel -> send($to, $subject, $message);

            echo json_encode($result);
        } else {
            echo json_encode(['success' => false, 'message' => 'Hubo un problema al encontrar ese usuario.']);
        }
        
    }
}