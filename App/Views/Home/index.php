<?php include 'App/Views/Layout/header.php'; ?>

<div class="content-wrapper">
    <div class="container">

        <div class="saas-card">

            <h3 class="mb-2">
                Bienvenue sur StockApp
                <i class="bi bi-hand-thumbs-up text-success"></i>
            </h3>

            <p class="text-muted">
                Tableau de bord de gestion de stock.
            </p>

            <hr>

            <div class="row g-4 mt-2">

                <!-- PRODUITS -->
                <div class="col-md-4">
                    <div class="card shadow-sm text-center">
                        <div class="card-body">
                            <h6 class="text-muted">Produits</h6>

                            <h3 class="text-success">
                                <i class="bi bi-box-seam"></i>
                            </h3>

                            <a href="index.php?action=products" class="btn btn-sm btn-outline-success">
                                <i class="bi bi-box-arrow-in-right"></i>
                                Voir les produits
                            </a>
                        </div>
                    </div>
                </div>

                <!-- CATEGORIES -->
                <div class="col-md-4">
                    <div class="card shadow-sm text-center">
                        <div class="card-body">
                            <h6 class="text-muted">Catégories</h6>

                            <h3 class="text-primary">
                                <i class="bi bi-tags"></i>
                            </h3>

                            <a href="index.php?action=categories" class="btn btn-sm btn-outline-success">
                                <i class="bi bi-box-arrow-in-right"></i>
                                Voir les catégories
                            </a>
                        </div>
                    </div>
                </div>

                <!-- UTILISATEURS -->
                <div class="col-md-4">
                    <div class="card shadow-sm text-center">
                        <div class="card-body">
                            <h6 class="text-muted">Utilisateurs</h6>

                            <h3 class="text-warning">
                                <i class="bi bi-people"></i>
                            </h3>

                            <a href="index.php?action=users" class="btn btn-sm btn-outline-success">
                                <i class="bi bi-gear"></i>
                                Gérer les utilisateurs
                            </a>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>
</div>

<?php include 'App/Views/Layout/footer.php'; ?>