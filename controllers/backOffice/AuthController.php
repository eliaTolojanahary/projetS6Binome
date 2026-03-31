<?php
namespace controllers\backOffice;

use models\backOffice\AdminModel;

class AuthController {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    public function loginForm() {
        if (isset($_SESSION['admin_id'])) {
            header('Location: /admin/articles');
            exit;
        }
        require __DIR__ . '/../../views/backOffice/login.php';
    }

    public function login() {
        $nom = $_POST['nom'] ?? '';
        $mot_de_passe = $_POST['mot_de_passe'] ?? '';

        $adminModel = new AdminModel($this->pdo);
        $admin = $adminModel->getAdminByNom($nom);

        // Verification simple en texte clair (selon insertion DB d'exemple)
        if ($admin && $admin['mot_de_passe'] === $mot_de_passe) {
            $_SESSION['admin_id'] = $admin['id'];
            header('Location: /admin/articles');
            exit;
        }

        $error = "Identifiants invalides.";
        require __DIR__ . '/../../views/backOffice/login.php';
    }

    public function logout() {
        session_destroy();
        header('Location: /admin/login');
        exit;
    }
}