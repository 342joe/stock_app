<?php include 'App/Views/Product/header.php'; ?>

<!-- Correction design général -->
<style>
    .content-wrapper {
        min-height: calc(100vh - 180px);
        padding-bottom: 40px;
    }
</style>

<!-- Début contenu -->
<div class="content-wrapper">
    <div class="container mt-4">

<?php if ($view === 'list'): ?>

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="text-primary">📦 Liste des produits</h2>

        <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#createModal">
            + Ajouter un produit
        </button>
    </div>

    <!-- Tableau Bootstrap -->
    <div class="table-responsive shadow-sm">
        <table class="table table-striped table-hover text-center align-middle">
            <thead class="table-primary">
                <tr>
                    <th>ID</th>
                    <th>Nom</th>
                    <th>Description</th>
                    <th>Prix</th>
                    <th>Achat</th>
                    <th>Qte</th>
                    <th>Barcode</th>
                    <th>Catégorie</th>
                    <th>Créé le</th>
                    <th>Actions</th>
                </tr>
            </thead>

            <tbody>
            <?php foreach ($product as $p): ?>
                <tr>
                    <td><?= $p['id'] ?></td>
                    <td><?= $p['name'] ?></td>
                    <td><?= $p['description'] ?></td>
                    <td><?= $p['price'] ?></td>
                    <td><?= $p['purchase_price'] ?></td>
                    <td><?= $p['quantity'] ?></td>
                    <td><?= $p['barcode'] ?></td>
                    <td><?= $p['category_id'] ?></td>
                    <td><?= $p['created_at'] ?></td>

                    <td>
                        <!-- Bouton Modifier -->
                        <button class="btn btn-warning btn-sm"
                                data-bs-toggle="modal"
                                data-bs-target="#editModal"
                                data-id="<?= $p['id'] ?>"
                                data-name="<?= $p['name'] ?>"
                                data-description="<?= $p['description'] ?>"
                                data-price="<?= $p['price'] ?>"
                                data-purchase="<?= $p['purchase_price'] ?>"
                                data-quantity="<?= $p['quantity'] ?>"
                                data-barcode="<?= $p['barcode'] ?>"
                                data-category="<?= $p['category_id'] ?>"
                                data-created="<?= $p['created_at'] ?>">
                            Modifier
                        </button>

                        <!-- Bouton Supprimer -->
                        <button class="btn btn-danger btn-sm"
                                data-bs-toggle="modal"
                                data-bs-target="#deleteModal"
                                data-id="<?= $p['id'] ?>">
                            Supprimer
                        </button>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>

        </table>
    </div>

<?php endif; ?>
    </div>
</div>
<!-- Fin contenu -->


<!-- ✅ Modal Ajouter -->
<div class="modal fade" id="createModal" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">

      <div class="modal-header bg-success text-white">
        <h5 class="modal-title">Ajouter un produit</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body">

        <form action="index.php?action=product-store" method="POST" class="row g-3">

            <div class="col-md-6">
                <label class="form-label">Nom :</label>
                <input type="text" name="name" class="form-control" required>
            </div>

            <div class="col-md-6">
                <label class="form-label">Prix :</label>
                <input type="number" name="price" step="0.01" class="form-control" required>
            </div>

            <div class="col-12">
                <label class="form-label">Description :</label>
                <textarea name="description" class="form-control" required></textarea>
            </div>

            <div class="col-md-6">
                <label class="form-label">Prix d'achat :</label>
                <input type="number" name="purchase_price" step="0.01" class="form-control" required>
            </div>

            <div class="col-md-6">
                <label class="form-label">Quantité :</label>
                <input type="number" name="quantity" class="form-control" required>
            </div>

            <div class="col-md-6">
                <label class="form-label">Barcode :</label>
                <input type="text" name="barcode" class="form-control" required>
            </div>

            <div class="col-md-6">
                <label class="form-label">Catégorie :</label>
                <input type="number" name="category_id" class="form-control">
            </div>

            <div class="col-md-6">
                <label class="form-label">Créé le :</label>
                <input type="datetime-local" name="created_at" class="form-control" required>
            </div>

            <div class="col-12 text-end">
                <button type="submit" class="btn btn-success">Créer ✅</button>
            </div>

        </form>

      </div>

    </div>
  </div>
