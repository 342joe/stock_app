<?php include 'App/Views/Layout/header.php'; ?>

<style>
.content-wrapper {
    min-height: calc(100vh - 180px);
    padding-bottom: 40px;
}
</style>

<div class="content-wrapper">
<div class="container mt-4">

<!-- ================= STATISTIQUES ================= -->
<div class="row mb-4">
    <div class="col-md-3">
        <div class="card shadow-sm text-center">
            <div class="card-body">
                <h6 class="text-muted">
                    <i class="bi bi-box-seam"></i> Produits
                </h6>
                <h3><?= $totalProducts ?></h3>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card shadow-sm text-center">
            <div class="card-body">
                <h6 class="text-muted">
                    <i class="bi bi-currency-dollar"></i> Valeur du stock
                </h6>
                <h3><?= number_format($stockValue, 2) ?> $</h3>
            </div>
        </div>
    </div>
</div>

<!-- ================= TOOLBAR ================= -->
<div class="d-flex justify-content-between align-items-center mb-3">
    <div class="btn-group">
        <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#createModal">
            <i class="bi bi-plus-circle"></i> Nouveau produit
        </button>
        <button class="btn btn-outline-secondary" onclick="location.reload()">
            <i class="bi bi-arrow-repeat"></i> Actualiser
        </button>
    </div>

    <form method="GET" action="index.php" class="d-flex gap-2">
        <input type="hidden" name="action" value="products-search">

        <input
            class="form-control"
            name="q"
            placeholder="Recherche rapide…"
            value="<?= htmlspecialchars($_GET['q'] ?? '') ?>"
        >

        <select name="category" class="form-select">
            <option value="">Toutes les catégories</option>
            <?php foreach ($categories as $cat): ?>
                <option
                    value="<?= $cat['id'] ?>"
                    <?= (($_GET['category'] ?? '') == $cat['id']) ? 'selected' : '' ?>
                >
                    <?= htmlspecialchars($cat['name']) ?>
                </option>
            <?php endforeach; ?>
        </select>

        <button class="btn btn-primary">
            <i class="bi bi-search"></i>
        </button>
    </form>
</div>

<!-- ================= TABLE ================= -->
<div class="table-responsive shadow-sm rounded">
<table class="table table-hover align-middle mb-0">

<thead class="table-light">
<tr class="text-center small text-muted">
    <th>ID</th>
    <th>Nom</th>
    <th>Description</th>
    <th>Prix</th>
    <th>Achat</th>
    <th>Stock</th>
    <th>Barcode</th>
    <th>Catégorie</th>
    <th>Créé</th>
    <th class="text-start">Actions</th>
</tr>
</thead>

<tbody>
<?php foreach ($product as $p): ?>
<tr class="text-center">
    <td><?= $p['id'] ?></td>
    <td class="fw-semibold"><?= htmlspecialchars($p['name']) ?></td>
    <td><?= htmlspecialchars($p['description']) ?></td>
    <td><?= $p['price'] ?> $</td>
    <td><?= $p['purchase_price'] ?> $</td>

    <td>
        <?php if ($p['quantity'] < 10): ?>
            <span class="badge bg-danger">
                <i class="bi bi-exclamation-circle"></i> Faible
            </span>
        <?php else: ?>
            <span class="badge bg-success"><?= $p['quantity'] ?></span>
        <?php endif; ?>
    </td>

    <td><?= htmlspecialchars($p['barcode']) ?></td>
    <td><?= htmlspecialchars($p['category_name']) ?></td>
    <td class="small"><?= $p['created_at'] ?></td>

    <td class="text-start">
        <div class="dropdown">
            <button class="btn btn-sm btn-outline-secondary dropdown-toggle" data-bs-toggle="dropdown">
                <i class="bi bi-three-dots"></i>
            </button>

            <ul class="dropdown-menu shadow">
                <li>
                    <button class="dropdown-item text-warning"
                        data-bs-toggle="modal" data-bs-target="#editModal"
                        data-id="<?= $p['id'] ?>"
                        data-name="<?= htmlspecialchars($p['name'], ENT_QUOTES) ?>"
                        data-description="<?= htmlspecialchars($p['description'], ENT_QUOTES) ?>"
                        data-price="<?= $p['price'] ?>"
                        data-purchase="<?= $p['purchase_price'] ?>"
                        data-quantity="<?= $p['quantity'] ?>"
                        data-barcode="<?= htmlspecialchars($p['barcode'], ENT_QUOTES) ?>"
                        data-category="<?= $p['category_id'] ?>"
                        data-created="<?= $p['created_at'] ?>">
                        <i class="bi bi-pencil-square"></i> Modifier
                    </button>
                </li>

                <li>
                    <button class="dropdown-item text-danger"
                        data-bs-toggle="modal" data-bs-target="#deleteModal"
                        data-id="<?= $p['id'] ?>">
                        <i class="bi bi-trash"></i> Supprimer
                    </button>
                </li>
            </ul>
        </div>
    </td>
</tr>
<?php endforeach; ?>
</tbody>

</table>
</div>

</div>
</div>

