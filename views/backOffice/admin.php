<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>BackOffice - GuerreNews</title>
    <link rel="stylesheet" href="/assets/css/backOffice/backoffice-admin.css">
</head>
<body>
    <div class="main-menu">
        <div class="menu-container">
            <a href="/admin/article/list" class="menu-logo">GuerreNews Admin</a>
            <a href="/admin/login?logout=1" style="color:#fff;text-decoration:none;font-weight:500;">Déconnexion</a>
        </div>
    </div>
    <div class="article-detail" style="background:linear-gradient(135deg,#f7fafc 60%,#e3eaff 100%);box-shadow:0 8px 32px rgba(0,87,168,0.13);border:1.5px solid #0057a8;max-width:720px;">
        <h2 style="color:#0057a8;">Bienvenue dans le BackOffice</h2>
        <p>Utilisez le menu pour gérer les articles, catégories, auteurs, etc.</p>
        <a href="/admin/article/list" class="admin-btn">Voir la liste des articles</a>
        <a href="/admin/article/create" class="admin-btn admin-btn-secondary">Ajouter un article</a>
    </div>
</body>
</html>
