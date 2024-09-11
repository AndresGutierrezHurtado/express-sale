<?php

class ProductController extends Controller
{

    public function __construct(PDO $conn)
    {
        parent::__construct($conn);
    }

    public function index()
    {
        $products = $this->productModel->getAll();
    }

    public function create()
    {
        $data = [
            'producto_nombre' => $_POST['producto_nombre'],
            'producto_descripcion' => $_POST['producto_descripcion'],
            'producto_cantidad' => $_POST['producto_cantidad'],
            'producto_precio' => $_POST['producto_precio'],
            'producto_estado' => $_POST['producto_estado'],
            'usuario_id' => $_POST['usuario_id'],
            'categoria_id' => $_POST['categoria_id']
        ];

        $result = $this->productModel->insert($data);

        if (!empty($_FILES['producto_imagen']['name']) && $result['success']) {

            $_POST['producto_imagen_url'] = '/public/images/products/' . $result['last_id'] . '.jpg';

            move_uploaded_file($_FILES['producto_imagen']['tmp_name'], $_SERVER['DOCUMENT_ROOT'] . $_POST['producto_imagen_url']);

            $result = $this->productModel->updateById($result['last_id'], $_POST);
        }

        echo json_encode($result);
    }

    public function update()
    {
        if (!empty($_FILES['producto_imagen']['name'])) {
            $_POST['producto_imagen_url'] = '/public/images/products/' . $_POST['producto_id'] . '.jpg';

            // guardar imagen en los directorios
            move_uploaded_file($_FILES['producto_imagen']['tmp_name'], $_SERVER['DOCUMENT_ROOT'] . $_POST['producto_imagen_url']);
        }

        // Subir archivos multimedia
        if (!empty($_FILES['multimedia']['name'][0])) {
            foreach ($_FILES['multimedia']['tmp_name'] as $index => $tmpName) {
                if (! is_uploaded_file($tmpName)) echo json_encode(['success' => false, 'message' => 'Error al cargar el archivo multimedia.']);

                // determinar si es video o imagen
                $mimeType = mime_content_type($tmpName);
                $extension = (strpos($mimeType, 'image/') === 0) ? 'jpg' : 'mp4';

                $data_media = [
                    'multimedia_url' => '/public/images/products/media/' . $_POST['producto_id'] . '_' . $index . '.' . date('YmdHis') . '.' . $extension,
                    'multimedia_tipo' => (strpos($mimeType, 'image/') === 0) ? 'imagen' : 'video',
                    'producto_id' => $_POST['producto_id']
                ];

                if (move_uploaded_file($tmpName, $_SERVER['DOCUMENT_ROOT'] . $data_media['multimedia_url'])) {
                    $result = $this->multimediaModel->insert($data_media);

                    if (!$result['success']) {
                        echo json_encode($result);
                    }
                } else {
                    // Manejar el error si el archivo no se pudo mover
                    echo json_encode(['success' => false, 'message' => 'Error al mover el archivo multimedia.']);
                }
            }
        }

        $result = $this->productModel->updateById($_POST['producto_id'], $_POST);
        echo json_encode($result);
    }

    public function delete()
    {
        echo json_encode($this->productModel->deleteById($_POST['producto_id']));
    }

    public function deleteMultimedia()
    {
        $post_data = file_get_contents('php://input');
        $post_data = json_decode($post_data, true);

        $media = $this->multimediaModel->getById($post_data['id']);

        if ($media) {
            $filePath = $_SERVER['DOCUMENT_ROOT'] . $media['multimedia_url'];

            if (file_exists($filePath)) {
                unlink($filePath);
            }

            $result = $this->multimediaModel->deleteById($post_data['id']);
            echo json_encode($result);
        } else {
            // Manejar el caso donde el multimedia no se encontró
            echo json_encode(['success' => false, 'message' => 'El archivo multimedia no se encontró.']);
        }
    }
}
