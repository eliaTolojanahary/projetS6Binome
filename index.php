

<?php
use controllers\frontOffice\ArticleController;
use controllers\backOffice\AuthController;
use controllers\backOffice\AdminArticleController;

require_once __DIR__ . '/controllers/frontOffice/ArticleController.php';
require_once __DIR__ . '/models/frontOffice/ArticleModel.php';

require_once __DIR__ . '/controllers/backOffice/AuthController.php';
require_once __DIR__ . '/models/backOffice/AdminModel.php';

require_once __DIR__ . '/controllers/backOffice/AdminArticleController.php';
require_once __DIR__ . '/models/backOffice/AdminArticleModel.php';

$config = require __DIR__ . '/inc/db.php';

session_start();

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
$authController = new AuthController($pdo);
$adminArticleController = new AdminArticleController($pdo);

$uri = rtrim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');
if ($uri === '') $uri = '/';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    switch (true) {
        case ($uri === '/admin/login'):
            $authController->login();
            exit;
        case ($uri === '/admin/article/create'):
            $adminArticleController->store();
            exit;
        case preg_match('#^/admin/article/edit/(\d+)$#', $uri, $m):
            $adminArticleController->update((int)$m[1]);
            exit;
        case preg_match('#^/admin/article/delete/(\d+)$#', $uri, $m):
            $adminArticleController->delete((int)$m[1]);
            exit;
    }
}

switch (true) {
    case ($uri === '/'):
        $controller->index();
        exit;
    case preg_match('#^/article/(\d+)-([a-zA-Z0-9\-]+)$#', $uri, $m):
        $controller->show((int)$m[1]);
        exit;
    case ($uri === '/admin/login'):
        $authController->loginForm();
        exit;
    case ($uri === '/admin/logout'):
        $authController->logout();
        exit;
    case ($uri === '/admin/articles'):
        $adminArticleController->index();
        exit;
    case ($uri === '/admin/article/create'):
        $adminArticleController->create();
        exit;
    case preg_match('#^/admin/article/edit/(\d+)$#', $uri, $m):
        $adminArticleController->edit((int)$m[1]);
        exit;
    default:
        http_response_code(404);
        echo '<h1>404 - Page non trouvée</h1>';
        exit;
}