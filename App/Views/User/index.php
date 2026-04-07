<?php include 'App/Views/Layout/header.php'; ?>

<style>
.content-wrapper {
    margin-left: 260px;
    min-height: calc(100vh - 120px);
    padding: 40px 0;
}
</style>

<div class="content-wrapper">
<div class="container">
<div class="saas-card">

<!-- ================= HEADER ================= -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="mb-1">Utilisateurs</h4>
        <small class="text-muted">Gestion des comptes utilisateurs</small>
    </div>

    <?php if ($_SESSION['user']['role_name'] === 'admin'): ?>
        <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#createModal">
            + Ajouter utilisateur
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
    <th>Email</th>
    <th>Rôle</th>
    <th>Statut</th>
    <th>Créé le</th>
    <th class="text-end">Actions</th>
</tr>
</thead>

<tbody>
<?php if (!empty($users)): ?>
<?php foreach ($users as $u): ?>
<tr>
    <td class="text-muted"><?= $u['id'] ?></td>
    <td class="fw-semibold"><?= htmlspecialchars($u['name']) ?></td>
    <td><?= htmlspecialchars($u['email']) ?></td>

    <td>
        <span class="badge bg-secondary">
            <?= htmlspecialchars($u['role_name'] ?? '—') ?>
        </span>
    </td>

    <td>
        <?php if ($u['is_active']): ?>
            <span class="badge bg-success">Actif</span>
        <?php else: ?>
            <span class="badge bg-secondary">Désactivé</span>
        <?php endif; ?>
    </td>

    <td class="small text-muted"><?= htmlspecialchars($u['created_at']) ?></td>

    <td class="text-end">
    <?php if ($_SESSION['user']['role_name'] === 'admin'): ?>
        <div class="dropdown">
            <button class="btn btn-sm btn-outline-secondary dropdown-toggle" data-bs-toggle="dropdown">
                Actions
            </button>

            <ul class="dropdown-menu shadow">

                <!-- MODIFIER -->
                <li>
                    <button class="dropdown-item text-warning"
                        data-bs-toggle="modal"
                        data-bs-target="#editModal"
                        data-id="<?= $u['id'] ?>"
                        data-name="<?= htmlspecialchars($u['name'], ENT_QUOTES) ?>"
                        data-email="<?= htmlspecialchars($u['email'], ENT_QUOTES) ?>"
                        data-role="<?= $u['role_id'] ?>">
                        ✏ Modifier
                    </button>
                </li>

                <!-- ACTIVER / DESACTIVER -->
                <?php if ($u['is_active']): ?>
                    <li>
                        <button class="dropdown-item text-danger"
                            data-bs-toggle="modal"
                            data-bs-target="#confirmDeactivateModal"
                            data-id="<?= $u['id'] ?>">
                            ⛔ Désactiver
                        </button>
                    </li>
                <?php else: ?>
                    <li>
                        <button class="dropdown-item text-success"
                            data-bs-toggle="modal"
                            data-bs-target="#confirmActivateModal"
                            data-id="<?= $u['id'] ?>">
                            ✅ Activer
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
    <td colspan="7" class="text-center text-muted">
        Aucun utilisateur trouvé
    </td>
</tr>
<?php endif; ?>
</tbody>

</table>
</div>

</div>
</div>
</div>

<!-- ================= MODAL CREATE ================= -->
<?php if ($_SESSION['user']['role_name'] === 'admin'): ?>
<div class="modal fade" id="createModal" tabindex="-1">
<div class="modal-dialog modal-dialog-centered">
<div class="modal-content">

<div class="modal-header bg-success text-white">
    <h5 class="modal-title">Ajouter utilisateur</h5>
    <button class="btn-close" data-bs-dismiss="modal"></button>
</div>

<div class="modal-body">
<form action="index.php?action=user-store" method="POST">

<div class="mb-3">
    <label class="form-label">Nom</label>
    <input class="form-control" name="name" required>
</div>

<div class="mb-3">
    <label class="form-label">Email</label>
    <input class="form-control" type="email" name="email" required>
</div>

<div class="mb-3">
    <label class="form-label">Mot de passe</label>
    <input class="form-control" type="password" name="password" required>
