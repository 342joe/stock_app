<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>StockApp</title>

    <!-- Bootstrap CSS -->
    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
    >

    <!-- Google Font -->
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap"
        rel="stylesheet"
    >

    <!-- Bootstrap Icons -->
    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css"
    >

    <style>
    /* ======================
       GLOBAL
    ====================== */
    body {
        margin: 0;
        background: #e9f7ef;
        font-family: 'Inter', system-ui, sans-serif;
    }

    /* ======================
       SIDEBAR
    ====================== */
    .sidebar {
        width: 260px;
        min-height: 100vh;
        background: #157347;
        color: #fff;
        position: fixed;
        top: 0;
        left: 0;
        padding: 24px 18px;
        display: flex;
        flex-direction: column;
        z-index: 1000;
    }

    .sidebar .brand {
        font-size: 18px;
        font-weight: 600;
        margin-bottom: 30px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .sidebar nav a {
        color: #cde9da;
        text-decoration: none;
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 10px 14px;
        border-radius: 8px;
        margin-bottom: 6px;
        font-size: 14px;
        transition: all 0.2s ease;
    }

    .sidebar nav a:hover,
    .sidebar nav a.active {
        background: rgba(255,255,255,0.15);
        color: #fff;
    }

    .sidebar-footer {
        margin-top: auto;
        padding-top: 20px;
        border-top: 1px solid rgba(255,255,255,0.15);
        font-size: 13px;
        color: #cde9da;
    }

    .sidebar-footer a {
        color: #fff;
        text-decoration: none;
        display: flex;
        align-items: center;
        gap: 8px;
        margin-top: 10px;
        font-weight: 500;
    }

    .sidebar-footer a:hover {
        text-decoration: underline;
    }

    /* ======================
       MAIN CONTENT
    ====================== */
    .content-wrapper {
        margin-left: 260px;
        min-height: calc(100vh - 120px);
        padding: 40px 0;
    }

    /* ======================
       SAAS CARD
    ====================== */
    .saas-card {
        background: #fff;
        border-radius: 14px;
        padding: 28px;
        box-shadow: 0 10px 25px rgba(0,0,0,0.08);
    }

    /* ======================
       TABLE
    ====================== */
    .table thead th {
        font-size: 13px;
        color: #6c757d;
        border-bottom: none;
    }

    .table tbody tr:hover {
        background: #f8fdfb;
    }

    /* ======================
       FOOTER
    ====================== */
    .app-footer {
        margin-left: 260px;
        padding: 18px 40px;
        background: transparent;
        border-top: 1px solid rgba(0,0,0,0.06);
    }

    .footer-link {
        color: #6c757d;
        text-decoration: none;
        transition: color 0.2s ease;
    }

    .footer-link:hover {
        color: #157347;
    }
    </style>
</head>

<body>

<!-- ======================
     SIDEBAR
====================== -->
<aside class="sidebar">

    <!-- BRAND -->
    <div class="brand">
        <i class="bi bi-box-seam-fill"></i>
        StockApp
    </div>

    <!-- NAVIGATION -->
    <nav>

        <!-- ACCUEIL : TOUS -->
        <a href="index.php?action=home"
           class="<?= ($_GET['action'] ?? 'home') === 'home' ? 'active' : '' ?>">
            <i class="bi bi-house-door"></i>
            Accueil
        </a>

        <!-- PRODUITS : admin / responsable_stock / magasinier -->
        <?php if (in_array($_SESSION['user']['role_name'], ['admin', 'responsable_stock', 'magasinier'])): ?>
            <a href="index.php?action=products"
               class="<?= ($_GET['action'] ?? '') === 'products' ? 'active' : '' ?>">
                <i class="bi bi-box-seam"></i>
                Produits
            </a>
        <?php endif; ?>

        <!-- CATEGORIES : admin / responsable_stock -->
        <?php if (in_array($_SESSION['user']['role_name'], ['admin', 'responsable_stock'])): ?>
            <a href="index.php?action=categories"
               class="<?= ($_GET['action'] ?? '') === 'categories' ? 'active' : '' ?>">
                <i class="bi bi-tags"></i>
                Catégories
            </a>
        <?php endif; ?>

        <!-- VENTE : admin / vendeur / caissier -->
        <?php if (in_array($_SESSION['user']['role_name'], ['admin', 'vendeur', 'caissier'])): ?>
            <a href="index.php?action=sales"
               class="<?= ($_GET['action'] ?? '') === 'sales' ? 'active' : '' ?>">
                <i class="bi bi-cash-coin"></i>
                Vente
            </a>
        <?php endif; ?>

        <!-- UTILISATEURS : admin -->
        <?php if ($_SESSION['user']['role_name'] === 'admin'): ?>
            <a href="index.php?action=users"
               class="<?= ($_GET['action'] ?? '') === 'users' ? 'active' : '' ?>">
                <i class="bi bi-people"></i>
                Utilisateurs
            </a>
        <?php endif; ?>

    </nav>

    <!-- FOOTER SIDEBAR -->
    <div class="sidebar-footer">
        <div class="mb-1">
            Connecté en tant que<br>
            <strong><?= htmlspecialchars($_SESSION['user']['name']) ?></strong>
        </div>

        <a href="index.php?action=logout">
            <i class="bi bi-box-arrow-right"></i>
            Déconnexion
        </a>
    </div>

</aside>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
