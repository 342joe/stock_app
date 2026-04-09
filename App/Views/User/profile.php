<?php include 'App/Views/Layout/header.php'; ?>
<?php
$user = $_SESSION['user'];
?>

<div class="content-wrapper">
  <div class="container">

    <h4 class="mb-4">
      <i class="bi bi-gear"></i> Paramètres du profil
    </h4>

    <?php if (isset($_GET['success'])): ?>
      <div class="alert alert-success">
        Modifications enregistrées avec succès.
      </div>
    <?php endif; ?>

    <?php if (isset($_GET['error']) && $_GET['error'] === 'password'): ?>
      <div class="alert alert-danger">
        Mot de passe actuel incorrect.
      </div>
    <?php endif; ?>

    <div class="row g-4">

      <!-- ================= PROFIL ================= -->
      <div class="col-md-6">
        <div class="saas-card">
          <h6 class="mb-3">Informations personnelles</h6>

          <form method="POST" action="index.php?action=profile-update">
            <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">

            <div class="mb-3">
              <label class="form-label">Nom</label>
              <input type="text"
                     name="name"
                     class="form-control"
                     value="<?= htmlspecialchars($user['name']) ?>"
                     required>
            </div>

            <div class="mb-3">
              <label class="form-label">Email</label>
              <input type="email"
                     name="email"
                     class="form-control"
                     value="<?= htmlspecialchars($user['email']) ?>"
                     required>
            </div>

            <button class="btn btn-success">
              <i class="bi bi-check"></i> Enregistrer
            </button>
          </form>
        </div>
      </div>

      <!-- ================= PASSWORD ================= -->
      <div class="col-md-6">
        <div class="saas-card">
          <h6 class="mb-3">Sécurité</h6>

          <form method="POST" action="index.php?action=profile-password">
            <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">

            <div class="mb-3">
              <label class="form-label">Mot de passe actuel</label>
              <input type="password"
                     name="current_password"
                     class="form-control"
                     required>
            </div>

            <div class="mb-3">
              <label class="form-label">Nouveau mot de passe</label>
              <input type="password"
                     name="new_password"
                     class="form-control"
                     required>
            </div>

            <button class="btn btn-warning">
              <i class="bi bi-shield-lock"></i> Modifier le mot de passe
            </button>
          </form>
        </div>
      </div>

    </div>
  </div>
</div>
<?php include 'App/Views/Layout/footer.php'; ?>