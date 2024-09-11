<?php

class cartController extends Controller
{

    public function __construct(PDO $conn)
    {
        parent::__construct($conn);
    }

    public function update()
    {
        echo json_encode($this->cartModel->add($_POST, $_POST['action'] ?? 'increase'));
    }

    public function delete()
    {
        echo json_encode($this->cartModel->remove($_POST['producto_id']));
    }

    public function empty()
    {
        echo json_encode($this->cartModel->empty());
    }
}
