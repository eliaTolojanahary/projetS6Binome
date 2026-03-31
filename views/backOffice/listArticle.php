<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Liste des Articles - BO</title>
</head>
<body>
    <h1>Liste des Articles</h1>
    <a href="/admin/article/create">Ajouter un article</a>
    <a href="/admin/logout">Déconnexion</a>
    <table border="1" cellpadding="5">
        <thead>
            <tr>
                <th>ID</th>
                <th>Titre</th>
                <th>Statut</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($articles as $article): ?>
                <tr>
                    <td><?php echo $article['id']; ?></td>
                    <td><?php echo htmlspecialchars($article['titre']); ?></td>
                    <td><?php echo htmlspecialchars($article['statut']); ?></td>
                    <td>
                        <a href="/admin/article/edit/<?php echo $article['id']; ?>">Éditer</a>
                        <form action="/admin/article/delete/<?php echo $article['id']; ?>" method="POST" style="display:inline;">
                            <button type="submit" onclick="return confirm('Êtes-vous sûr ?');">Supprimer</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>