<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Accueil - GuerreNews | Conflit Iran</title>
    <meta name="description" content="Suivez les dernières actualités, analyses et images du conflit en Iran et au Moyen-Orient sur GuerreNews. Articles, dossiers, opinions, et plus.">
    <link rel="stylesheet" href="/assets/css/frontOffice/frontoffice-home.css">
</head>
<body>
<nav class="main-menu">
    <div class="menu-container">
        <a href="/" class="menu-logo">GuerreNews</a>
        <ul class="menu-links">
            <li><a href="/">Accueil</a></li>
            <li><a href="/categorie/international">International</a></li>
            <li><a href="/categorie/moyen-orient">Moyen-Orient</a></li>
            <li><a href="/categorie/diplomatie">Diplomatie</a></li>
            <li><a href="/categorie/humanitaire">Humanitaire</a></li>
            <li><a href="/categorie/economie">Économie</a></li>
        </ul>
        <form class="search-bar" onsubmit="return false;">
            <input type="text" id="searchInput" placeholder="Rechercher un article..." autocomplete="off">
        </form>
    </div>
</nav>
<main class="main-news" role="main">
    <h1>Guerre en Iran : nouvelles et analyses</h1>
    <p class="subtitle">Suivez les dernières actualités, analyses et images du conflit au Moyen-Orient</p>
    <section class="news-feed" id="newsFeed">
        <?php if (isset($articles) && !empty($articles)): ?>
            <?php foreach ($articles as $article): ?>
                <article class="news-article" data-title="<?= htmlspecialchars(strtolower($article['titre'])) ?>" data-chapeau="<?= !empty($article['chapeau']) ? htmlspecialchars(strtolower($article['chapeau'])) : '' ?>">
                    <?php if (!empty($article['image_url'])): ?>
                        <img class="news-img" src="<?= htmlspecialchars($article['image_url']) ?>" alt="<?= htmlspecialchars($article['titre']) ?>" fetchpriority="high">
                    <?php endif; ?>
                    <div class="news-content">
                        <span class="news-time">
                            <?php if (!empty($article['publie_le'])): ?>
                                <?= date('d/m/Y H:i', strtotime($article['publie_le'])) ?>
                            <?php endif; ?>
                        </span>
                        <div class="news-title">
                            <a href="/article/<?= urlencode($article['id']) ?>-<?= urlencode($article['slug']) ?>" style="color:inherit;text-decoration:none;">
                                <h2><?= htmlspecialchars($article['titre']) ?></h2>
                            </a>
                        </div>
                        <?php if (!empty($article['chapeau'])): ?>
                            <p><strong><?= htmlspecialchars($article['chapeau']) ?></strong></p>
                        <?php endif; ?>
                    </div>
                </article>
            <?php endforeach; ?>
        <?php else: ?>
            <p>Aucun article trouvé</p>
        <?php endif; ?>
    </section>
</main>
<script>

const searchInput = document.getElementById('searchInput');
const newsFeed = document.getElementById('newsFeed');
if (searchInput && newsFeed) {
    searchInput.addEventListener('input', function() {
        const query = this.value.trim().toLowerCase();
        const articles = newsFeed.querySelectorAll('.news-article');
        articles.forEach(article => {
            const title = article.getAttribute('data-title');
            const chapeau = article.getAttribute('data-chapeau');
            if (title.includes(query) || chapeau.includes(query)) {
                article.style.display = '';
            } else {
                article.style.display = 'none';
            }
        });
    });
}
</script>
</body>
</html>
    
</style>
</body>
</html>
