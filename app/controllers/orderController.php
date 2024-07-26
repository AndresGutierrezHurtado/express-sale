<?php

class orderController {

    private $orderModel;
    private $soldProductModel;
    private $cartModel;
    private $paymentDetailsModel;
    private $shippingDetailsModel;
    protected $conn;

    public function __construct(mysqli $conn) {
        $this -> orderModel = new Order($conn);
        $this -> soldProductModel = new SoldProduct($conn);
        $this -> paymentDetailsModel = new PaymentDetails($conn);
        $this -> shippingDetailsModel = new ShippingDetails($conn);
        $this -> cartModel = new Cart($conn);
        $this -> conn = $conn;
    }

    public function response() {

        $data['order'] = [
            'usuario_id' => $_SESSION['usuario_id'],
        ];

        $resultado_pedido = $this -> orderModel -> insert($data['order']);

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

            $result_payment = $this -> paymentDetailsModel -> insert($data['payment_details']);


            $products = $this -> cartModel -> getAll();
            $data['sold_products'] = [];
            foreach ($products as $product) {
                $data['sold_products'][] = ['pedido_id' => $resultado_pedido['last_id'], 'producto_id' => $product['producto_id'], 'producto_precio' => $product['producto_precio'], 'producto_cantidad' => $product['producto_cantidad']];
            }

            foreach ($data['sold_products'] as $soldProduct) {
                $result_sold_products = $this -> soldProductModel -> insert($soldProduct);
            }

            $data['shipping_details'] = [
                'pedido_id' => $resultado_pedido['last_id'],
                'envio_direccion' => $_SESSION['payment_data']['shippingAddress'],
                'envio_coordenadas' => $_SESSION['payment_data']['order_coords']
            ];

            $result_shipping = $this -> shippingDetailsModel -> insert($data['shipping_details']);

        }

        if ($resultado_pedido['success'] && $result_payment['success'] && $result_sold_products['success'] && $result_shipping['success'] ) {
            echo ' <script>
            alert("Transacción realizada correctamente");
            window.location = "/page/profile";
            </script> ';
        } else {
            echo ' <script>
            alert("Hubo un error.");
            window.location = "/page/profile";
            </script> ';
        }
    }

    public function store_session_data(){
        $_SESSION['payment_data'] = $_POST;

        echo json_encode(['success' => true, 'message' => 'La información fue guardada.']);
    }

    public function update () {
        $data = $_POST;

        $result = $this -> orderModel -> updateById($data['pedido_id'], $data);
        
        echo json_encode($result);
    }

}

