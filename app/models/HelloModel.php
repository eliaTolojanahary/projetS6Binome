<?php

namespace app\models;

use PDO;
use PDOException;
use Flight;

class HelloModel {
    protected $db;

    public function __construct() {
        $this->db = Flight::db();
    }

    // Récupérer toutes les annonces
    // public function getAll() {
    //     $stmt = $this->db->prepare("SELECT * FROM annonces ORDER BY date_publication DESC");
    //     $stmt->execute();
    //     return $stmt->fetchAll(PDO::FETCH_ASSOC);
    // }
    public function sayHello() {
        return 'hello';
    }
}
