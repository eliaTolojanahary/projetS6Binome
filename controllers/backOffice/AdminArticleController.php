<?php
require_once __DIR__ . '/../../models/frontOffice/ArticleModel.php';

class AdminArticleController {
    private $pdo;
    private $articleModel;
    public function __construct($pdo) {
        $this->pdo = $pdo;
        $this->articleModel = new \models\frontOffice\ArticleModel($pdo);
    }
    private function getCategories() {
        $stmt = $this->pdo->query('SELECT id, nom FROM categories ORDER BY nom');
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    private function getAuteurs() {
        $stmt = $this->pdo->query('SELECT id, nom FROM auteurs ORDER BY nom');
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function create($error = '', $old = []) {
        $categories = $this->getCategories();
        $auteurs = $this->getAuteurs();
        include __DIR__ . '/../../views/backOffice/formArticle.php';
    }
    public function store() {
        $data = [
            'categorie_id' => $_POST['categorie_id'] ?? '',
            'auteur_id' => $_POST['auteur_id'] ?? '',
            'titre' => $_POST['titre'] ?? '',
            'chapeau' => $_POST['chapeau'] ?? '',
            'contenu' => $_POST['contenu'] ?? '',
            'image_url' => $_POST['image_url'] ?? '',
            'image_alt' => $_POST['image_alt'] ?? '',
            'slug' => $_POST['slug'] ?? '',
            'meta_title' => $_POST['meta_title'] ?? '',
            'meta_description' => $_POST['meta_description'] ?? '',
            'statut' => $_POST['statut'] ?? 'brouillon',
            'publie_le' => $_POST['publie_le'] ?? null
        ];
       
        if (isset($_FILES['image_upload']) && $_FILES['image_upload']['error'] === UPLOAD_ERR_OK) {
            $imgUrl = \models\frontOffice\ArticleModel::handleImageUpload($_FILES['image_upload']);
            if ($imgUrl) {
                $data['image_url'] = $imgUrl;
            }
        }
        $error = '';
        if (!$data['categorie_id'] || !$data['auteur_id'] || !$data['titre'] || !$data['contenu']) {
            $error = 'Les champs obligatoires doivent être remplis.';
            $this->create($error, $_POST);
            return;
        }
        
        $stmt = $this->pdo->prepare('SELECT id FROM articles WHERE slug = :slug LIMIT 1');
        $stmt->bindValue(':slug', $data['slug']);
        $stmt->execute();
        if ($stmt->fetch()) {
            $error = 'Ce slug est déjà utilisé par un autre article.';
            $this->create($error, $_POST);
            return;
        }
        $this->articleModel->createArticle($data);
        header('Location: /admin/article/list');
        exit();
    }
    public function edit($id, $error = '', $old = []) {
        $article = $this->articleModel->getArticleById($id);
        if (!$article) {
            http_response_code(404);
            echo 'Article introuvable';
            exit();
        }
        $categories = $this->getCategories();
        $auteurs = $this->getAuteurs();
        include __DIR__ . '/../../views/backOffice/formArticle.php';
    }
    public function update($id) {
        $data = [
            'categorie_id' => $_POST['categorie_id'] ?? '',
            'auteur_id' => $_POST['auteur_id'] ?? '',
            'titre' => $_POST['titre'] ?? '',
            'chapeau' => $_POST['chapeau'] ?? '',
            'contenu' => $_POST['contenu'] ?? '',
            'image_url' => $_POST['image_url'] ?? '',
            'image_alt' => $_POST['image_alt'] ?? '',
            'slug' => $_POST['slug'] ?? '',
            'meta_title' => $_POST['meta_title'] ?? '',
            'meta_description' => $_POST['meta_description'] ?? '',
            'statut' => $_POST['statut'] ?? 'brouillon',
            'publie_le' => $_POST['publie_le'] ?? null
        ];
        if (isset($_FILES['image_upload']) && $_FILES['image_upload']['error'] === UPLOAD_ERR_OK) {
            $imgUrl = \models\frontOffice\ArticleModel::handleImageUpload($_FILES['image_upload']);
            if ($imgUrl) {
                $data['image_url'] = $imgUrl;
            }
        }
        if (!$data['categorie_id'] || !$data['auteur_id'] || !$data['titre'] || !$data['contenu']) {
            $this->edit($id, 'Les champs obligatoires doivent être remplis.', $_POST);
            return;
        }
       
        $stmt = $this->pdo->prepare('SELECT id FROM articles WHERE slug = :slug AND id != :id LIMIT 1');
        $stmt->bindValue(':slug', $data['slug']);
        $stmt->bindValue(':id', $id, \PDO::PARAM_INT);
        $stmt->execute();
        if ($stmt->fetch()) {
            $this->edit($id, 'Ce slug est déjà utilisé par un autre article.', $_POST);
            return;
        }
        $this->articleModel->updateArticle($id, $data);
        header('Location: /admin/article/list');
        exit();
    }
    public function delete($id) {
        $this->articleModel->deleteArticle($id);
        header('Location: /admin/article/list');
        exit();
    }
    public function list() {
        $categories = $this->getCategories();
        $statuts = ['brouillon','publie','archive'];
        $filters = [
            'categorie_id' => $_GET['categorie_id'] ?? '',
            'statut' => $_GET['statut'] ?? '',
            'q' => $_GET['q'] ?? ''
        ];
        $articles = $this->articleModel->getFilteredArticles($filters);
        include __DIR__ . '/../../views/backOffice/listArticle.php';
    }
}
