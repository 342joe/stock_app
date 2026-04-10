<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Historique des ventes</title>
</head>
<body>

<h1>Historique des ventes</h1>

<?php if (empty($sales)): ?>
    <p>Aucune vente enregistrée.</p>
<?php else: ?>

<table border="1" cellpadding="8" cellspacing="0">
    <thead>
        <tr>
            <th>ID</th>
            <th>Date</th>
            <th>Produit</th>
            <th>Quantité</th>
            <th>Prix unitaire</th>
            <th>Vendeur</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($sales as $sale): ?>
            <tr>
                <td><?= htmlspecialchars($sale['id']) ?></td>
                <td><?= htmlspecialchars($sale['created_at']) ?></td>
                <td><?= htmlspecialchars($sale['product_name']) ?></td>
                <td><?= htmlspecialchars($sale['quantity']) ?></td>
                <td><?= htmlspecialchars($sale['price']) ?></td>
                <td><?= htmlspecialchars($sale['user_name']) ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php endif; ?>

</body>
</html>