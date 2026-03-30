<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion Admin</title>
    <link rel="stylesheet" href="/assets/css/backOffice/backoffice-admin.css">
</head>
<body>
    <div class="main-menu">
        <div class="menu-container">
            <a href="/admin/article/list" class="menu-logo">GuerreNews Admin</a>
        </div>
    </div>
    <div class="login-container">
        <h2>Connexion administrateur</h2>
        <?php if (!empty($error)): ?>
            <div class="error-message"> <?= htmlspecialchars($error) ?> </div>
        <?php endif; ?>
        <form method="post" class="login-form">
            <label for="username">Identifiant :</label>
            <input type="text" name="username" id="username" required autofocus><br>
            <label for="password">Mot de passe :</label>
            <input type="password" name="password" id="password" required><br>
            <button type="submit">Se connecter</button>
        </form>
    </div>
</body>
</html>
