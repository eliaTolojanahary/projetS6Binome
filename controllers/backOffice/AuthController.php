<?php
namespace app\controllers\backOffice;

require_once __DIR__ . '/../../models/backOffice/AuthModel.php';

use app\models\backOffice\AuthModel;

class AuthController {
    private $pdo;
    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function loginForm() {
        require __DIR__ . '/../../views/backOffice/login.php';
    }

    public function login() {
        $model = new AuthModel($this->pdo);
        $error = null;
        if (!empty($_POST['username']) && !empty($_POST['password'])) {
            if ($model->checkLogin($_POST['username'], $_POST['password'])) {
                $_SESSION['admin'] = true;
                header('Location: /admin');
                exit;
            } else {
                $error = 'Identifiants invalides';
            }
        } else {
            $error = 'Veuillez remplir tous les champs';
        }
        require __DIR__ . '/../../views/backOffice/login.php';
    }

    public function logout() {
        unset($_SESSION['admin']);
        session_destroy();
        header('Location: /admin/login');
        exit;
    }
}
