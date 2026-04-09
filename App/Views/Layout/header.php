<?php
// ================= CSRF TOKEN =================
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
?>
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
        border-top: 1px solid rgba(0,0,0,0.06);
    }
    /* ======================
   FOOTER LINKS (FIX STYLE)
====================== */
.footer-link {
    color: #6c757d;         /* même gris élégant */
    text-decoration: none;  /* enlève le soulignement */
    display: inline-flex;
    align-items: center;
    gap: 6px;
    transition: color 0.2s ease;
}

.footer-link:hover {
    color: #157347;         /* même vert que la sidebar */
    text-decoration: none;
}

    </style>
</head>

<body>

<!-- ======================
     SIDEBAR
====================== -->
<aside class="sidebar">

    <div class="brand">
        <i class="bi bi-box-seam-fill"></i>
        StockApp
    </div>

    <nav>

        <a href="index.php?action=home"
           class="<?= ($_GET['action'] ?? 'home') === 'home' ? 'active' : '' ?>">
            <i class="bi bi-house-door"></i>
            Accueil
        </a>

        <?php if (in_array($_SESSION['user']['role_name'], ['admin','responsable_stock','magasinier'])): ?>
            <a href="index.php?action=products"
               class="<?= ($_GET['action'] ?? '') === 'products' ? 'active' : '' ?>">
                <i class="bi bi-box-seam"></i>
                Produits
            </a>
        <?php endif; ?>

        <?php if (in_array($_SESSION['user']['role_name'], ['admin','responsable_stock'])): ?>
            <a href="index.php?action=categories"
               class="<?= ($_GET['action'] ?? '') === 'categories' ? 'active' : '' ?>">
                <i class="bi bi-tags"></i>
                Catégories
            </a>
        <?php endif; ?>

        <?php if (in_array($_SESSION['user']['role_name'], ['admin','vendeur','caissier'])): ?>
            <a href="index.php?action=sales"
               class="<?= ($_GET['action'] ?? '') === 'sales' ? 'active' : '' ?>">
                <i class="bi bi-cash-coin"></i>
                Vente
            </a>

            <a href="index.php?action=customer"
               class="<?= ($_GET['action'] ?? '') === 'customer' ? 'active' : '' ?>">
                <i class="bi bi-person-lines-fill"></i>
                Clients
            </a>
        <?php endif; ?>

        <!-- ✅ SUPPLIER AJOUTÉ ICI (SANS RIEN CASSER) -->
        <?php if (in_array($_SESSION['user']['role_name'], ['admin','responsable_stock'])): ?>
            <a href="index.php?action=supplier"
               class="<?= ($_GET['action'] ?? '') === 'supplier' ? 'active' : '' ?>">
                <i class="bi bi-truck"></i>
                Fournisseurs
            </a>
        <?php endif; ?>

        <?php if ($_SESSION['user']['role_name'] === 'admin'): ?>
            <a href="index.php?action=users"
               class="<?= ($_GET['action'] ?? '') === 'users' ? 'active' : '' ?>">
                <i class="bi bi-people"></i>
                Utilisateurs
            </a>
        <?php endif; ?>

        <!-- ---------- PROFIL / PARAMÈTRES (TOUS LES USERS) ---------- -->
        <a href="index.php?action=profile"
            class="<?= in_array(($_GET['action'] ?? ''), ['profile','profile-update','profile-password']) ? 'active' : '' ?>">
            <i class="bi bi-gear"></i>
                Paramètres
        </a>

        
        <!-- ---------- JOURNAL (ADMIN UNIQUEMENT) ---------- -->
        <?php if ($_SESSION['user']['role_name'] === 'admin'): ?>
            <a href="index.php?action=logs"
               class="<?= ($_GET['action'] ?? '') === 'logs' ? 'active' : '' ?>">
                <i class="bi bi-list-check"></i>
                Journal
            </a>
        <?php endif; ?>



    </nav>

    <div class="sidebar-footer">
        <div>
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