<!-- ================= MODAL CREATE ================= -->
<div class="modal fade" id="createModal" tabindex="-1">
<div class="modal-dialog modal-lg modal-dialog-centered">
<div class="modal-content">
<div class="modal-header bg-success text-white">
    <h5 class="modal-title">
        <i class="bi bi-plus-circle"></i> Ajouter un produit
    </h5>
    <button class="btn-close" data-bs-dismiss="modal"></button>
</div>

<div class="modal-body">
<form action="index.php?action=product-store" method="POST" class="row g-3">

<div class="col-md-6">
    <label class="form-label">Nom</label>
    <input class="form-control" name="name" required>
</div>

<div class="col-md-6">
    <label class="form-label">Prix de vente</label>
    <input class="form-control" name="price" type="number" step="0.01" required>
</div>

<div class="col-12">
    <label class="form-label">Description</label>
    <textarea class="form-control" name="description"></textarea>
</div>

<div class="col-md-6">
    <label class="form-label">Prix d'achat</label>
    <input class="form-control" name="purchase_price" type="number" step="0.01" required>
</div>

<div class="col-md-6">
    <label class="form-label">Quantité</label>
    <input class="form-control" name="quantity" type="number" required>
</div>

<div class="col-md-6">
    <label class="form-label">Barcode</label>
    <input class="form-control" name="barcode">
</div>

<div class="col-md-6">
    <label class="form-label">Catégorie</label>
    <select class="form-select" name="category_id">
        <?php foreach ($categories as $c): ?>
            <option value="<?= $c['id'] ?>">
                <?= htmlspecialchars($c['name']) ?>
            </option>
        <?php endforeach; ?>
    </select>
</div>

<div class="col-md-6">
    <label class="form-label">Créé le</label>
    <input class="form-control" name="created_at" type="datetime-local" required>
</div>

<div class="col-12 text-end">
    <button class="btn btn-success">
        <i class="bi bi-check-circle"></i> Créer
    </button>
</div>

</form>
</div>
</div>
</div>
</div>

<!-- ================= MODAL EDIT ================= -->
<div class="modal fade" id="editModal" tabindex="-1">
<div class="modal-dialog modal-lg modal-dialog-centered">
<div class="modal-content">
<div class="modal-header bg-warning">
    <h5 class="modal-title">
        <i class="bi bi-pencil-square"></i> Modifier le produit
    </h5>
    <button class="btn-close" data-bs-dismiss="modal"></button>
</div>

<div class="modal-body">
<form action="index.php?action=product-update" method="POST" class="row g-3">

<input type="hidden" name="id" id="edit-id">

<div class="col-md-6">
    <label class="form-label">Nom</label>
    <input class="form-control" id="edit-name" name="name">
</div>

<div class="col-md-6">
    <label class="form-label">Prix</label>
    <input class="form-control" id="edit-price" name="price">
</div>

<div class="col-12">
    <label class="form-label">Description</label>
    <textarea class="form-control" id="edit-description" name="description"></textarea>
</div>

<div class="col-md-6">
    <label class="form-label">Prix d'achat</label>
    <input class="form-control" id="edit-purchase" name="purchase_price">
</div>

<div class="col-md-6">
    <label class="form-label">Quantité</label>
    <input class="form-control" id="edit-quantity" name="quantity">
</div>

<div class="col-md-6">
    <label class="form-label">Barcode</label>
    <input class="form-control" id="edit-barcode" name="barcode">
</div>

<div class="col-md-6">
    <label class="form-label">Catégorie</label>
    <select class="form-select" id="edit-category" name="category_id">
        <?php foreach ($categories as $c): ?>
            <option value="<?= $c['id'] ?>">
                <?= htmlspecialchars($c['name']) ?>
            </option>
        <?php endforeach; ?>
    </select>
</div>

<div class="col-md-6">
    <label class="form-label">Créé le</label>
    <input class="form-control" id="edit-created" name="created_at" type="datetime-local">
</div>

<div class="col-12 text-end">
    <button class="btn btn-warning">
        <i class="bi bi-save"></i> Mettre à jour
    </button>
</div>

</form>
</div>
</div>
</div>
</div>

<!-- ================= MODAL DELETE ================= -->
<div class="modal fade" id="deleteModal" tabindex="-1">
<div class="modal-dialog modal-dialog-centered">
<div class="modal-content">
<div class="modal-header bg-danger text-white">
    <h5 class="modal-title">
        <i class="bi bi-trash"></i> Supprimer le produit
    </h5>
    <button class="btn-close" data-bs-dismiss="modal"></button>
</div>

<div class="modal-body">
<form action="index.php?action=product-delete" method="POST">
<input type="hidden" id="delete-id" name="id">
<button class="btn btn-danger w-100">
    <i class="bi bi-x-circle"></i> Supprimer définitivement
</button>
</form>
</div>

</div>
</div>
</div>

<script>
document.getElementById('editModal').addEventListener('show.bs.modal', function (e) {
    const b = e.relatedTarget;
    ['id','name','description','price','purchase','quantity','barcode','category','created']
        .forEach(k => document.getElementById('edit-' + k).value = b.dataset[k]);
});

document.getElementById('deleteModal').addEventListener('show.bs.modal', function (e) {
    document.getElementById('delete-id').value = e.relatedTarget.dataset.id;
});
</script>

<?php include 'App/Views/Layout/footer.php'; ?>