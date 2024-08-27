<?php

class CalificationController extends Controller
{

    public function __construct(PDO $conn)
    {
        parent::__construct($conn);
    }

    public function rate()
    {
        $data = [
            'calificacion_comentario' => $_POST['calificacion_comentario'],
            'calificacion' => $_POST['calificacion'],
            'usuario_id' => $_POST['usuario_id'],
        ];

        $result = $this->calificationModel->insert($data);

        if ($result['success']) {
            $id = $result['last_id'];

            if ($_FILES['calificacion_imagen']['size'] > 0) {
                $data['calificacion_imagen_url'] = '/public/images/califications/' . $id . '.jpg';

                move_uploaded_file($_FILES['calificacion_imagen']['tmp_name'], $_SERVER['DOCUMENT_ROOT'] . $data['calificacion_imagen_url']);

                $this->calificationModel->updateById($id, $data);
            }

            if ($_POST['tipo_objeto'] == 'producto') {

                $final_result = $this->calificationModel->insertCalification([
                    'calificacion_id' => $id,
                    'producto_id' => $_POST['producto_id']
                ], "calificaciones_productos");
            } else {

                $final_result = $this->calificationModel->insertCalification([
                    'calificacion_id' => $id,
                    'usuario_id' => $_POST['vendedor_id']
                ], "calificaciones_usuarios");
            }

            echo json_encode($final_result);
        } else {
            echo json_encode($result);
        }
    }

    public function update()
    {
        $data = [
            'calificacion_comentario' => $_POST['calificacion_comentario'],
            'calificacion' => $_POST['calificacion'],
        ];

        if ($_FILES['calificacion_imagen']['size'] > 0) {
            $data['calificacion_imagen_url'] = '/public/images/califications/' . $_POST['calificacion_id'] . '.jpg';

            move_uploaded_file($_FILES['calificacion_imagen']['tmp_name'], $_SERVER['DOCUMENT_ROOT'] . $data['calificacion_imagen_url']);
        }

        $result = $this->calificationModel->updateById($_POST['calificacion_id'], $data);

        echo json_encode($result);
    }

    public function delete()
    {
        $result = $this->calificationModel->deleteById($_POST['calificacion_id']);

        echo json_encode($result);
    }
}
