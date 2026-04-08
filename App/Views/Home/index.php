<?php include 'App/Views/Layout/header.php'; ?>

<div class="content-wrapper">
    <div class="container">

        <div class="saas-card">

            <!-- ================= TITRE ================= -->
            <h3 class="mb-2">
                Bienvenue sur StockApp
                <i class="bi bi-hand-thumbs-up text-success"></i>
            </h3>

            <p class="text-muted">
                Tableau de bord de gestion de stock.
            </p>

            <hr>

            <!-- ================= STATS ================= -->
            <div class="row g-4 mt-2">

                <!-- ================= PRODUITS ================= -->
                <div class="col-md-3">
                    <div class="card shadow-sm text-center h-100">
                        <div class="card-body">
                            <h6 class="text-muted">Produits</h6>

                            <h3 class="text-success fw-bold">
                                <?= $stats['products'] ?? 0 ?>
                            </h3>

                            <a href="index.php?action=products" class="btn btn-sm btn-outline-success">
                                <i class="bi bi-box-seam"></i>
                                Voir les produits
                            </a>
                        </div>
                    </div>
                </div>

                <!-- ================= CATEGORIES ================= -->
                <div class="col-md-3">
                    <div class="card shadow-sm text-center h-100">
                        <div class="card-body">
                            <h6 class="text-muted">Catégories</h6>

                            <h3 class="text-primary fw-bold">
                                <?= $stats['categories'] ?? 0 ?>
                            </h3>

                            <a href="index.php?action=categories" class="btn btn-sm btn-outline-success">
                                <i class="bi bi-tags"></i>
                                Voir les catégories
                            </a>
                        </div>
                    </div>
                </div>

                <!-- ================= CLIENTS ================= -->
                <?php if (in_array($_SESSION['user']['role_name'], ['admin', 'vendeur', 'caissier'])): ?>
                <div class="col-md-3">
                    <div class="card shadow-sm text-center h-100">
                        <div class="card-body">
                            <h6 class="text-muted">Clients</h6>

                            <h3 class="text-info fw-bold">
                                <?= $stats['customers'] ?? 0 ?>
                            </h3>

                            <a href="index.php?action=customer" class="btn btn-sm btn-outline-success">
                                <i class="bi bi-people-fill"></i>
                                Voir les clients
                            </a>
                        </div>
                    </div>
                </div>
                <?php endif; ?>

                <!-- ================= FOURNISSEURS ================= -->
                <?php if (in_array($_SESSION['user']['role_name'], ['admin', 'responsable_stock'])): ?>
                <div class="col-md-3">
                    <div class="card shadow-sm text-center h-100">
                        <div class="card-body">
                            <h6 class="text-muted">Fournisseurs</h6>

                            <h3 class="text-secondary fw-bold">
                                <?= $stats['suppliers'] ?? 0 ?>
                            </h3>

                            <a href="index.php?action=supplier" class="btn btn-sm btn-outline-success">
                                <i class="bi bi-truck"></i>
                                Voir les fournisseurs
                            </a>
                        </div>
                    </div>
                </div>
                <?php endif; ?>

                <!-- ================= UTILISATEURS ================= -->
                <?php if ($_SESSION['user']['role_name'] === 'admin'): ?>
                <div class="col-md-3">
                    <div class="card shadow-sm text-center h-100">
                        <div class="card-body">
                            <h6 class="text-muted">Utilisateurs</h6>

                            <h3 class="text-warning fw-bold">
                                <?= $stats['users'] ?? 0 ?>
                            </h3>

                            <a href="index.php?action=users" class="btn btn-sm btn-outline-success">
                                <i class="bi bi-people"></i>
                                Gérer les utilisateurs
                            </a>
                        </div>
                    </div>
                </div>
                <?php endif; ?>

            </div>

        </div>

    </div>
</div>

<?php include 'App/Views/Layout/footer.php'; ?>