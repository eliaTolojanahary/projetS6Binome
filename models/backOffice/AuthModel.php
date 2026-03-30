<?php
namespace app\models\backOffice;

class AuthModel {
   

    private $db;

    public function __construct(\PDO $pdo) {
        $this->db = $pdo;
    }

    public function checkLogin($username, $password) {
        $stmt = $this->db->prepare('SELECT * FROM admins WHERE nom = :nom AND mot_de_passe = :mot_de_passe LIMIT 1');
        $stmt->bindValue(':nom', $username, \PDO::PARAM_STR);
        $stmt->bindValue(':mot_de_passe', $password, \PDO::PARAM_STR);
        $stmt->execute();
        $admin = $stmt->fetch(\PDO::FETCH_ASSOC);
        return $admin;
    }
    }

