<?php
// app/models/frontOffice/ArticleModel.php

namespace app\models\frontOffice;

use PDO;
use PDOException;
use Flight;

class ArticleModel {
        public static function slugify($text) {
                $text = strtolower($text);
                $text = preg_replace('/[^a-z0-9\s-]/u', '', $text);
                $text = preg_replace('/[\s-]+/', '-', $text);
                $text = trim($text, '-');
                return $text;
        }
        
    public function __construct() {
        $this->db = Flight::db();
    }
        public function getLastNArticles($n) {
                $stmt = $this->db->prepare('SELECT id, titre, image_url FROM articles ORDER BY publie_le DESC LIMIT :n');
                $stmt->bindValue(':n', (int)$n, PDO::PARAM_INT);
                $stmt->execute();
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        public function getArticleById($id) {
            $stmt = $this->db->prepare('SELECT a.*, au.nom AS auteur_nom FROM articles a JOIN auteurs au ON a.auteur_id = au.id WHERE a.id = :id LIMIT 1');
            $stmt->bindValue(':id', (int)$id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }
}
