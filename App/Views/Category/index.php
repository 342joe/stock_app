<?php include 'App/Views/Layout/header.php'; ?>

<style>
body {
    background: #e9f7ef;
}
.content-wrapper {
    min-height: calc(100vh - 180px);
    padding: 40px 0;
}
.saas-card {
    background: #fff;
    border-radius: 14px;
    padding: 28px;
    box-shadow: 0 10px 25px rgba(0,0,0,0.08);
}
.table thead th {
    font-size: 13px;
    color: #6c757d;
    border-bottom: none;
}
.table tbody tr:hover {
    background: #f8fdfb;
}
</style>

<div class="content-wrapper">
<div class="container">
<div class="saas-card">

<!-- ================= HEADER ================= -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="mb-1">Catégories</h4>
        <small class="text-muted">Gestion des catégories de produits</small>
    </div>

    <?php if (in_array($_SESSION['user']['role_name'], ['admin', 'manager'])): ?>
        <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#createModal">
            + Ajouter une catégorie
        </button>
    <?php endif; ?>
</div>

<!-- ================= TABLE ================= -->
<div class="table-responsive">
<table class="table align-middle mb-0">
<thead>
<tr>
    <th>ID</th>
    <th>Nom</th>
    <th>Description</th>
    <th>Date de création</th>
    <th class="text-end">Actions</th>
</tr>
</thead>

<tbody>
<?php if (!empty($category)): ?>
<?php foreach ($category as $c): ?>
<tr>
    <td class="text-muted"><?= $c['id'] ?></td>
    <td class="fw-semibold"><?= htmlspecialchars($c['name']) ?></td>
    <td class="text-muted"><?= htmlspecialchars($c['description']) ?></td>
    <td class="small text-muted"><?= $c['created_at'] ?></td>

    <td class="text-end">
    <?php if (in_array($_SESSION['user']['role_name'], ['admin', 'manager'])): ?>
        <div class="dropdown">
            <button class="btn btn-sm btn-outline-secondary dropdown-toggle" data-bs-toggle="dropdown">
                Actions
            </button>

            <ul class="dropdown-menu shadow">
                <li>
                    <button class="dropdown-item text-warning"
                        data-bs-toggle="modal"
                        data-bs-target="#editModal"
                        data-id="<?= $c['id'] ?>"
                        data-name="<?= htmlspecialchars($c['name'], ENT_QUOTES) ?>"
                        data-description="<?= htmlspecialchars($c['description'], ENT_QUOTES) ?>">
                        ✏ Modifier
                    </button>
                </li>

                <?php if ($_SESSION['user']['role_name'] === 'admin'): ?>
                <li>
                    <button class="dropdown-item text-danger"
                        data-bs-toggle="modal"
                        data-bs-target="#deleteModal"
                        data-id="<?= $c['id'] ?>">
                        🗑 Supprimer
                    </button>
                </li>
                <?php endif; ?>
            </ul>
        </div>
    <?php else: ?>
        <span class="text-muted">—</span>
    <?php endif; ?>
    </td>
</tr>
<?php endforeach; ?>
<?php else: ?>
<tr>
    <td colspan="5" class="text-center text-muted">
        Aucune catégorie trouvée
    </td>
</tr>
<?php endif; ?>
</tbody>
</table>
</div>

</div>
</div>
</div>

<!-- ================= CREATE MODAL ================= -->
<?php if (in_array($_SESSION['user']['role_name'], ['admin', 'manager'])): ?>
<div class="modal fade" id="createModal" tabindex="-1">
<div class="modal-dialog">
<div class="modal-content">

<div class="modal-header bg-success text-white">
    <h5 class="modal-title">Ajouter une catégorie</h5>
    <button class="btn-close" data-bs-dismiss="modal"></button>
</div>

<div class="modal-body">
<form action="index.php?action=category-store" method="POST">

    <div class="mb-3">
        <label class="form-label">Nom</label>
        <input class="form-control" name="name" required>
    </div>

    <div class="mb-3">
        <label class="form-label">Description</label>
        <textarea class="form-control" name="description"></textarea>
    </div>

    <div class="text-end">
        <button class="btn btn-success">Créer</button>
    </div>
</form>
</div>

</div>
</div>
</div>
<?php endif; ?>

<!-- ================= EDIT MODAL ================= -->
<?php if (in_array($_SESSION['user']['role_name'], ['admin', 'manager'])): ?>
<div class="modal fade" id="editModal" tabindex="-1">
<div class="modal-dialog modal-dialog-centered">
<div class="modal-content">

<div class="modal-header bg-warning">
    <h5 class="modal-title">Modifier la catégorie</h5>
    <button class="btn-close" data-bs-dismiss="modal"></button>
</div>

<div class="modal-body">
<form action="index.php?action=category-update" method="POST">
    <input type="hidden" name="id" id="edit-id">

    <div class="mb-3">
        <label class="form-label">Nom</label>
        <input class="form-control" name="name" id="edit-name" required>
    </div>

    <div class="mb-3">
        <label class="form-label">Description</label>
        <textarea class="form-control" name="description" id="edit-description"></textarea>
    </div>

    <div class="text-end">
        <button class="btn btn-warning">Mettre à jour</button>
    </div>
</form>
</div>

</div>
</div>
</div>
<?php endif; ?>

<!-- ================= DELETE MODAL ================= -->
<?php if ($_SESSION['user']['role_name'] === 'admin'): ?>
<div class="modal fade" id="deleteModal" tabindex="-1">
<div class="modal-dialog">
<div class="modal-content">

<div class="modal-header bg-danger text-white">
    <h5 class="modal-title">Supprimer la catégorie</h5>
    <button class="btn-close" data-bs-dismiss="modal"></button>
</div>

<div class="modal-body">
<form action="index.php?action=category-delete" method="POST">
    <input type="hidden" name="id" id="delete-id">
    <button class="btn btn-danger w-100">Supprimer définitivement</button>
</form>
</div>

</div>
</div>
</div>
<?php endif; ?>

<!-- ================= JS ================= -->
<script>
document.getElementById('editModal')?.addEventListener('show.bs.modal', function (e) {
    const btn = e.relatedTarget;
    document.getElementById('edit-id').value = btn.dataset.id;
    document.getElementById('edit-name').value = btn.dataset.name;
    document.getElementById('edit-description').value = btn.dataset.description;
});

document.getElementById('deleteModal')?.addEventListener('show.bs.modal', function (e) {
    document.getElementById('delete-id').value = e.relatedTarget.dataset.id;
});
</script>

<?php include 'App/Views/Layout/footer.php'; ?>