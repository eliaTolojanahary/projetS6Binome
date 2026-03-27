<?php
// app/models/frontOffice/ArticleModel.php

namespace app\models\frontOffice;

use PDO;
use PDOException;
use Flight;

class ArticleModel {
    public function __construct() {
        $this->db = Flight::db();
    }
        public function getLastNArticles($n) {
                $stmt = $this->db->prepare('SELECT id, titre, image FROM articles ORDER BY date_publication DESC LIMIT :n');
                $stmt->bindValue(':n', (int)$n, PDO::PARAM_INT);
                $stmt->execute();
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
}
