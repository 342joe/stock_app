<?php
require_once './App/Models/Sale.php';

$saleModel = new Sale();

// Sécurité
if (!isset($_GET['id'])) {
    die('Facture introuvable');
}

$saleId = (int) $_GET['id'];
$data   = $saleModel->getInvoice($saleId);

if (!$data['sale']) {
    die('Facture introuvable');
}

$sale  = $data['sale'];
$items = $data['items'];

include 'App/Views/Layout/header.php';
?>

<div class="content-wrapper">
<div class="container mt-4">

<div class="saas-card">

    <!-- ================= HEADER FACTURE ================= -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="mb-1">
                <i class="bi bi-receipt"></i>
                Facture #<?= $sale['id'] ?>
            </h4>
            <small class="text-muted">
                Date : <?= date('d/m/Y H:i', strtotime($sale['created_at'])) ?>
            </small>
        </div>

        <div class="text-end">
            <strong>Vendeur :</strong><br>
            <?= htmlspecialchars($sale['seller']) ?><br>
            <strong>Paiement :</strong>
            <?= ucfirst($sale['payment_method']) ?>
        </div>
    </div>

    <hr>

    <!-- ================= TABLE PRODUITS ================= -->
    <div class="table-responsive">
        <table class="table table-bordered align-middle">
            <thead class="table-light">
                <tr>
                    <th>Produit</th>
                    <th class="text-center">Quantité</th>
                    <th class="text-end">Prix unitaire</th>
                    <th class="text-end">Total</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($items as $item): ?>
                    <tr>
                        <td><?= htmlspecialchars($item['product_name']) ?></td>
                        <td class="text-center"><?= $item['quantity'] ?></td>
                        <td class="text-end"><?= number_format($item['unit_price'], 2) ?> $</td>
                        <td class="text-end fw-semibold">
                            <?= number_format($item['total_price'], 2) ?> $
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- ================= TOTAL ================= -->
    <div class="d-flex justify-content-end mt-4">
        <div class="text-end">
            <h5>Total à payer :</h5>
            <h3 class="text-success">
                <?= number_format($sale['total_amount'], 2) ?> $
            </h3>
        </div>
    </div>

    <hr>

    <!-- ================= ACTIONS ================= -->
    <div class="d-flex justify-content-between mt-3">
        <a href="index.php?action=sales" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left"></i>
            Nouvelle vente
        </a>

        <div>
            <a href="index.php?action=invoice-pdf&id=<?= $sale['id'] ?>"
               class="btn btn-outline-primary me-2">
                <i class="bi bi-file-earmark-pdf"></i>
                Télécharger PDF
            </a>

            <button onclick="window.print()" class="btn btn-primary">
                <i class="bi bi-printer"></i>
                Imprimer
            </button>
        </div>
    </div>

</div>

</div>
</div>

<?php include 'App/Views/Layout/footer.php'; ?>