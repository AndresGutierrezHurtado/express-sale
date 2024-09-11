<?php

class UserController extends Controller
{

    public function __construct(PDO $conn)
    {
        parent::__construct($conn);
    }

    public function index()
    {
        $user = $this->userModel->getAll();
    }

    public function login()
    {
        echo json_encode($this->userModel->auth($_POST));
    }

    public function google_login()
    {

        $client_id = CLIENT_ID;
        $client_secret = CLIENT_SECRET;
        $redirect_uri = REDIRECT_URL;

        if (isset($_GET['code'])) {
            $code = $_GET['code'];

            // Obtener el token de acceso
            $token_url = 'https://accounts.google.com/o/oauth2/token';
            $token_data = [
                'code' => $code,
                'client_id' => $client_id,
                'client_secret' => $client_secret,
                'redirect_uri' => $redirect_uri,
                'grant_type' => 'authorization_code',
            ];

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $token_url);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($token_data));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $response = curl_exec($ch);
            curl_close($ch);

            $token = json_decode($response, true);
            $access_token = $token['access_token'];

            // Obtener información del usuario
            $user_info_url = 'https://www.googleapis.com/oauth2/v1/userinfo?access_token=' . $access_token;
            $user_info = file_get_contents($user_info_url);
            $user = json_decode($user_info, true);

            $result = $this->userModel->auth_google($user);

            if ($result['success']) {
                echo "
                <script>
                    alert('¡La autenticación se realizó correctamente!');
                    window.location.href = '/';
                </script>
                ";
                header("Location: /");
            }
        } else {
            echo "Error: No se recibió ningún código de autorización.";
        }
    }

    public function register()
    {
        $_POST['usuario_contra'] = md5($_POST['usuario_contra']);

        $result = $this->userModel->insert($_POST);

        echo json_encode($result);
    }

    public function update()
    {
        $id = $_POST['usuario_id'];
        unset($_POST['usuario_id']);

        if (isset($_POST['usuario_direccion']) && isset($_POST['usuario_telefono'])) {
            $_POST['usuario_direccion'] = $_POST['usuario_direccion'] == "" ? null : $_POST['usuario_direccion'];
            $_POST['usuario_telefono'] = $_POST['usuario_telefono'] == "" || $_POST['usuario_telefono'] == "0" ? null : $_POST['usuario_telefono'];
        } else if (isset($_POST['trabajador_numero_trabajos'])) {
            $_SESSION['usuario_informacion'] = ['estado' => 'libre', 'pedido_id' => null];
        }

        // Verificar si se ha enviado una imagen
        if (!empty($_FILES['usuario_imagen']['name'])) {
            $_POST['usuario_imagen_url'] = '/public/images/users/' . $id . '.jpg';

            move_uploaded_file($_FILES['usuario_imagen']['tmp_name'], $_SERVER['DOCUMENT_ROOT'] . $_POST['usuario_imagen_url']);
        }

        $result = $this->userModel->updateById($id, $_POST, "LEFT JOIN trabajadores ON usuarios.usuario_id = trabajadores.usuario_id");

        echo json_encode($result);
    }

    public function reset_password()
    {
        $sql = "UPDATE recuperacion_cuentas SET fecha_expiracion = CURRENT_TIMESTAMP";

        $stmt = $this->conn->prepare($sql);

        if ($stmt->execute()) {

            $result = $this->userModel->updateById($_POST['usuario_id'], ['usuario_contra' => md5($_POST['usuario_contra'])]);

            echo json_encode($result);
        }
    }

    public function delete()
    {
        $result = $this->userModel->deleteById($_POST['usuario_id']);
        if ($_POST['usuario_id'] == $_SESSION['usuario_id'] && $result['success']) {
            session_destroy();
        }
        echo json_encode($result);
    }

    public function withdraw()
    {
        echo json_encode($this->withdrawModel->insert($_POST));
    }

    public function logout()
    {
        session_destroy();
        echo json_encode(['success' => true, 'message' => 'Sesión cerrada.']);
    }
}
