<?php
namespace app\models\backOffice;

class AuthModel {
   

    private $db;

    public function __construct(\PDO $pdo) {
        $this->db = $pdo;
    }

    public function checkLogin($username, $password) {
            $stmt = $this->db->prepare('SELECT * FROM admins WHERE username = :username AND password = :password LIMIT 1');
            $stmt->bindValue(':username', $username, \PDO::PARAM_STR);
            $stmt->bindValue(':password', $password, \PDO::PARAM_STR);
            $stmt->execute();
            $admin = $stmt->fetch(\PDO::FETCH_ASSOC);
            
            return $admin;
        }
    }

