<!-- app/views/frontOffice/articles.php -->
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Articles récents</title>
    <link rel="stylesheet" href="/css/sb-admin-2.min.css">
</head>
<body>
    <h1>Articles récents</h1>
    <div class="articles">
        <?php if (!empty($articles)): ?>
            <?php foreach ($articles as $article): ?>
                <div class="article">
                    <?php if (!empty($article['image_url'])): ?>
                        <img src="<?= htmlspecialchars($article['image_url']) ?>" alt="Image de l'article" style="max-width:200px;">
                    <?php endif; ?>
                    <h2><?= htmlspecialchars($article['titre']) ?></h2>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>Aucun article trouvé.</p>
        <?php endif; ?>
    </div>
</body>
</html>
