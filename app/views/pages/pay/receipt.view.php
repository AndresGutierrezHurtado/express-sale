<?php
class FacturaPDF extends FPDF {
    private $order;

    // Constructor que recibe el array asociativo con la información del pedido
    function __construct($order) {
        parent::__construct();
        $this->order = $order;
    }

    function Header() {
        // Logo 
        $this->Image('public/images/logo.png',167,14,35);
        // Título
        $this->SetFont('Arial','B',40);
        $this->Cell(0, 15,'FACTURA',0,1,'L');

        $this->SetFont('Arial','B',15);
        $this->Cell(0, 8,'Express Sale',0,1,'L');

        $this->SetFont('Arial','',12);
        $this->Cell(0, 6,'Correo: expresssale.exsl@gmail.com',0,1,'L');
        $this->SetFont('Arial','',12);
        $this->Cell(0, 6,'Telefono: +57 320 9202177',0,1,'L');

        // Salto de línea
        $this->Ln(7);
        
        // Columna 1
        $this->SetFont('Arial','B',14);
        $this->Cell(45, 7,'FACTURAR A:',0,1,'L');
        $this->SetFont('Arial','',10);
        $this->MultiCell(45, 4, mb_convert_encoding($this->order['user_first_name'] . " " . $this->order['user_last_name'], 'ISO-8859-1', 'UTF-8' ), 0);
        $this->MultiCell(45, 4, mb_convert_encoding($this->order['user_address'], 'ISO-8859-1', 'UTF-8' ), 0);

        // Columna         
        $this->SetY($this->GetY() - 19);
        $this->Cell(65);
        $this->SetFont('Arial','B',14);
        $this->Cell(45, 7,'ENVIAR A:',0,1,'L');
        $this->Cell(65);
        $this->SetFont('Arial','',10);
        $this->MultiCell(45, 4, mb_convert_encoding($this->order['order_first_name'] . " " . $this->order['order_last_name'], 'ISO-8859-1', 'UTF-8' ), 0);
        $this->Cell(65);
        $this->MultiCell(45, 4, mb_convert_encoding($this->order['user_address'], 'ISO-8859-1', 'UTF-8' ), 0);

        // Columna 3
        $this->SetY($this->GetY() - 19);
        $this->Cell(130);
        $this->SetFont('Arial','B',14);
        $this->Cell(45, 7,'N DE FACTURA:',0,0,'L');

        $this->SetFont('Arial','',12);
        $this->Cell(15, 7,$this->order['receipt_id'],0,1,'R');

        $this->Cell(130);
        $this->SetFont('Arial','B',14);
        $this->Cell(45, 7,'N DE PEDIDO:',0,0,'L');
        
        $this->SetFont('Arial','',12);
        $this->Cell(15, 7,$this->order['order_id'],0,1,'R');

        $this->Cell(130);
        $this->SetFont('Arial','B',14);
        $this->Cell(45, 7,'FECHA:',0,0,'L');
        
        $this->SetFont('Arial','',12);
        $this->Cell(15, 7,$this->order['receipt_date'],0,1,'R');

        $this->Ln(10);

    }

    // Pie de página
    function Footer() {
        // Posición: a 1,5 cm del final
        $this->SetY(-15);
        // Arial italic 8
        $this->SetFont('Arial','I',8);
        // Número de página
        $this->Cell(0,10,'Pagina '.$this->PageNo().'/{nb}',0,0,'R');
    }

    // Contenido de la factura
    function Content() {
        // Definir encabezados de columna// Guardar la posición actual
        $posX = $this->GetX();
        $posY = $this->GetY();

        // Dibujar línea superior
        $this->SetLineWidth(0.5);
        $this->Line($posX, $posY, $posX + 190, $posY);

        $this->SetY($posY);

        // Tu código existente
        $this->SetFont('Arial','B',12);
        $this->Cell(70,10,mb_convert_encoding('Descripción', 'ISO-8859-1', 'UTF-8'),0,0,'C');
        $this->Cell(30,10,'Cantidad',0,0,'C');
        $this->Cell(45,10,'Precio',0,0,'C');
        $this->Cell(45,10,'Total',0,1,'C');

        // Dibujar línea inferior
        $this->SetLineWidth(0.5);
        $this->Line($posX, $this->GetY(), $posX + 190, $this->GetY());

        $preciototal = 0;

        // Aquí puedes agregar los datos de las filas
        $this->SetFont('Arial','',12);
        foreach ($this->order['products'] as $product) {
            $this->Cell(70,10,$product['product_name'],0,0, 'C');
            $this->Cell(30,10, $product['sold_product_quantity'],0,0,'C');
            $this->Cell(45,10,number_format($product['sold_product_price']).'COP',0,0,'C');
            $this->Cell(45,10,number_format($product['sold_product_price'] * $product['sold_product_quantity']).'COP',0,1,'C');
            $preciototal += $product['sold_product_price'] * $product['sold_product_quantity'];
        }
        $this->Cell(100);
        $this->Cell(45,10,'SubTotal',0,0,'C');
        $this->Cell(45,10,number_format($preciototal).'COP',0,1,'C');
        
        $this->Cell(100);
        $this->Cell(45,10,'IVA 19.0%',0,0,'C');
        $this->Cell(45,10,number_format($preciototal * 0.19).'COP',0,1,'C');

        $this->Cell(100);
        $this->SetFont('Arial','B',14);
        $this->Cell(45,10,'TOTAL',0,0,'C');
        $this->SetFont('Arial','',12);
        $this->Cell(45,10,number_format($preciototal += $preciototal * 0.19).'COP',0,1,'C');

        
        $this->Ln(20);
        // Guardar la posición actual
        $this->Cell(100);
        $posX = $this->GetX();
        $posY = $this->GetY();
        $this->Image('public/images/firma.png',$posX +10, $posY - 15  ,70);
        
        // Dibujar línea 
        $this->SetLineWidth(0.5);
        $this->Line($posX, $posY, $posX + 90, $posY);
        

        $this->Cell(90,10,'Firma',0,1,'C');
    }
}

// Crear instancia de la clase FacturaPDF
$pdf = new FacturaPDF($order);
$pdf->SetTitle('Recibo - Express Sale');
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->Content();
$pdf->Output();

