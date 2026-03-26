
-- ============================================================
-- VUE utilitaire : liste des articles publiés pour le FrontOffice
-- Utilisée par ArticleController::index()
-- ============================================================
CREATE OR REPLACE VIEW v_articles_fo AS
SELECT
  a.id,
  a.titre,
  a.chapeau,
  a.slug,
  a.image_url,
  a.image_alt,
  a.meta_title,
  a.meta_description,
  a.publie_le,
  c.nom    AS categorie_nom,
  c.slug   AS categorie_slug,
  au.nom   AS auteur_nom
FROM articles a
JOIN categories c  ON c.id  = a.categorie_id
JOIN auteurs    au ON au.id = a.auteur_id
WHERE a.statut = 'publie'
ORDER BY a.publie_le DESC;

