<?php
require_once __DIR__ . '/../../Models/Sale.php';
require_once __DIR__ . '/../../Libs/dompdf/autoload.inc.php';

use Dompdf\Dompdf;
use Dompdf\Options;

$saleModel = new Sale();

if (!isset($_GET['id'])) {
    die('Facture introuvable');
}

$saleId = (int) $_GET['id'];
$data   = $saleModel->getInvoice($saleId);

if (!$data || !$data['sale']) {
    die('Facture introuvable');
}

$sale  = $data['sale'];
$items = $data['items'];

$html = '
<!DOCTYPE html>
<html>
<head>
<style>
body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
table { width:100%; border-collapse: collapse; }
th, td { border:1px solid #000; padding:6px; }
</style>
</head>
<body>

<h2>Facture #' . $sale['id'] . '</h2>

<p>
Vendeur : ' . htmlspecialchars($sale['seller']) . '<br>
Paiement : ' . ucfirst($sale['payment_method']) . '<br>
Date : ' . $sale['created_at'] . '
</p>

<table>
<tr><th>Produit</th><th>Qté</th><th>Total</th></tr>';

foreach ($items as $item) {
    $html .= '
    <tr>
        <td>' . htmlspecialchars($item['product_name']) . '</td>
        <td>' . $item['quantity'] . '</td>
        <td>' . $item['total_price'] . '</td>
    </tr>';
}

$html .= '
</table>

<h3>Total: ' . $sale['total_amount'] . '</h3>

</body>
</html>';

$options = new Options();
$options->set('isRemoteEnabled', true);

$pdf = new Dompdf($options);
$pdf->loadHtml($html);
$pdf->render();
$pdf->stream("facture_{$sale['id']}.pdf");
