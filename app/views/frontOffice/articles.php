<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title><?= !empty($article['titre']) ? htmlspecialchars($article['titre']) . ' | GuerreNews' : 'Détail de l\'article' ?></title>
    <meta name="description" content="<?= !empty($article['chapeau']) ? htmlspecialchars($article['chapeau']) : 'Détail et analyse d\'un article sur GuerreNews.' ?>">
    <link rel="stylesheet" href="/css/frontoffice-article.css">
</head>
<body>
<div class="article-detail">
    <a href="/" class="back-link">&larr; Retour à l'accueil</a>
    <?php if (!empty($article)): ?>
        <h1><?= htmlspecialchars($article['titre']) ?></h1>
        <div class="meta">
            <?php if (!empty($article['publie_le'])): ?>
                Publié le <?= date('d/m/Y H:i', strtotime($article['publie_le'])) ?>
            <?php endif; ?>
            <?php if (!empty($article['auteur_nom'])): ?>
                | Par <?= htmlspecialchars($article['auteur_nom']) ?>
            <?php endif; ?>
        </div>
        <?php if (!empty($article['image_url'])): ?>
            <img src="<?= (strpos($article['image_url'], 'http') === 0 ? htmlspecialchars($article['image_url']) : '/' . ltrim(htmlspecialchars($article['image_url']), '/')) ?>" alt="<?= htmlspecialchars($article['titre']) ?>">
        <?php endif; ?>
        <?php if (!empty($article['chapeau'])): ?>
            <div class="chapeau"><h2><?= htmlspecialchars($article['chapeau']) ?></h2></div>
        <?php endif; ?>
        <div class="contenu">
            <?= $article['contenu'] ?>
        </div>
    <?php else: ?>
        <p>Article introuvable</p>
    <?php endif; ?>
</div>
</body>
</html>
