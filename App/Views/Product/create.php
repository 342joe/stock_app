<h2>Ajouter un Produit </h2>

<form action="index.php?action=product-store" method="POST">

    <label>Nom :</label><br>
    <input type="text" name="name" required><br><br>

    <label>Description :</label><br>
    <textarea name="description" required></textarea><br><br>

    <label>Prix de vente :</label><br>
    <input type="number" name="price" step="0.01" required><br><br>

    <label>Prix d'achat :</label><br>
    <input type="number" name="purchase_price" step="0.01" required><br><br>

    <label>Quantité :</label><br>
    <input type="number" name="quantity" required><br><br>

    <label>Barcode :</label><br>
    <input type="text" name="barcode" required><br><br>

    <label>ID Catégorie :</label><br>
    <input type="number" name="category_id" required><br><br>

    <label>Date de création :</label><br>
    <input type="datetime-local" name="created_at" required><br><br>

    <button type="submit">Créer </button>
</form>

<br>
<a href="index.php?action=products">Retour</a>