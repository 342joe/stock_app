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
                Enregistrer une nouvelle vente
            </small>
        </div>
    </div>

    <!-- ================= ALERTS ================= -->
    <?php if (isset($_GET['success'])): ?>
        <div class="alert alert-success">
            <i class="bi bi-check-circle"></i>
            Vente enregistrée avec succès.
        </div>
    <?php endif; ?>

    <?php if (isset($_GET['error'])): ?>
        <div class="alert alert-danger">
            <i class="bi bi-exclamation-triangle"></i>
            <?= htmlspecialchars($_GET['error']) ?>
        </div>
    <?php endif; ?>

    <!-- ================= FORMulaire VENTE ================= -->
    <form action="index.php?action=sale-store" method="POST" class="row g-3 mt-2">

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
                        <?= htmlspecialchars($p['name']) ?>
                        (Stock : <?= $p['quantity'] ?>)
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <!-- QUANTITÉ -->
        <div class="col-md-6">
            <label class="form-label">
                <i class="bi bi-123"></i>
                Quantité à vendre
            </label>
            <input
                type="number"
                name="quantity"
                class="form-control"
                min="1"
                required
            >
        </div>

        <!-- BOUTON -->
        <div class="col-12 text-end mt-4">
            <button class="btn btn-success px-4">
                <i class="bi bi-cart-check"></i>
                Valider la vente
            </button>
        </div>

    </form>

</div>

</div>
</div>

<?php include 'App/Views/Layout/footer.php'; ?>