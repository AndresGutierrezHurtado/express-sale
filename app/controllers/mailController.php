<?php

class mailController {  
    private $mailModel;  
    private $userModel;
    public function __construct(mysqli $conn) {
        $this -> mailModel = new Mailer();
        $this ->userModel = new User($conn);
    }

    public function footerForm (){
        $data = json_decode($_POST["data"], true);
        $to = "expresssale.exsl@gmail.com";
        $subject = "Formulario de envío | ".$_POST['subject'];
        
        $message = "autor = [";
        $message .= "\nid: " . $data['id'] . ",";
        $message .= "\nusername: " . $data['username'] . ",";
        $message .= "\nemail: " . $data['email'] . "\n]";
        
        $message .= "\n\nFORMULARIO DE ENVIO:";
        $message .= "\nNombre: " . $_POST['firstNameFrom'] . " " . $_POST['lastNameFrom'] . ",";
        $message .= "\nCorreo: " . $_POST['emailFrom'];
        $message .= "\n\nMensaje:";
        $message .= "\n" . $_POST['message'];

        $result = $this -> mailModel -> send($to, $subject, $message);

        echo json_encode($result);
    }

    public function recover_account() {
        $email = $_POST['usuario_correo'] ;
        $user = $this -> userModel -> getAll("*", "", "WHERE usuario_correo = '$email'");
        if (count($user) > 0) {
            $to = $email;
            $subject = "Recupera tu cuenta | Express Sale";
            
            $message = "Recupera tu cuenta\n";
            $message .= "Correo: ".$user[0]['usuario_correo']." \n";
            $message .= "Contraseña: ".$user[0]['usuario_contraseña']." \n";

            $result = $this -> mailModel -> send($to, $subject, $message);

            echo json_encode($result);
        } else {
            echo json_encode(['success' => false, 'message' => 'Hubo un problema al encontrar ese usuario.']);
        }
        
    }
}