<footer class="app-footer">
    <div class="container-fluid">
        <div class="row gy-3 align-items-start">

            <!-- Brand / Description -->
            <div class="col-md-4">
                <h6 class="fw-semibold mb-1">
                    <i class="bi bi-box-seam-fill"></i>
                    StockApp
                </h6>
                <p class="text-muted small mb-0">
                    Système moderne de gestion de stock.<br>
                    Développé avec PHP &amp; Bootstrap.
                </p>
            </div>

            <!-- Navigation -->
            <div class="col-md-4">
                <h6 class="fw-semibold mb-1">Navigation</h6>
                <ul class="list-unstyled small mb-0">
                    <li>
                        <a href="index.php?action=products" class="footer-link">
                            <i class="bi bi-box-seam"></i>
                            Produits
                        </a>
                    </li>
                    <li>
                        <a href="index.php?action=categories" class="footer-link">
                            <i class="bi bi-tags"></i>
                            Catégories
                        </a>
                    </li>
                    <li>
                        <a href="index.php?action=users" class="footer-link">
                            <i class="bi bi-people"></i>
                            Utilisateurs
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Contact -->
            <div class="col-md-4">
                <h6 class="fw-semibold mb-1">Contact</h6>
                <p class="small text-muted mb-1">
                    <i class="bi bi-telephone"></i>
                    +243 972 397 473
                </p>
                <p class="small text-muted mb-1">
                    <i class="bi bi-envelope"></i>
                    jonathan.swedi@graaentreprises.com
                </p>
                <p class="small text-muted mb-0">
                    <i class="bi bi-geo-alt"></i>
                    Lubumbashi, RDC
                </p>
            </div>

        </div>

        <hr class="my-3">

        <div class="text-center small text-muted">
            © <?= date('Y') ?> <strong>StockApp</strong> — Tous droits réservés
        </div>
    </div>
</footer>

</body>
</html>
