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
        <h4 class="mb-1">Fournisseurs</h4>
        <small class="text-muted">Manage your suppliers</small>
    </div>

    <?php if (in_array($_SESSION['user']['role_name'], ['admin', 'manager'])): ?>
        <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#createModal">
            + Create supplier
        </button>
    <?php endif; ?>
</div>

<!-- ================= TABLE ================= -->
<div class="table-responsive">
<table class="table align-middle mb-0">
<thead>
<tr>
    <th>ID</th>
    <th>Name</th>
    <th>Phone</th>
    <th>Email</th>
    <th>Address</th>
    <th>Created</th>
    <th class="text-end">Actions</th>
</tr>
</thead>

<tbody>
<?php if (!empty($supplier)): ?>
<?php foreach ($supplier as $s): ?>
<tr>
    <td class="text-muted"><?= $s['id'] ?></td>
    <td class="fw-semibold"><?= htmlspecialchars($s['name']) ?></td>
    <td><?= htmlspecialchars($s['phone']) ?></td>
    <td><?= htmlspecialchars($s['email']) ?></td>
    <td class="text-muted"><?= htmlspecialchars($s['address']) ?></td>
    <td class="small text-muted"><?= $s['created_at'] ?></td>

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
                            data-id="<?= $s['id'] ?>"
                            data-name="<?= htmlspecialchars($s['name'], ENT_QUOTES) ?>"
                            data-phone="<?= htmlspecialchars($s['phone'], ENT_QUOTES) ?>"
                            data-email="<?= htmlspecialchars($s['email'], ENT_QUOTES) ?>"
                            data-address="<?= htmlspecialchars($s['address'], ENT_QUOTES) ?>"
                            data-created="<?= $s['created_at'] ?>">
                        ✏ Modifier
                    </button>
                </li>

                <li>
                    <button class="dropdown-item text-danger"
                            data-bs-toggle="modal"
                            data-bs-target="#deleteModal"
                            data-id="<?= $s['id'] ?>">
                        🗑 Supprimer
                    </button>
                </li>
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
    <td colspan="7" class="text-center text-muted">No suppliers found</td>
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
    <h5 class="modal-title">Create supplier</h5>
    <button class="btn-close" data-bs-dismiss="modal"></button>
</div>

<div class="modal-body">
<form action="index.php?action=supplier-store" method="POST">
    <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">

    <div class="mb-3">
        <label class="form-label">Name</label>
        <input class="form-control" name="name" required>
    </div>

    <div class="mb-3">
        <label class="form-label">Phone</label>
        <input class="form-control" name="phone" required>
    </div>

    <div class="mb-3">
        <label class="form-label">Email</label>
        <input type="email" class="form-control" name="email" required>
    </div>

    <div class="mb-3">
        <label class="form-label">Address</label>
        <input class="form-control" name="address" required>
    </div>

    <div class="mb-3">
        <label class="form-label">Created at</label>
        <input type="date" class="form-control" name="created_at" required>
    </div>

    <div class="text-end">
        <button class="btn btn-success">Create</button>
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
    <h5 class="modal-title">Edit supplier</h5>
    <button class="btn-close" data-bs-dismiss="modal"></button>
</div>

<div class="modal-body">
<form action="index.php?action=supplier-update" method="POST">
    <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
    <input type="hidden" name="id" id="edit-id">

    <div class="mb-3">
        <label class="form-label">Name</label>
        <input class="form-control" name="name" id="edit-name" required>
    </div>

    <div class="mb-3">
        <label class="form-label">Phone</label>
        <input class="form-control" name="phone" id="edit-phone" required>
    </div>

    <div class="mb-3">
        <label class="form-label">Email</label>
        <input type="email" class="form-control" name="email" id="edit-email" required>
    </div>

    <div class="mb-3">
        <label class="form-label">Address</label>
        <input class="form-control" name="address" id="edit-address" required>
    </div>

    <div class="mb-3">
        <label class="form-label">Created at</label>
        <input type="date" class="form-control" name="created_at" id="edit-created" required>
    </div>

    <div class="text-end">
        <button class="btn btn-warning">Update</button>
    </div>
</form>
</div>

</div>
</div>
</div>
<?php endif; ?>

<!-- ================= DELETE MODAL ================= -->
<?php if (in_array($_SESSION['user']['role_name'], ['admin', 'manager'])): ?>
<div class="modal fade" id="deleteModal" tabindex="-1">
<div class="modal-dialog">
<div class="modal-content">

<div class="modal-header bg-danger text-white">
    <h5 class="modal-title">Delete supplier</h5>
    <button class="btn-close" data-bs-dismiss="modal"></button>
</div>

<div class="modal-body">
<form action="index.php?action=supplier-delete" method="POST">
    <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
    <input type="hidden" name="id" id="delete-id">

    <button class="btn btn-danger w-100">
        Delete permanently
    </button>
</form>
</div>

</div>
</div>
</div>
<?php endif; ?>

<!-- ================= JS ================= -->
<script>
document.getElementById('editModal')?.addEventListener('show.bs.modal', function (e) {
    const b = e.relatedTarget;
    document.getElementById('edit-id').value = b.dataset.id;
    document.getElementById('edit-name').value = b.dataset.name;
    document.getElementById('edit-phone').value = b.dataset.phone;
    document.getElementById('edit-email').value = b.dataset.email;
    document.getElementById('edit-address').value = b.dataset.address;
    document.getElementById('edit-created').value = b.dataset.created;
});

document.getElementById('deleteModal')?.addEventListener('show.bs.modal', function (e) {
    document.getElementById('delete-id').value = e.relatedTarget.dataset.id;
});
</script>

<?php include 'App/Views/Layout/footer.php'; ?>