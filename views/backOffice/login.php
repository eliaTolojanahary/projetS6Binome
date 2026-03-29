<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion Admin</title>
    <link rel="stylesheet" href="/assets/css/backOffice/login.css">
</head>
<body>
    <div class="login-container">
        <h1>Connexion Admin</h1>
        <?php if (!empty($error)): ?>
            <div class="error" style="color:red;"> <?= htmlspecialchars($error) ?> </div>
        <?php endif; ?>
        <form method="post" action="/admin/login">
            <label for="username">Utilisateur</label>
            <input type="text" name="username" id="username" required autofocus>
            <label for="password">Mot de passe</label>
            <input type="password" name="password" id="password" required>
            <button type="submit">Se connecter</button>
        </form>
    </div>
</body>
</html>
