<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title><?php echo isset($article) ? 'Éditer' : 'Ajouter'; ?> un Article</title>
    <!-- TinyMCE initialization -->
    <script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
    <script>
      tinymce.init({
        selector: '#contenu',
        plugins: 'lists link image code',
        toolbar: 'undo redo | formatselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | code'
      });
    </script>
</head>
<body>
    <h1><?php echo isset($article) ? 'Éditer Article' : 'Ajouter Article'; ?></h1>
    <a href="/admin/articles">Retour à la liste</a>
    <br><br>
    <form action="<?php echo isset($article) ? '/admin/article/edit/' . $article['id'] : '/admin/article/create'; ?>" method="POST">
        <div>
            <label>Titre:</label><br>
            <input type="text" name="titre" value="<?php echo htmlspecialchars($article['titre'] ?? ''); ?>" required style="width:100%;">
        </div>
        <br>
        <div>
            <label>Slug (URL) (Laisser vide pour auto-générer):</label><br>
            <input type="text" name="slug" value="<?php echo htmlspecialchars($article['slug'] ?? ''); ?>" style="width:100%;">
        </div>
        <br>
        <div>
            <label>Chapeau (résumé):</label><br>
            <textarea name="chapeau" rows="3" style="width:100%;"><?php echo htmlspecialchars($article['chapeau'] ?? ''); ?></textarea>
        </div>
        <br>
        <div>
            <label>Contenu:</label><br>
            <!-- L'éditeur TinyMCE va s'appliquer ici -->
            <textarea id="contenu" name="contenu" rows="15" style="width:100%;"><?php echo htmlspecialchars($article['contenu'] ?? ''); ?></textarea>
        </div>
        <br>
        <div>
            <label>Statut:</label><br>
            <select name="statut">
                <option value="brouillon" <?php echo (isset($article) && $article['statut'] === 'brouillon') ? 'selected' : ''; ?>>Brouillon</option>
                <option value="publie" <?php echo (isset($article) && $article['statut'] === 'publie') ? 'selected' : ''; ?>>Publié</option>
                <option value="archive" <?php echo (isset($article) && $article['statut'] === 'archive') ? 'selected' : ''; ?>>Archivé</option>
            </select>
        </div>
        
        <input type="hidden" name="categorie_id" value="<?php echo htmlspecialchars($article['categorie_id'] ?? '1'); ?>">
        <input type="hidden" name="auteur_id" value="<?php echo htmlspecialchars($article['auteur_id'] ?? '1'); ?>">
        
        <br><br>
        <button type="submit"><?php echo isset($article) ? 'Mettre à jour' : 'Enregistrer'; ?></button>
    </form>
</body>
</html>