<?php
namespace controllers\backOffice;

use models\backOffice\AdminArticleModel;

class AdminArticleController {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $this->checkAuth();
    }

    private function checkAuth() {
        if (!isset($_SESSION['admin_id'])) {
            header('Location: /admin/login');
            exit;
        }
    }

    public function index() {
        $model = new AdminArticleModel($this->pdo);
        $articles = $model->getAllArticles();
        require __DIR__ . '/../../views/backOffice/listArticle.php';
    }

    public function create() {
        require __DIR__ . '/../../views/backOffice/formArticle.php';
    }

    public function store() {
        $model = new AdminArticleModel($this->pdo);
        $data = $_POST;
        if (empty($data['slug']) && !empty($data['titre'])) {
            $data['slug'] = $this->slugify($data['titre']);
        }
        $model->create($data);
        header('Location: /admin/articles');
        exit;
    }

    public function edit($id) {
        $model = new AdminArticleModel($this->pdo);
        $article = $model->getArticleById($id);
        if (!$article) {
            header('Location: /admin/articles');
            exit;
        }
        require __DIR__ . '/../../views/backOffice/formArticle.php';
    }

    public function update($id) {
        $model = new AdminArticleModel($this->pdo);
        $data = $_POST;
        if (empty($data['slug']) && !empty($data['titre'])) {
            $data['slug'] = $this->slugify($data['titre']);
        }
        $model->update($id, $data);
        header('Location: /admin/articles');
        exit;
    }

    public function delete($id) {
        $model = new AdminArticleModel($this->pdo);
        $model->delete($id);
        header('Location: /admin/articles');
        exit;
    }

    private function slugify($text) {
        $text = strtolower($text);
        $text = preg_replace('/[^a-z0-9\s-]/u', '', $text);
        $text = preg_replace('/[\s-]+/', '-', $text);
        $text = trim($text, '-');
        return $text;
    }
}