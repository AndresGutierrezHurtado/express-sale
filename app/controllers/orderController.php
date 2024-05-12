<?php

class orderController {

    private $orderModel;
    private $soldProductModel;
    private $receiptModel;
    private $cartModel;
    protected $conn;

    public function __construct(mysqli $conn) {
        $this->orderModel = new order($conn);
        $this -> soldProductModel = new soldProduct($conn);
        $this ->receiptModel = new receipt($conn);
        $this -> cartModel = new Cart();
        $this -> conn = $conn;
    }

    public function create() {
        $data = $_POST;
        $data['order_data'] = json_decode($data['order_data'], true);
        $data['order_iva'] = $data['order_amount'] * 0.19;
        $data['order_amount'] += $data['order_iva'] + 10000;
        $order_data = array(
            'order_date' => $data['order_date'],
            'order_iva' => $data['order_iva'],
            'order_amount' => $data['order_amount'],
            'order_first_name' => $data['order_first_name'],
            'order_last_name' => $data['order_last_name'],
            'order_email' => $data['order_email'],
            'order_phone_number' => $data['order_phone_number'],
            'order_address' => $data['order_address'],
            'order_coords' => $data['order_coords'],
            'order_user_id' => $data['order_user_id'],
        );

        $result = $this -> orderModel -> insert($order_data);
        
        if ($result['success']) {
            $order_id = $result['last_id'];
            $result2 = [];

            foreach ($data['order_data'] as $product) {
                $product_data = [
                    'sold_product_product_id' => $product['product_id'],
                    'sold_product_order_id' => $order_id,
                    'sold_product_quantity' => $product['product_quantity'],
                    'sold_product_price' => $product['product_price'],
                    'sold_product_address' => $product['product_address']
                ];                
                $result_order_data = $this-> soldProductModel -> insert($product_data);                
                array_push($result2, $result_order_data );
            }

            $receipt_data = [
                'receipt_date' => date('Y-m-d'),
                'receipt_time' => date('H:i:s'),
                'receipt_amount' => $data['order_amount'],
                'receipt_order_id' => $order_id
            ];

            $result3 = $this -> receiptModel -> insert($receipt_data);

        }
        $this -> cartModel -> empty();
        echo json_encode([$result, $result2, $result3]);
    }


    public function update () {
        $data = $_POST;

        $result = $this -> orderModel -> updateById($data['order_id'], $data);
        
        echo json_encode($result);
    }

}

