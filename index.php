

<?php
session_start();

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

$uri = rtrim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');
if ($uri === '') $uri = '/';

if (strpos($uri, '/admin') === 0) {
    require_once __DIR__ . '/controllers/backOffice/AuthController.php';
    require_once __DIR__ . '/models/backOffice/AuthModel.php';
  
    if ($uri === '/admin') {
        if (empty($_SESSION['admin'])) {
            header('Location: /admin/login');
            exit;
        }
        
        require __DIR__ . '/views/backOffice/admin.php';
        exit;
    }
   
    if ($uri === '/admin/login' && $_SERVER['REQUEST_METHOD'] === 'GET') {
        $auth = new \app\controllers\backOffice\AuthController($pdo);
        $auth->loginForm();
        exit;
    }
  
    if ($uri === '/admin/login' && $_SERVER['REQUEST_METHOD'] === 'POST') {
        $auth = new \app\controllers\backOffice\AuthController($pdo);
        $auth->login();
        exit;
    }
    
    if ($uri === '/admin/logout') {
        $auth = new \app\controllers\backOffice\AuthController($pdo);
        $auth->logout();
        exit;
    }
    // 404 back office
    http_response_code(404);
    echo '<h1>404 - Page admin non trouvée</h1>';
    exit;
}


require_once __DIR__ . '/controllers/frontOffice/ArticleController.php';
require_once __DIR__ . '/models/frontOffice/ArticleModel.php';
$controller = new \controllers\frontOffice\ArticleController($pdo);

switch (true) {
    case ($uri === '/'):
        $controller->index();
        exit;
    case preg_match('#^/article/(\d+)-([a-zA-Z0-9\-]+)$#', $uri, $m):
        $controller->show((int)$m[1]);
        exit;
    default:
        http_response_code(404);
        echo '<h1>404 - Page non trouvée</h1>';
        exit;
}