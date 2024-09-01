<?php
class Controller
{

    protected $productModel;
    protected $userModel;
    protected $cartModel;
    protected $mailerModel;
    protected $orderModel;
    protected $calificationModel;
    protected $multimediaModel;
    protected $withdrawModel;
    protected $soldProductModel;
    protected $paymentDetailsModel;
    protected $shippingDetailsModel;
    protected $conn;

    public function __construct(PDO $conn)
    {
        $this->userModel = new User($conn);
        $this->productModel = new Product($conn);
        $this->cartModel = new Cart($conn);
        $this->mailerModel = new Mailer($conn);
        $this->orderModel = new Order($conn);
        $this->calificationModel = new Calification($conn);
        $this->multimediaModel = new Multimedia($conn);
        $this->withdrawModel = new Withdraw($conn);
        $this->soldProductModel = new SoldProduct($conn);
        $this->paymentDetailsModel = new PaymentDetails($conn);
        $this->shippingDetailsModel = new ShippingDetails($conn);
        $this->conn = $conn;
    }
}
