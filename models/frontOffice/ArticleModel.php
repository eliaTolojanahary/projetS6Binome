<?php
namespace app\models\frontOffice;
include 'inc\db.php';

class ArticleModel {
    private $db;

        public function __construct(PDO $pdo) {
            $this->db = $pdo;
        }

        public static function slugify($text) {
                $text = strtolower($text);
                $text = preg_replace('/[^a-z0-9\s-]/u', '', $text);
                $text = preg_replace('/[\s-]+/', '-', $text);
                $text = trim($text, '-');
                return $text;
        }
        
        public function getLastNArticles($n) {
                $stmt = $this->db->prepare('SELECT id, titre, image_url FROM articles ORDER BY publie_le DESC LIMIT :n');
                $stmt->bindValue(':n', (int)$n, PDO::PARAM_INT);
                $stmt->execute();
                    $articles = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    foreach ($articles as &$article) {
                        if (!empty($article['image_url']) && strpos($article['image_url'], 'http') !== 0 && strpos($article['image_url'], '/assets/') !== 0) {
                            $article['image_url'] = '/assets/' . ltrim($article['image_url'], '/');
                        }
                    }
                    unset($article);
                    return $articles;
        }
        public function getArticleById($id) {
            $stmt = $this->db->prepare('SELECT a.*, au.nom AS auteur_nom FROM articles a JOIN auteurs au ON a.auteur_id = au.id WHERE a.id = :id LIMIT 1');
            $stmt->bindValue(':id', (int)$id, PDO::PARAM_INT);
            $stmt->execute();
            $article = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($article && !empty($article['image_url']) && strpos($article['image_url'], 'http') !== 0 && strpos($article['image_url'], '/assets/') !== 0) {
                $article['image_url'] = '/assets/' . ltrim($article['image_url'], '/');
            }
            return $article;
        }
        public function getLastNArticles($n) {
            $stmt = $this->db->prepare('SELECT id, titre, image_url, chapeau, publie_le FROM articles ORDER BY publie_le DESC LIMIT :n');
            $stmt->bindValue(':n', (int)$n, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
}
