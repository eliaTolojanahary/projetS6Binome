<?php
namespace models\frontOffice;
include 'inc/db.php';

class ArticleModel {
    private $db;

    public function __construct(\PDO $pdo) {
        $this->db = $pdo;
    }

    // Liste tous les articles (admin)
    public function getAllArticles() {
        $sql = 'SELECT a.*, c.nom AS categorie_nom, au.nom AS auteur_nom FROM articles a 
                LEFT JOIN categories c ON a.categorie_id = c.id 
                LEFT JOIN auteurs au ON a.auteur_id = au.id 
                ORDER BY a.publie_le DESC, a.id DESC';
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    // Filtrage dynamique (admin)
    public function getFilteredArticles($filters) {
        $where = [];
        $params = [];
        if (!empty($filters['categorie_id'])) {
            $where[] = 'a.categorie_id = :categorie_id';
            $params[':categorie_id'] = $filters['categorie_id'];
        }
        if (!empty($filters['statut'])) {
            $where[] = 'a.statut = :statut';
            $params[':statut'] = $filters['statut'];
        }
        if (!empty($filters['q'])) {
            $where[] = 'a.titre LIKE :q';
            $params[':q'] = '%' . $filters['q'] . '%';
        }
        $sql = 'SELECT a.*, c.nom AS categorie_nom, au.nom AS auteur_nom FROM articles a 
                LEFT JOIN categories c ON a.categorie_id = c.id 
                LEFT JOIN auteurs au ON a.auteur_id = au.id';
        if ($where) {
            $sql .= ' WHERE ' . implode(' AND ', $where);
        }
        $sql .= ' ORDER BY a.publie_le DESC, a.id DESC';
        $stmt = $this->db->prepare($sql);
        foreach ($params as $k => $v) {
            $stmt->bindValue($k, $v);
        }
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    // Création d'article (admin, avec upload image)
    public function createArticle($data) {
        $sql = 'INSERT INTO articles (categorie_id, auteur_id, titre, chapeau, contenu, image_url, image_alt, slug, meta_title, meta_description, statut, publie_le) 
                VALUES (:categorie_id, :auteur_id, :titre, :chapeau, :contenu, :image_url, :image_alt, :slug, :meta_title, :meta_description, :statut, :publie_le)';
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':categorie_id', $data['categorie_id']);
        $stmt->bindValue(':auteur_id', $data['auteur_id']);
        $stmt->bindValue(':titre', $data['titre']);
        $stmt->bindValue(':chapeau', $data['chapeau']);
        $stmt->bindValue(':contenu', $data['contenu']);
        $stmt->bindValue(':image_url', $data['image_url']);
        $stmt->bindValue(':image_alt', $data['image_alt']);
        $stmt->bindValue(':slug', $data['slug']);
        $stmt->bindValue(':meta_title', $data['meta_title']);
        $stmt->bindValue(':meta_description', $data['meta_description']);
        $stmt->bindValue(':statut', $data['statut']);
        $stmt->bindValue(':publie_le', $data['publie_le']);
        $stmt->execute();
        return $this->db->lastInsertId();
    }

    // Mise à jour d'article (admin, avec upload image)
    public function updateArticle($id, $data) {
        $sql = 'UPDATE articles SET categorie_id=:categorie_id, auteur_id=:auteur_id, titre=:titre, chapeau=:chapeau, contenu=:contenu, image_url=:image_url, image_alt=:image_alt, slug=:slug, meta_title=:meta_title, meta_description=:meta_description, statut=:statut, publie_le=:publie_le WHERE id=:id';
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':categorie_id', $data['categorie_id']);
        $stmt->bindValue(':auteur_id', $data['auteur_id']);
        $stmt->bindValue(':titre', $data['titre']);
        $stmt->bindValue(':chapeau', $data['chapeau']);
        $stmt->bindValue(':contenu', $data['contenu']);
        $stmt->bindValue(':image_url', $data['image_url']);
        $stmt->bindValue(':image_alt', $data['image_alt']);
        $stmt->bindValue(':slug', $data['slug']);
        $stmt->bindValue(':meta_title', $data['meta_title']);
        $stmt->bindValue(':meta_description', $data['meta_description']);
        $stmt->bindValue(':statut', $data['statut']);
        $stmt->bindValue(':publie_le', $data['publie_le']);
        $stmt->bindValue(':id', $id, \PDO::PARAM_INT);
        return $stmt->execute();
    }

    // Suppression d'article (admin)
    public function deleteArticle($id) {
        $stmt = $this->db->prepare('DELETE FROM articles WHERE id = :id');
        $stmt->bindValue(':id', $id, \PDO::PARAM_INT);
        return $stmt->execute();
    }

    // Gestion upload image (utilitaire)
    public static function handleImageUpload($file) {
        if (isset($file['tmp_name']) && $file['error'] === UPLOAD_ERR_OK) {
            $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
            $allowed = ['jpg','jpeg','png','gif','webp'];
            if (in_array($ext, $allowed)) {
                $newName = uniqid('img_', true) . '.' . $ext;
                $dest = '/assets/img/' . $newName;
                $fullPath = __DIR__ . '/../../assets/img/' . $newName;
                if (move_uploaded_file($file['tmp_name'], $fullPath)) {
                    return $dest;
                }
            }
        }
        return null;
    }

        public static function slugify($text) {
                $text = strtolower($text);
                $text = preg_replace('/[^a-z0-9\s-]/u', '', $text);
                $text = preg_replace('/[\s-]+/', '-', $text);
                $text = trim($text, '-');
                return $text;
        }
        
    
        public function getArticleById($id) {
            $stmt = $this->db->prepare('SELECT a.*, au.nom AS auteur_nom FROM articles a JOIN auteurs au ON a.auteur_id = au.id WHERE a.id = :id LIMIT 1');
            $stmt->bindValue(':id', (int)$id, \PDO::PARAM_INT);
            $stmt->execute();
            $article = $stmt->fetch(\PDO::FETCH_ASSOC);
            if ($article && !empty($article['image_url']) && strpos($article['image_url'], 'http') !== 0 && strpos($article['image_url'], '/assets/') !== 0) {
                $article['image_url'] = '/assets/' . ltrim($article['image_url'], '/');
            }
            return $article;
        }
        public function getLastNArticles($n) {
        $stmt = $this->db->prepare('SELECT id, titre, image_url, chapeau, publie_le FROM articles ORDER BY publie_le DESC LIMIT :n');
        $stmt->bindValue(':n', (int)$n, \PDO::PARAM_INT);
        $stmt->execute();
        $articles = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        foreach ($articles as &$article) {
            if (!empty($article['image_url'])) {
                if (strpos($article['image_url'], 'img/') === 0) {
                    $article['image_url'] = '/assets/' . $article['image_url'];
                } elseif (strpos($article['image_url'], '/assets/img/') !== 0 && strpos($article['image_url'], 'http') !== 0) {
                    $article['image_url'] = '/assets/img/' . ltrim($article['image_url'], '/');
                }
            }
        }
        unset($article);
        return $articles;
        }
}
