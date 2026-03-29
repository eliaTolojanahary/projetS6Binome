
<?php
require_once __DIR__ . '/controllers/frontOffice/ArticleController.php';
require_once __DIR__ . '/models/frontOffice/ArticleModel.php';
$config = require __DIR__ . '/inc/db.php';


try {
    $pdo = new PDO(
        'mysql:host='.$config['database']['host'].';dbname='.$config['database']['dbname'].';charset='.$config['database']['charset'],
        $config['database']['user'],
        $config['database']['password'],
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );
} catch (PDOException $e) {
    exit('Erreur connexion base : ' . $e->getMessage());
}

$controller = new ArticleController($pdo);
$uri = rtrim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');
if ($uri === '') $uri = '/';

switch (true) {
    case ($uri === '/'):
        $controller->index();
        break;
    case preg_match('#^/article/(\d+)-([a-zA-Z0-9\-]+)$#', $uri, $m):
        $controller->show((int)$m[1]);
        break;
    default:
        http_response_code(404);
        echo '<h1>404 - Page non trouvée</h1>';
}

http_response_code(404);
echo '<h1>404 - Page non trouvée</h1>';
exit;