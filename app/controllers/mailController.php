<?php

class mailController extends Controller
{
    public function __construct(PDO $conn)
    {
        parent::__construct($conn);
    }

    public function contact_form()
    {

        // Preparar mensaje
        $message = "Autor: { " . (isset($_SESSION['usuario_id']) ? 
        "\n    ID: " . $_SESSION['usuario_id'] . ", \n    Perfil: " . DOMAIN . "/page/profile/?id=" . $_SESSION['usuario_id'] . " \n}": 
        "Autor desconocido }");

        $message .= "\n\nFORMULARIO DE ENVIO:";
        $message .= "\nNombre: " . $_POST['usuario_nombre'] . " " . $_POST['usuario_apellido'] . ",";
        $message .= "\nCorreo: " . $_POST['usuario_correo'];
        $message .= "\n\nMensaje:";
        $message .= "\n" . $_POST['correo_mensaje'];

        // Enviar correo
        $result = $this->mailerModel->send(
            "expresssale.exsl@gmail.com", // to
            $_POST["correo_asunto"] . " Formulario de contacto Express Sale", // subject
            $message, // message
            false // isHTML
        );

        echo json_encode($result);
    }

    public function recover_account()
    {
        $sql = "SELECT * FROM usuarios WHERE usuario_correo = :email";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':email', $_POST['usuario_correo']);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (count($user) > 0) {

            $token = bin2hex(random_bytes(16)); // Genera un token aleatorio
            $sql = "INSERT INTO recuperacion_cuentas ( usuario_id, token, email ) VALUES ( :id, :token, :email )";

            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(':id', $user['usuario_id']);
            $stmt->bindValue(':token', $token);
            $stmt->bindValue(':email', $user['usuario_correo']);

            $stmt->execute();

            $to = $_POST['usuario_correo'];
            $subject = "Recupera tu cuenta | Express Sale";

            $recover_link = DOMAIN . "/page/reset_password/?token=$token";

            ob_start();
            include(__DIR__ . '/../views/mail/recover_account.mail.php');
            $message = ob_get_clean();

            $result = $this->mailerModel->send($to, $subject, $message);

            echo json_encode($result);
        } else {
            echo json_encode(['success' => false, 'message' => 'Hubo un problema al encontrar ese usuario.']);
        }
    }
}
