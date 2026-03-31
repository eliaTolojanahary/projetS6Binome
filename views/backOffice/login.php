<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Login - BackOffice</title>
</head>
<body>
    <h1>Connexion Admin</h1>
    <?php if (isset($error)): ?>
        <p style="color: red;"><?php echo htmlspecialchars($error); ?></p>
    <?php endif; ?>
    <form action="/admin/login" method="POST">
        <div>
            <label>Nom d'utilisateur:</label>
            <input type="text" name="nom" required>
        </div>
        <div>
            <label>Mot de passe:</label>
            <input type="password" name="mot_de_passe" required>
        </div>
        <button type="submit">Se connecter</button>
    </form>
</body>
</html>