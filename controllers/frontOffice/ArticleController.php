<?php
namespace app\controllers\frontOffice;

use app\models\frontOffice\ArticleModel;

class ArticleController {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function index() {
        $n = 5;
        $articleModel = new ArticleModel($this->pdo);
        $articles = $articleModel->getLastNArticles($n);
        foreach ($articles as &$article) {
            $article['slug'] = ArticleModel::slugify($article['titre']);
        }
        unset($article);
        require __DIR__ . '/../../views/frontOffice/index.php';
    }

    public function show($id) {
        $articleModel = new ArticleModel($this->pdo);
        $article = $articleModel->getArticleById($id);
        require __DIR__ . '/../../views/frontOffice/articles.php';
    }
}