</div>

<div class="mb-3">
    <label class="form-label">Rôle</label>
    <select class="form-select" name="role_id" required>
        <?php foreach ($roles as $role): ?>
            <option value="<?= $role['id'] ?>">
                <?= htmlspecialchars($role['name']) ?>
            </option>
        <?php endforeach; ?>
    </select>
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

<!-- ================= MODAL EDIT ================= -->
<?php if ($_SESSION['user']['role_name'] === 'admin'): ?>
<div class="modal fade" id="editModal" tabindex="-1">
<div class="modal-dialog modal-dialog-centered">
<div class="modal-content">

<div class="modal-header bg-warning">
    <h5 class="modal-title">Modifier utilisateur</h5>
    <button class="btn-close" data-bs-dismiss="modal"></button>
</div>

<div class="modal-body">
<form action="index.php?action=user-update" method="POST">

<input type="hidden" name="id" id="edit-id">

<div class="mb-3">
    <label class="form-label">Nom</label>
    <input class="form-control" name="name" id="edit-name" required>
</div>

<div class="mb-3">
    <label class="form-label">Email</label>
    <input class="form-control" type="email" name="email" id="edit-email" required>
</div>

<div class="mb-3">
    <label class="form-label">Nouveau mot de passe</label>
    <input class="form-control" type="password" name="password">
</div>

<div class="mb-3">
    <label class="form-label">Rôle</label>
    <select class="form-select" name="role_id" id="edit-role" required>
        <?php foreach ($roles as $role): ?>
            <option value="<?= $role['id'] ?>">
                <?= htmlspecialchars($role['name']) ?>
            </option>
        <?php endforeach; ?>
    </select>
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

<!-- ================= MODAL DESACTIVER ================= -->
<div class="modal fade" id="confirmDeactivateModal" tabindex="-1">
<div class="modal-dialog modal-dialog-centered">
<div class="modal-content">

<div class="modal-header bg-danger text-white">
    <h5 class="modal-title">Désactiver l'utilisateur</h5>
    <button class="btn-close" data-bs-dismiss="modal"></button>
</div>

<div class="modal-body">
    Voulez-vous vraiment désactiver cet utilisateur ?
    <br>
    <small class="text-muted">Il ne pourra plus se connecter</small>
</div>

<div class="modal-footer">
    <button class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
    <a id="confirmDeactivateBtn" class="btn btn-danger">Désactiver</a>
</div>

</div>
</div>
</div>

<!-- ================= MODAL ACTIVER ================= -->
<div class="modal fade" id="confirmActivateModal" tabindex="-1">
<div class="modal-dialog modal-dialog-centered">
<div class="modal-content">

<div class="modal-header bg-success text-white">
    <h5 class="modal-title">Activer l'utilisateur</h5>
    <button class="btn-close" data-bs-dismiss="modal"></button>
</div>

<div class="modal-body">
    Voulez-vous activer cet utilisateur ?
</div>

<div class="modal-footer">
    <button class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
    <a id="confirmActivateBtn" class="btn btn-success">Activer</a>
</div>

</div>
</div>
</div>

<!-- ================= JS ================= -->
<script>
document.getElementById('editModal')?.addEventListener('show.bs.modal', function (e) {
    const b = e.relatedTarget;
    document.getElementById('edit-id').value = b.dataset.id;
    document.getElementById('edit-name').value = b.dataset.name;
    document.getElementById('edit-email').value = b.dataset.email;
    document.getElementById('edit-role').value = b.dataset.role;
});

document.getElementById('confirmDeactivateModal')?.addEventListener('show.bs.modal', function (e) {
    const userId = e.relatedTarget.dataset.id;
    document.getElementById('confirmDeactivateBtn').href =
        'index.php?action=user-deactivate&id=' + userId;
});

document.getElementById('confirmActivateModal')?.addEventListener('show.bs.modal', function (e) {
    const userId = e.relatedTarget.dataset.id;
    document.getElementById('confirmActivateBtn').href =
        'index.php?action=user-activate&id=' + userId;
});
</script>

<?php include 'App/Views/Layout/footer.php'; ?>