<?php include 'App/Views/Layout/header.php'; ?>

<div class="content-wrapper">
<div class="container mt-4">

<div class="saas-card">

    <!-- ================= HEADER ================= -->
 <div class="d-flex justify-content-between align-items-center mb-3">
    <div>
        <h4 class="mb-1">
            <i class="bi bi-cash-coin"></i>
            Vente de produits
        </h4>
        <small class="text-muted">
            Ajouter des produits au panier puis générer la facture
        </small>
    </div>

    <!-- BOUTON HISTORIQUE -->
    <?php if (in_array($_SESSION['user']['role_name'], ['admin','responsable_stock'])): ?>
        <a href="index.php?action=sales-history" class="btn btn-outline-secondary">
            <i class="bi bi-clock-history"></i>
            Historique des ventes
        </a>
    <?php endif; ?>
</div>

    <!-- ================= ALERTS ================= -->
    <?php if (isset($_GET['error'])): ?>
        <div class="alert alert-danger">
            <i class="bi bi-exclamation-triangle"></i>
            <?= htmlspecialchars($_GET['error']) ?>
        </div>
    <?php endif; ?>

    <!-- ================= SCAN CODE BARRES ================= -->
    <div class="mb-4">
        <label class="form-label">
            <i class="bi bi-upc-scan"></i>
            Scanner le code‑barres
        </label>
        <input
            type="text"
            id="barcodeInput"
            class="form-control"
            placeholder="Scanner ici (ex: 12345 + Entrée)"
            autocomplete="off"
        >
    </div>

    <!-- ================= FORM AJOUT AU PANIER ================= -->
    <form action="index.php?action=sale-add" method="POST" class="row g-3 mt-2">

        <!-- PRODUIT -->
        <div class="col-md-6">
            <label class="form-label">
                <i class="bi bi-box-seam"></i>
                Produit
            </label>
            <select class="form-select" name="product_id" required>
                <option value="">— Sélectionner un produit —</option>
                <?php foreach ($products as $p): ?>
                    <option value="<?= $p['id'] ?>">
                        <?= htmlspecialchars($p['name']) ?> (Stock : <?= $p['quantity'] ?>)
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <!-- QUANTITÉ -->
        <div class="col-md-4">
            <label class="form-label">
                <i class="bi bi-123"></i>
                Quantité
            </label>
            <input type="number" name="quantity" class="form-control" min="1" required>
        </div>

        <!-- BOUTON AJOUT -->
        <div class="col-md-2 d-flex align-items-end">
            <button class="btn btn-outline-primary w-100">
                <i class="bi bi-plus-circle"></i>
                Ajouter
            </button>
        </div>

    </form>

    <hr>

    <!-- ================= PANIER ================= -->
    <h5 class="mb-3">
        <i class="bi bi-cart"></i>
        Panier
    </h5>

    <?php if (!empty($cart)): ?>
        <div class="table-responsive">
            <table class="table table-sm align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Produit</th>
                        <th class="text-center">Quantité</th>
                        <th class="text-end">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($cart as $index => $item): ?>
                        <tr>
                            <td>
                                <?php
                                foreach ($products as $p) {
                                    if ($p['id'] == $item['product_id']) {
                                        echo htmlspecialchars($p['name']);
                                        break;
                                    }
                                }
                                ?>
                            </td>
                            <td class="text-center"><?= $item['quantity'] ?></td>
                            <td class="text-end">
                                <a
                                    href="index.php?action=sale-remove&index=<?= $index ?>"
                                    class="btn btn-sm btn-danger"
                                >
                                    <i class="bi bi-trash"></i>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <!-- ================= VALIDER LA VENTE ================= -->
        <div class="text-end mt-4">
            <form action="index.php?action=sale-store" method="POST" class="row g-3 justify-content-end">

                <!-- MOYEN DE PAIEMENT -->
                <div class="col-md-4">
                    <label class="form-label">
                        <i class="bi bi-credit-card"></i>
                        Moyen de paiement
                    </label>
                    <select name="payment_method" class="form-select" required>
                        <option value="cash">💵 Cash</option>
                        <option value="mobile">📱 Mobile Money</option>
                    </select>
                </div>

                <div class="col-md-12 text-end">
                    <button class="btn btn-success px-4 mt-3">
                        <i class="bi bi-receipt"></i>
                        Valider la vente & générer la facture
                    </button>
                </div>

            </form>
        </div>

    <?php else: ?>
        <p class="text-muted">
            Le panier est vide.
        </p>
    <?php endif; ?>

</div>

</div>
</div>

<!-- ================= JS SCAN BARCODE ================= -->
<script>
const barcodeInput = document.getElementById('barcodeInput');

barcodeInput.addEventListener('keydown', function (e) {
    if (e.key === 'Enter') {
        e.preventDefault();

        const barcode = barcodeInput.value.trim();
        if (!barcode) return;

        fetch(`index.php?action=product-scan&barcode=${barcode}`)
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    fetch('index.php?action=sale-add', {
                        method: 'POST',
                        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                        body: `product_id=${data.product.id}&quantity=1`
                    }).then(() => location.reload());
                } else {
                    alert('Produit introuvable');
                }
            });

        barcodeInput.value = '';
    }
});
</script>

<?php include 'App/Views/Layout/footer.php'; ?>