<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion | StockApp</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">

    <style>
        body {
            height: 100vh;
            background: linear-gradient(135deg, #e9f7ef, #f6fbf8);
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Inter', system-ui, sans-serif;
        }

        .login-card {
            width: 380px;
            background: #ffffff;
            border-radius: 16px;
            padding: 32px 28px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.12);
        }

        .login-icon {
            width: 52px;
            height: 52px;
            background: #198754;
            color: #fff;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            margin: 0 auto 16px;
        }

        .login-title {
            font-weight: 600;
            text-align: center;
        }

        .login-subtitle {
            text-align: center;
            font-size: 14px;
            color: #6c757d;
            margin-bottom: 24px;
        }

        .form-control {
            border-radius: 10px;
            padding: 10px 12px;
        }

        .btn-login {
            border-radius: 10px;
            padding: 10px;
            font-weight: 600;
        }
    </style>
</head>
<body>

<div class="login-card">

    <div class="login-icon">🔐</div>

    <h5 class="login-title">Connexion</h5>
    <p class="login-subtitle">Accédez à votre espace StockApp</p>

    <?php if (isset($_GET['error'])): ?>
        <div class="alert alert-danger text-center py-2">
            Email ou mot de passe incorrect
        </div>
    <?php endif; ?>

    <form action="index.php?action=login-auth" method="POST">

        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-control" placeholder="ex: user@email.com" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Mot de passe</label>
            <input type="password" name="password" class="form-control" placeholder="••••••••" required>
        </div>

        <button class="btn btn-success w-100 btn-login">
            Se connecter
        </button>

    </form>

</div>

</body>
</html>