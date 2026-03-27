<?php
namespace app\controllers\frontOffice;

use app\models\frontOffice\ArticleModel;
use Flight;

class ArticleController {
    // Affiche les N derniers articles
    public function index() {
        $n = 5;
        $articleModel = new ArticleModel();
        $articles = $articleModel->getLastNArticles($n);
        Flight::render('articles', ['articles' => $articles]);
    }
}
