<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Liste des articles</title>
   
    <link rel="stylesheet" href="/assets/css/backOffice/backoffice-admin.css">
</head>
<body>
    <div class="main-menu">
        <div class="menu-container">
            <a href="/admin/article/list" class="menu-logo">GuerreNews Admin</a>
            <a href="/admin/login?logout=1" style="color:#fff;text-decoration:none;font-weight:500;">Déconnexion</a>
        </div>
    </div>
    <div class="article-detail" style="background:linear-gradient(135deg,#f7fafc 60%,#e3eaff 100%);box-shadow:0 8px 32px rgba(0,87,168,0.13);border:1.5px solid #0057a8;">
    <h2 style="color:#0057a8;">Articles</h2>
    <form method="get" class="admin-filters" id="admin-filters-form" autocomplete="off">
        <input type="hidden" name="r" value="admin/article/list">
        <label>Catégorie :
            <select name="categorie_id">
                <option value="">Toutes</option>
                <?php foreach ($categories as $cat): ?>
                    <option value="<?= $cat['id'] ?>" <?= (!empty($_GET['categorie_id']) && $_GET['categorie_id'] == $cat['id']) ? 'selected' : '' ?>><?= htmlspecialchars($cat['nom']) ?></option>
                <?php endforeach; ?>
            </select>
        </label>
        <label>Statut :
            <select name="statut">
                <option value="">Tous</option>
                <?php foreach ($statuts as $s): ?>
                    <option value="<?= $s ?>" <?= (!empty($_GET['statut']) && $_GET['statut'] == $s) ? 'selected' : '' ?>><?= ucfirst($s) ?></option>
                <?php endforeach; ?>
            </select>
        </label>
        <label>Recherche :
            <input type="text" name="q" value="<?= htmlspecialchars($_GET['q'] ?? '') ?>" placeholder="Titre...">
        </label>
        <!-- Pas de bouton filtrer, filtre dynamique -->
        <a href="/admin/article/list" class="admin-btn admin-btn-secondary">Réinitialiser</a>
    </form>
    <a href="/admin/article/create" class="admin-btn">Ajouter un article</a>
    <table class="admin-table">
        <tr>
            <th>Image</th>
            <th>Titre</th>
            <th>Catégorie</th>
            <th>Auteur</th>
            <th>Statut</th>
            <th>Date publication</th>
            <th>Actions</th>
        </tr>
        <?php foreach ($articles as $article): ?>
            <tr>
                <td>
                  <?php if (!empty($article['image_url'])): ?>
                    <img src="<?= htmlspecialchars($article['image_url']) ?>" alt="miniature" class="article-thumb" />
                  <?php endif; ?>
                </td>
                <td><?= htmlspecialchars($article['titre']) ?></td>
                <td><?= htmlspecialchars($article['categorie_nom'] ?? '') ?></td>
                <td><?= htmlspecialchars($article['auteur_nom'] ?? '') ?></td>
                <td><?= htmlspecialchars($article['statut']) ?></td>
                <td><?= htmlspecialchars($article['publie_le']) ?></td>
                <td class="actions">
                    <a href="/admin/article/edit/<?= $article['id'] ?>">Modifier</a>
                    <form method="post" action="/admin/article/delete/<?= $article['id'] ?>">
                        <button type="submit" onclick="return confirm('Supprimer cet article ?');">Supprimer</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
    </div>
</body>
</html>
<script>
// Filtre dynamique sans bouton
document.getElementById('admin-filters-form').addEventListener('input', function() {
    this.submit();
});
</script>
<script>
// Filtre dynamique sans bouton
document.getElementById('admin-filters-form').addEventListener('input', function() {
    this.submit();
});
</script>
