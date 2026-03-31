<?php
namespace models\backOffice;

class AdminModel {
    private $db;

    public function __construct(\PDO $pdo) {
        $this->db = $pdo;
    }

    public function getAdminByNom($nom) {
        $stmt = $this->db->prepare('SELECT * FROM admins WHERE nom = :nom LIMIT 1');
        $stmt->bindValue(':nom', $nom, \PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }
}