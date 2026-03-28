<?php
namespace app\controllers\frontOffice;

use app\models\frontOffice\ArticleModel;
use Flight;

class ArticleController {
    public function index() {
        $n = 5;
        $articleModel = new ArticleModel();
        $articles = $articleModel->getLastNArticles($n);
        foreach ($articles as &$article) {
            $article['slug'] = isset($article['slug']) && $article['slug'] ? $article['slug'] : ArticleModel::slugify($article['titre']);
        }
        unset($article);
        Flight::render('frontOffice/index', ['articles' => $articles]);
    }
    public function show($id) {
        $articleModel = new ArticleModel();
        $article = $articleModel->getArticleById($id);
        Flight::render('frontOffice/articles', ['article' => $article]);
    }
}
