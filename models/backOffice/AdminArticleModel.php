<?php
namespace models\backOffice;

class AdminArticleModel {
    private $db;

    public function __construct(\PDO $pdo) {
        $this->db = $pdo;
    }

    public function getAllArticles() {
        $stmt = $this->db->query('SELECT * FROM articles ORDER BY id DESC');
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getArticleById($id) {
        $stmt = $this->db->prepare('SELECT * FROM articles WHERE id = :id LIMIT 1');
        $stmt->bindValue(':id', (int)$id, \PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function create($data) {
        $stmt = $this->db->prepare('INSERT INTO articles (categorie_id, auteur_id, titre, chapeau, contenu, image_url, image_alt, slug, meta_title, meta_description, statut) VALUES (:categorie_id, :auteur_id, :titre, :chapeau, :contenu, :image_url, :image_alt, :slug, :meta_title, :meta_description, :statut)');
        return $stmt->execute([
            ':categorie_id' => $data['categorie_id'] ?? 1,
            ':auteur_id' => $data['auteur_id'] ?? 1,
            ':titre' => $data['titre'],
            ':chapeau' => $data['chapeau'] ?? null,
            ':contenu' => $data['contenu'],
            ':image_url' => $data['image_url'] ?? null,
            ':image_alt' => $data['image_alt'] ?? null,
            ':slug' => $data['slug'],
            ':meta_title' => $data['meta_title'] ?? null,
            ':meta_description' => $data['meta_description'] ?? null,
            ':statut' => $data['statut'] ?? 'brouillon'
        ]);
    }

    public function update($id, $data) {
        $stmt = $this->db->prepare('UPDATE articles SET categorie_id=:categorie_id, auteur_id=:auteur_id, titre=:titre, chapeau=:chapeau, contenu=:contenu, image_url=:image_url, image_alt=:image_alt, slug=:slug, meta_title=:meta_title, meta_description=:meta_description, statut=:statut WHERE id=:id');
        return $stmt->execute([
            ':id' => $id,
            ':categorie_id' => $data['categorie_id'] ?? 1,
            ':auteur_id' => $data['auteur_id'] ?? 1,
            ':titre' => $data['titre'],
            ':chapeau' => $data['chapeau'] ?? null,
            ':contenu' => $data['contenu'],
            ':image_url' => $data['image_url'] ?? null,
            ':image_alt' => $data['image_alt'] ?? null,
            ':slug' => $data['slug'],
            ':meta_title' => $data['meta_title'] ?? null,
            ':meta_description' => $data['meta_description'] ?? null,
            ':statut' => $data['statut'] ?? 'brouillon'
        ]);
    }

    public function delete($id) {
        $stmt = $this->db->prepare('DELETE FROM articles WHERE id = :id');
        $stmt->bindValue(':id', (int)$id, \PDO::PARAM_INT);
        return $stmt->execute();
    }
}