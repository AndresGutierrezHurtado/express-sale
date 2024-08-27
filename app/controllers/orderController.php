<?php

class orderController extends Controller
{

    public function __construct(PDO $conn)
    {
        parent::__construct($conn);
    }

    public function response()
    {

        $data['order'] = [
            'usuario_id' => $_SESSION['usuario_id'],
        ];

        $resultado_pedido = $this->orderModel->insert($data['order']);

        if ($resultado_pedido['success']) {

            $data['payment_details'] = [
                // Variables de PAYU
                'pedido_id' => $resultado_pedido['last_id'],
                'pago_metodo' => $_GET['polPaymentMethodType'],
                'pago_valor' => $_GET['TX_VALUE'],
                'comprador_correo' => $_GET['buyerEmail'],

                // Variables guardadas en el formulario
                'comprador_nombre' => $_SESSION['payment_data']['buyerFullName'],
                'comprador_tipo_documento' => $_SESSION['payment_data']['payerDocumentType'],
                'comprador_numero_documento' => $_SESSION['payment_data']['payerDocument'],
                'comprador_telefono' => $_SESSION['payment_data']['payerPhone']
            ];

            $result_payment = $this->paymentDetailsModel->insert($data['payment_details']);


            $products = $this->cartModel->getAll();
            $data['sold_products'] = [];
            foreach ($products as $product) {
                $data['sold_products'][] = ['pedido_id' => $resultado_pedido['last_id'], 'producto_id' => $product['producto_id'], 'producto_precio' => $product['producto_precio'], 'producto_cantidad' => $product['producto_cantidad']];
            }

            foreach ($data['sold_products'] as $soldProduct) {
                $result_sold_products = $this->soldProductModel->insert($soldProduct);

                if ($result_sold_products['success']) {

                    $producto_temp = $this->productModel->getById(
                        $soldProduct['producto_id'],
                        "productos.*, trabajadores.* ",
                        "INNER JOIN trabajadores ON productos.usuario_id = trabajadores.usuario_id"
                    );

                    $resultado_trabajador = $this->productModel->updateById(
                        $producto_temp['producto_id'],
                        [
                            'trabajador_numero_trabajos' => $producto_temp['trabajador_numero_trabajos'] + $soldProduct['producto_cantidad'],
                            'producto_cantidad' => $producto_temp['producto_cantidad'] - $soldProduct['producto_cantidad'],
                            'trabajador_saldo' => $producto_temp['trabajador_saldo'] + $soldProduct['producto_precio'] * $soldProduct['producto_cantidad']
                        ],
                        "INNER JOIN trabajadores ON productos.usuario_id = trabajadores.usuario_id "
                    );
                }
            }

            $data['shipping_details'] = [
                'pedido_id' => $resultado_pedido['last_id'],
                'envio_direccion' => $_SESSION['payment_data']['shippingAddress'],
                'envio_coordenadas' => $_SESSION['payment_data']['order_coords'],
                'envio_valor' => 7000,
                'envio_mensaje' => $_SESSION['payment_data']['order_message']
            ];

            $result_shipping = $this->shippingDetailsModel->insert($data['shipping_details']);
        }

        if ($resultado_pedido['success'] && $result_payment['success'] && $result_sold_products['success'] && $result_shipping['success'] && $resultado_trabajador['success']) {
            $this->cartModel->empty();
            $_SESSION['payment_data'] = null;
            echo ' <script>
            alert("Transacción realizada correctamente");
            window.location = "/page/profile";
            </script> ';
        } else {
            echo ' <script>
            alert("Hubo un error.");
            </script> ';
        }
    }

    public function store_session_data()
    {
        $_SESSION['payment_data'] = $_POST;

        echo json_encode(['success' => true, 'message' => 'La información fue guardada.']);
    }

    public function update()
    {
        $id = $_POST['pedido_id'];
        $data = $_POST;
        // eliminar pedido_id de la información
        unset($data['pedido_id']);
        
        $data['fecha_entrega'] = date('Y-m-d H:i:s');

        $result = $this->orderModel->updateById(
            $_POST['pedido_id'],
            $data,
            "INNER JOIN detalles_envios ON pedidos.pedido_id = detalles_envios.pedido_id
            LEFT JOIN trabajadores ON detalles_envios.trabajador_id = trabajadores.trabajador_id"
        );

        echo json_encode($result);
    }
}
