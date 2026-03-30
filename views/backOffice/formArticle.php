<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title><?= isset($article) ? 'Modifier' : 'Créer' ?> un article</title>
    
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
    <h2 style="color:#0057a8;">
        <?= isset($article) ? 'Modifier' : 'Créer' ?> un article
    </h2>
    <?php if (!empty($error)): ?>
        <div class="error-message"> <?= htmlspecialchars($error) ?> </div>
    <?php endif; ?>
    <form method="post" action="<?= isset($article['id']) ? '/admin/article/update/' . $article['id'] : '/admin/article/store' ?>" enctype="multipart/form-data" class="form-admin-article" aria-label="Formulaire article">
        <div class="form-row">
            <label for="categorie_id">Catégorie :</label>
            <select name="categorie_id" id="categorie_id" required>
                <option value="">-- Choisir --</option>
                <?php foreach ($categories as $cat): ?>
                    <option value="<?= $cat['id'] ?>" <?= (($old['categorie_id'] ?? $article['categorie_id'] ?? '') == $cat['id']) ? 'selected' : '' ?>><?= htmlspecialchars($cat['nom']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-row">
            <label for="auteur_id">Auteur :</label>
            <select name="auteur_id" id="auteur_id" required>
                <option value="">-- Choisir --</option>
                <?php foreach ($auteurs as $a): ?>
                    <option value="<?= $a['id'] ?>" <?= (($old['auteur_id'] ?? $article['auteur_id'] ?? '') == $a['id']) ? 'selected' : '' ?>><?= htmlspecialchars($a['nom']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-row">
            <label for="titre">Titre :</label>
            <input type="text" name="titre" id="titre" required autofocus placeholder="Titre de l'article" value="<?= htmlspecialchars($old['titre'] ?? $article['titre'] ?? '') ?>">
        </div>
        <div class="form-row">
            <label for="chapeau">Chapeau :</label>
            <textarea name="chapeau" id="chapeau" rows="2" placeholder="Résumé court (optionnel)"><?= htmlspecialchars($old['chapeau'] ?? $article['chapeau'] ?? '') ?></textarea>
        </div>
        <div class="form-row">
            <label for="contenu">Contenu :</label>
            <textarea name="contenu" id="contenu" rows="6" required placeholder="Contenu principal de l'article..."><?= htmlspecialchars($old['contenu'] ?? $article['contenu'] ?? '') ?></textarea>
        </div>
        <div class="form-row">
            <label for="image_upload">Image :</label>
            <div style="display:flex;align-items:center;gap:18px;">
                <input type="file" name="image_upload" id="image_upload" accept="image/*" aria-label="Image de l'article">
                <?php $img = $old['image_url'] ?? $article['image_url'] ?? ''; ?>
                <?php if ($img): ?>
                    <img src="<?= htmlspecialchars($img) ?>" alt="aperçu image article" style="max-width:120px;max-height:80px;border-radius:6px;border:1.5px solid #b3c7e6;box-shadow:0 1px 4px #b3c7e6;">
                <?php endif; ?>
            </div>
            <input type="hidden" name="image_url" value="<?= htmlspecialchars($img) ?>">
        </div>
        <div class="form-row">
            <label for="image_alt">Texte alternatif image :</label>
            <input type="text" name="image_alt" id="image_alt" placeholder="Texte pour l'accessibilité" value="<?= htmlspecialchars($old['image_alt'] ?? $article['image_alt'] ?? '') ?>">
        </div>
        <div class="form-row">
            <label for="slug">Slug (URL) :</label>
            <input type="text" name="slug" id="slug" placeholder="ex: mon-article-2026" value="<?= htmlspecialchars($old['slug'] ?? $article['slug'] ?? '') ?>">
        </div>
        <div class="form-row">
            <label for="meta_title">Meta Title :</label>
            <input type="text" name="meta_title" id="meta_title" placeholder="Titre SEO (optionnel)" value="<?= htmlspecialchars($old['meta_title'] ?? $article['meta_title'] ?? '') ?>">
        </div>
        <div class="form-row">
            <label for="meta_description">Meta Description :</label>
            <textarea name="meta_description" id="meta_description" rows="2" placeholder="Description SEO (optionnel)"><?= htmlspecialchars($old['meta_description'] ?? $article['meta_description'] ?? '') ?></textarea>
        </div>
        <div class="form-row">
            <label for="statut">Statut :</label>
            <select name="statut" id="statut">
                <option value="brouillon" <?= (($old['statut'] ?? $article['statut'] ?? '') == 'brouillon') ? 'selected' : '' ?>>Brouillon</option>
                <option value="publie" <?= (($old['statut'] ?? $article['statut'] ?? '') == 'publie') ? 'selected' : '' ?>>Publié</option>
                <option value="archive" <?= (($old['statut'] ?? $article['statut'] ?? '') == 'archive') ? 'selected' : '' ?>>Archivé</option>
            </select>
        </div>
        <div class="form-row">
            <label for="publie_le">Date de publication :</label>
            <input type="datetime-local" name="publie_le" id="publie_le" value="<?= htmlspecialchars($old['publie_le'] ?? (isset($article['publie_le']) ? date('Y-m-d\TH:i', strtotime($article['publie_le'])) : '')) ?>">
        </div>
        <div style="display:flex;gap:18px;margin-top:18px;align-items:center;">
            <button type="submit" class="admin-btn">Enregistrer</button>
            <a href="/admin/article/list" class="admin-btn admin-btn-secondary">Retour à la liste</a>
        </div>
    </form>
    </div>
</body>
</html>
