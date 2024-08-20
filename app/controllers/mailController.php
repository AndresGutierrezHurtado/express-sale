<?php

class mailController {  
    private $mailModel;  
    private $userModel;
    protected $conn;

    public function __construct(mysqli $conn) {
        $this -> mailModel = new Mailer();
        $this -> userModel = new User($conn);
        $this -> conn = $conn;
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

            $token = bin2hex(random_bytes(16)); // Genera un token aleatorio
            $query = "INSERT INTO recuperacion_cuentas ( usuario_id, token, email ) VALUES
            (" . $user[0]['usuario_id'] . ", '$token', '" . $email . "');";

            $this -> conn -> query($query);

            $to = $email;
            $subject = "Recupera tu cuenta | Express Sale";
            
            $recover_link = DOMAIN . "/page/reset_password/?token=$token";

            ob_start();
            include (__DIR__ . '/../views/mail/recover_account.mail.php');
            $message = ob_get_clean();

            $result = $this -> mailModel -> send($to, $subject, $message);

            echo json_encode($result);
        } else {
            echo json_encode(['success' => false, 'message' => 'Hubo un problema al encontrar ese usuario.']);
        }
        
    }
}