<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title><?= !empty($article['titre']) ? htmlspecialchars($article['titre']) . ' | GuerreNews' : 'Détail de l\'article' ?></title>
    <meta name="description" content="<?= !empty($article['chapeau']) ? htmlspecialchars($article['chapeau']) : 'Détail et analyse d\'un article sur GuerreNews.' ?>">
    <link rel="stylesheet" href="/assets/css/frontOffice/frontoffice-article.css">
</head>
<body>
<main class="article-detail" role="main">
    <a href="/" class="back-link">&larr; Retour à l'accueil</a>
    <?php if (isset($article) && !empty($article)): ?>
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
            <?php
                $imgSrc = (strpos($article['image_url'], 'http') === 0 ? htmlspecialchars($article['image_url']) : '/' . ltrim(htmlspecialchars($article['image_url']), '/'));
                $imgWebp = preg_replace('/\.(jpg|jpeg|png)$/i', '.webp', $imgSrc);
                $webpPath = $_SERVER['DOCUMENT_ROOT'] . parse_url($imgWebp, PHP_URL_PATH);
                $showWebp = file_exists($webpPath);
            ?>
            <?php if ($showWebp): ?>
                <picture>
                    <source srcset="<?= $imgWebp ?>" type="image/webp">
                    <img src="<?= $imgWebp ?>" alt="<?= htmlspecialchars($article['titre']) ?>" width="569" height="320" style="max-width:100%;height:auto;" fetchpriority="high">
                </picture>
            <?php else: ?>
                <img src="<?= $imgSrc ?>" alt="<?= htmlspecialchars($article['titre']) ?>" width="569" height="320" style="max-width:100%;height:auto;" fetchpriority="high">
            <?php endif; ?>
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
</main>
</body>
</html>