</div>


<!-- ✅ Modal Modifier -->
<div class="modal fade" id="editModal" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">

      <div class="modal-header bg-warning">
        <h5 class="modal-title">Modifier le produit</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body">

        <form action="index.php?action=product-update" method="POST" class="row g-3">

            <input type="hidden" name="id" id="edit-id">

            <div class="col-md-6">
                <label class="form-label">Nom :</label>
                <input type="text" name="name" id="edit-name" class="form-control" required>
            </div>

            <div class="col-md-6">
                <label class="form-label">Prix :</label>
                <input type="number" name="price" id="edit-price" step="0.01" class="form-control" required>
            </div>

            <div class="col-12">
                <label class="form-label">Description :</label>
                <textarea name="description" id="edit-description" class="form-control" required></textarea>
            </div>

            <div class="col-md-6">
                <label class="form-label">Prix d'achat :</label>
                <input type="number" name="purchase_price" id="edit-purchase" step="0.01" class="form-control" required>
            </div>

            <div class="col-md-6">
                <label class="form-label">Quantité :</label>
                <input type="number" name="quantity" id="edit-quantity" class="form-control" required>
            </div>

            <div class="col-md-6">
                <label class="form-label">Barcode :</label>
                <input type="text" name="barcode" id="edit-barcode" class="form-control" required>
            </div>

            <div class="col-md-6">
                <label class="form-label">Catégorie :</label>
                <input type="number" name="category_id" id="edit-category" class="form-control" required>
            </div>

            <div class="col-md-6">
                <label class="form-label">Créé le :</label>
                <input type="datetime-local" name="created_at" id="edit-created" class="form-control" required>
            </div>

            <div class="col-12 text-end">
                <button type="submit" class="btn btn-warning">Mettre à jour ✅</button>
            </div>

        </form>

      </div>

    </div>
  </div>
</div>


<!-- ✅ Modal Supprimer -->
<div class="modal fade" id="deleteModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">

      <div class="modal-header bg-danger text-white">
        <h5 class="modal-title">Supprimer le produit</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body">
        <p>Voulez-vous vraiment supprimer ce produit ?</p>
        <p><strong>Cette action est irréversible.</strong></p>

        <form action="index.php?action=product-delete" method="POST">
            <input type="hidden" name="id" id="delete-id">

            <button type="submit" class="btn btn-danger w-100">
                Supprimer définitivement 
            </button>
        </form>
      </div>

    </div>
  </div>
</div>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
// Remplir modal Modifier
document.getElementById('editModal').addEventListener('show.bs.modal', function (event) {
    let btn = event.relatedTarget;

    document.getElementById('edit-id').value = btn.getAttribute('data-id');
    document.getElementById('edit-name').value = btn.getAttribute('data-name');
    document.getElementById('edit-description').value = btn.getAttribute('data-description');
    document.getElementById('edit-price').value = btn.getAttribute('data-price');
    document.getElementById('edit-purchase').value = btn.getAttribute('data-purchase');
    document.getElementById('edit-quantity').value = btn.getAttribute('data-quantity');
    document.getElementById('edit-barcode').value = btn.getAttribute('data-barcode');
    document.getElementById('edit-category').value = btn.getAttribute('data-category');
    document.getElementById('edit-created').value = btn.getAttribute('data-created');
});

// Remplir modal Supprimer
document.getElementById('deleteModal').addEventListener('show.bs.modal', function (event) {
    let btn = event.relatedTarget;
    document.getElementById('delete-id').value = btn.getAttribute('data-id');
});
</script>


<?php include 'App/Views/Product/footer.php'; ?>