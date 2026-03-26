-- ===============================
-- SCRIPT DE REINITIALISATION
-- ===============================
SET FOREIGN_KEY_CHECKS = 0;
DROP TABLE IF EXISTS articles_tags;
DROP TABLE IF EXISTS articles;
DROP TABLE IF EXISTS admins;
DROP TABLE IF EXISTS auteurs;
DROP TABLE IF EXISTS tags;
DROP TABLE IF EXISTS categories;
SET FOREIGN_KEY_CHECKS = 1;

CREATE DATABASE IF NOT EXISTS guerreNews
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

USE guerreNews;

-- ============================================================
-- TABLE : categories
-- Sert à filtrer et à créer des URLs SEO /categorie/{slug}
-- ============================================================
CREATE TABLE categories (
  id          INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  nom         VARCHAR(100)  NOT NULL,
  slug        VARCHAR(120)  NOT NULL UNIQUE,   -- ex: international
  description VARCHAR(255)  DEFAULT NULL,
  created_at  DATETIME      DEFAULT CURRENT_TIMESTAMP
);


-- ============================================================
-- TABLE : tags
-- Mots-clés SEO associés aux articles (relation N:N)
-- ============================================================
CREATE TABLE tags (
  id    INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  nom   VARCHAR(80)  NOT NULL,
  slug  VARCHAR(100) NOT NULL UNIQUE    -- ex: guerre-iran
);

CREATE TABLE auteurs (
  id        INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  nom       VARCHAR(100) NOT NULL,
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE admins (
  id            INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  nom           VARCHAR(100) NOT NULL,
  mot_de_passe  VARCHAR(255) NOT NULL,           
  created_at    DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- ============================================================
-- TABLE : articles  (cœur du projet)
-- Champs SEO : slug, meta_title, meta_description, h1
-- ============================================================
CREATE TABLE articles (
  id               INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  categorie_id     INT UNSIGNED NOT NULL,
  auteur_id        INT UNSIGNED NOT NULL,

  -- Contenu éditorial
  titre            VARCHAR(200) NOT NULL,
  chapeau          TEXT         DEFAULT NULL,   -- résumé visible FO
  contenu          LONGTEXT     NOT NULL,

  -- Image principale
  image_url        VARCHAR(300) DEFAULT NULL,
  image_alt        VARCHAR(200) DEFAULT NULL,   -- SEO : balise alt

  -- SEO / URL
  slug             VARCHAR(220) NOT NULL UNIQUE,       -- /article/{id}-{slug}
  meta_title       VARCHAR(70)  DEFAULT NULL,          -- <title>
  meta_description VARCHAR(160) DEFAULT NULL,          -- <meta description>

  -- Dates & statut
  statut           ENUM('brouillon','publie','archive') DEFAULT 'brouillon',
  publie_le        DATETIME     DEFAULT NULL,
  created_at       DATETIME     DEFAULT CURRENT_TIMESTAMP,
  updated_at       DATETIME     DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

  -- Index pour performances et SEO
  INDEX idx_slug        (slug),
  INDEX idx_statut      (statut),
  INDEX idx_publie_le   (publie_le),
  INDEX idx_categorie   (categorie_id),

  FOREIGN KEY (categorie_id) REFERENCES categories(id) ON DELETE RESTRICT,
  FOREIGN KEY (auteur_id)    REFERENCES auteurs(id)    ON DELETE RESTRICT
);

-- ============================================================
-- TABLE PIVOT : articles_tags  (N:N)
-- ============================================================
CREATE TABLE articles_tags (
  article_id INT UNSIGNED NOT NULL,
  tag_id     INT UNSIGNED NOT NULL,
  PRIMARY KEY (article_id, tag_id),
  FOREIGN KEY (article_id) REFERENCES articles(id) ON DELETE CASCADE,
  FOREIGN KEY (tag_id)     REFERENCES tags(id)     ON DELETE CASCADE
);

-- ============================================================
-- ============================================================
--  DONNÉES DE TEST  (basées sur l'actualité réelle du 27/03/2026)
-- ============================================================
-- ============================================================
-- ---- Auteurs supplémentaires ----
INSERT INTO auteurs (nom) VALUES
('Sophie Martin'),
('Jean Dupont'),
('Fatemeh Rahimi'),
('David Cohen'),
('Leila Benali'),
('Olivier Girard'),
('Sara Haddad'),
('Mohammad Rezaei');

-- ---- Catégories ----
INSERT INTO categories (nom, slug, description) VALUES
('International',    'international',    'Actualités géopolitiques mondiales'),
('Moyen-Orient',     'moyen-orient',     'Conflits et diplomatie au Moyen-Orient'),
('Diplomatie',       'diplomatie',       'Négociations, sommets et relations internationales'),
('Humanitaire',      'humanitaire',      'Crises humanitaires et droits de l\'homme'),
('Économie',         'economie',         'Impact économique des conflits sur les marchés');

-- ---- Tags SEO ----
INSERT INTO tags (nom, slug) VALUES
('Guerre en Iran',           'guerre-iran'),
('Israël',                   'israel'),
('États-Unis',               'etats-unis'),
('G7',                       'g7'),
('Détroit d\'Ormuz',          'detroit-ormuz'),
('Frappes aériennes',        'frappes-aeriennes'),
('Civils',                   'civils'),
('Hezbollah',                'hezbollah'),
('Liban',                    'liban'),
('Donald Trump',             'donald-trump'),
('Marco Rubio',              'marco-rubio'),
('Gardiens de la Révolution','gardiens-revolution'),
('ONU',                      'onu'),
('CICR',                     'cicr'),
('Téhéran',                  'teheran'),
('Négociations de paix',     'negociations-paix'),
('Opération Fureur Épique',  'operation-fureur-epique'),
('Pétrole',                  'petrole'),
('Koweït',                   'koweit'),
('Bahreïn',                  'bahrein');

-- ---- Admins ----
-- Mot de passe par défaut : "admin123" (hash bcrypt illustratif)
INSERT INTO admins (nom, mot_de_passe) VALUES
('Admin', 'admin123');

-- ---- Articles ----
INSERT INTO articles
  (categorie_id, auteur_id, titre, chapeau, contenu, image_url, image_alt,
   slug, meta_title, meta_description, statut, publie_le)
VALUES

-- ── ARTICLE 1 ──────────────────────────────────────────────
(
  2, 2,
  'G7 : appel commun à un arrêt immédiat des attaques contre les civils en Iran',
  'Réunis à l\'Abbaye des Vaux-de-Cernay près de Paris, les ministres des Affaires étrangères du G7 ont adopté une déclaration exigeant la fin des frappes sur les populations et les infrastructures civiles iraniennes.',
  '<p>Vendredi 27 mars 2026, les ministres des Affaires étrangères du G7 — réunis sous la présidence française à l\'Abbaye des Vaux-de-Cernay, à une cinquantaine de kilomètres de Paris — ont adopté un communiqué commun exhortant à « un arrêt immédiat des attaques contre les populations et les infrastructures civiles » en Iran.</p>\n<h2>La liberté de navigation au cœur du sommet</h2>\n<p>Les sept pays ont également réaffirmé la nécessité absolue de « rétablir de manière permanente la liberté de navigation gratuite et sûre dans le détroit d\'Ormuz », bloqué depuis le début du conflit par les forces iraniennes. Le secrétaire d\'État américain Marco Rubio, présent à la réunion, a déclaré que les États-Unis « prévoyaient la fin des opérations en Iran dans les deux prochaines semaines ».</p>\n<h2>Position américaine nuancée</h2>\n<p>M. Rubio a par ailleurs affirmé que l\'Iran avait transmis des « messages » mais qu\'aucune réponse formelle n\'avait été reçue concernant le plan de paix américain en quinze points. Il a insisté sur le fait que les États-Unis pouvaient encore atteindre leurs objectifs sans envoyer de troupes au sol.</p>\n<h2>Bilan humain du conflit</h2>\n<p>Depuis le début de l\'Opération Fureur Épique, lancée conjointement par les États-Unis et Israël le 28 février 2026, plus de 3 300 personnes — dont environ 1 400 civils — auraient été tuées en Iran selon l\'ONG Human Rights Activists in Iran (HRANA). Du côté américain, 303 militaires ont été blessés et 13 soldats tués.</p>',
  'img/g7-vaux-cernay-2026.jpg',
  'Ministres des Affaires étrangères du G7 réunis à l\'Abbaye des Vaux-de-Cernay, mars 2026',
  'g7-arret-attaques-civils-iran-27-mars-2026',
  'G7 demande l\'arrêt des attaques civiles en Iran – 27 mars 2026',
  'Le G7 réuni près de Paris appelle à cesser immédiatement les frappes sur les civils et les infrastructures en Iran, et à rouvrir le détroit d\'Ormuz.',
  'publie',
  '2026-03-27 09:00:00'
),

-- ── ARTICLE 2 ──────────────────────────────────────────────
(
  2, 2,
  'Chronologie du conflit : un mois de guerre entre l\'Iran, Israël et les États-Unis',
  'Retour sur les événements majeurs qui ont marqué le premier mois de l\'Opération Fureur Épique, du début des frappes à la situation actuelle.',
  '<h2>1er mars 2026 : ouverture du front libanais</h2>\n<p>Le Hezbollah lance des attaques depuis le Liban contre Israël, poussant Tsahal à lancer des bombardements sur le territoire libanais. Le même jour, l\'Iran ferme de facto le détroit d\'Ormuz, perturbant immédiatement les livraisons mondiales de pétrole et de gaz.</p>\n<h2>8 mars 2026 : nouveau Guide suprême iranien</h2>\n<p>Mojtaba Khamenei est officiellement désigné comme troisième Guide suprême de la République islamique, dix jours après la mort de son père Ali Khamenei, tué dès le premier jour du conflit lors d\'une opération conjointe américano-israélienne.</p>\n<h2>Fin mars : négociations en impasse</h2>\n<p>Le 25 mars, Téhéran rejette le plan en quinze points présenté par Washington. Le chef de la diplomatie iranienne Abbas Araghchi déclare que l\'Iran n\'a « pas l\'intention de négocier » et compte « continuer à résister ». Donald Trump repousse au 6 avril son ultimatum menaçant de frapper les centrales électriques iraniennes.</p>',
  'img/chronologie-conflit-iran-2026.jpg',
  'Carte du Moyen-Orient montrant les zones de conflit en mars 2026',
  'chronologie-conflit-iran-israel-usa-mars-2026',
  'Chronologie du conflit Iran-Israël-États-Unis – mars 2026',
  'Un mois de guerre au Moyen-Orient : revivez les événements clés du conflit entre l\'Iran, Israël et les États-Unis.',
  'publie',
  '2026-03-27 11:00:00'
),

-- ── ARTICLE 3 ──────────────────────────────────────────────
(
  4, 2,
  'CICR : les frappes sur les infrastructures civiles en Iran sont "inacceptables"',
  'La présidente de la Croix-Rouge internationale alerte sur la destruction des infrastructures vitales en Iran et appelle toutes les parties à respecter le droit international humanitaire.',
  '<p>La présidente du Comité international de la Croix-Rouge (CICR), Mirjana Spoljaric, a exigé « l\'arrêt immédiat des attaques contre les infrastructures vitales » en Iran. Dans un entretien accordé à Euronews, elle a souligné que la population civile porte « le plus lourd fardeau de l\'escalade ».</p>\n<h2>Eau, énergie, santé : tout est visé</h2>\n<p>À Téhéran, l\'approvisionnement en eau et en énergie est désormais fortement endommagé. Israël a bombardé l\'un des principaux champs gaziers iraniens, South Pars, tandis que l\'Iran a frappé en représailles Ras Laffan au Qatar, le plus grand port de GNL au monde. La réparation des deux installations pourrait prendre plusieurs années.</p>\n<h2>L\'ONU tire la sonnette d\'alarme</h2>\n<p>Le secrétaire général de l\'ONU Antonio Guterres a qualifié la guerre de « hors de contrôle » et a mis en garde contre un conflit encore « plus large » qui risque de provoquer une « marée de souffrance humaine ». Il a appelé le Hezbollah à cesser ses attaques contre Israël et Israël à stopper ses opérations militaires au Liban.</p>',
  'img/cicr-iran-infrastructures-civiles.jpg',
  'Bâtiment résidentiel détruit à Tabriz, nord de l\'Iran, 24 mars 2026',
  'cicr-frappes-infrastructures-civiles-iran-inacceptables',
  'CICR : les attaques sur les civils en Iran sont "inacceptables"',
  'La Croix-Rouge internationale dénonce la destruction des infrastructures vitales en Iran (eau, énergie, santé) et appelle à un cessez-le-feu immédiat.',
  'publie',
  '2026-03-27 10:30:00'
),

-- ── ARTICLE 4 ──────────────────────────────────────────────
(
  5, 2,
  'Détroit d\'Ormuz bloqué : les marchés pétroliers et gaziers sous pression mondiale',
  'La fermeture de fait du détroit d\'Ormuz par l\'Iran depuis le 28 février perturbe profondément les livraisons mondiales d\'énergie et fait flamber les prix du plastique et des carburants.',
  '<p>Le détroit d\'Ormuz, par lequel transitent environ 20 % des exportations mondiales de pétrole, est bloqué depuis le début du conflit le 28 février 2026. Cette fermeture de fait par l\'Iran provoque une perturbation immédiate et durable des marchés énergétiques mondiaux.</p>\n<h2>Conséquences industrielles</h2>\n<p>La guerre au Moyen-Orient fait flamber les prix du plastique et menace de nombreuses industries dépendantes des produits pétrochimiques. Les compagnies d\'assurance ont suspendu ou renchéri drastiquement les couvertures pour les navires transitant dans la région du Golfe.</p>\n<h2>Qatar et South Pars : un double coup dur</h2>\n<p>La frappe israélienne sur le champ gazier iranien de South Pars et la riposte iranienne sur le terminal de GNL de Ras Laffan au Qatar ont créé une double perturbation majeure pour le gaz naturel liquéfié mondial. Les experts estiment que la réparation de ces installations pourrait nécessiter plusieurs années.</p>\n<h2>Coalition internationale pour rouvrir le détroit</h2>\n<p>Les chefs d\'état-major des armées de 35 pays se sont réunis lors d\'une visioconférence organisée par la France pour mettre sur pied une coalition destinée à « contribuer à la reprise de la navigation dans le détroit d\'Ormuz après la cessation des combats ».</p>',
  'img/detroit-ormuz-petrolier-2026.jpg',
  'Pétrolier dans le détroit d\'Ormuz, point de passage névralgique du commerce mondial de pétrole',
  'detroit-ormuz-bloque-marches-petrole-gaz-2026',
  'Détroit d\'Ormuz bloqué : crise énergétique mondiale en 2026',
  'La fermeture du détroit d\'Ormuz par l\'Iran provoque une crise énergétique mondiale, avec une flambée des prix du pétrole, du gaz et du plastique.',
  'publie',
  '2026-03-26 15:00:00'
),

-- ── ARTICLE 5 ──────────────────────────────────────────────
(
  3, 2,
  'Négociations Iran-États-Unis : le plan de paix en 15 points rejeté par Téhéran',
  'L\'Iran a officiellement rejeté le 25 mars la proposition américaine en quinze points. Donald Trump repousse son ultimatum et maintient la pression diplomatique tout en continuant les frappes.',
  '<p>Le 25 mars 2026, le régime iranien a rejeté le plan en quinze points présenté par l\'administration Trump pour mettre fin à la guerre. Le chef de la diplomatie iranienne Abbas Araghchi a déclaré que l\'Iran n\'avait « pas l\'intention de négocier » et comptait « continuer à résister » pour mettre fin au conflit selon ses propres conditions.</p>\n<h2>Le double jeu de Trump</h2>\n<p>Donald Trump entretient volontairement le flou sur ses objectifs : le président américain a évoqué des négociations « très bonnes et fructueuses » tout en menaçant de « déchaîner l\'enfer » si l\'Iran ne capitulait pas. La Maison Blanche a affirmé que Trump s\'assurerait que l\'Iran soit « frappé de manière plus dure qu\'il ne l\'a jamais été » en cas de refus.</p>\n<h2>L\'ultimatum repoussé au 6 avril</h2>\n<p>Initialement fixé à 48 heures pour la réouverture du détroit d\'Ormuz, puis repoussé à cinq jours, l\'ultimatum américain ciblant les centrales électriques iraniennes a finalement été décalé au 6 avril 2026 par Donald Trump, laissant une fenêtre diplomatique étroite.</p>\n<h2>Rubio : la fin dans « deux semaines »</h2>\n<p>Marco Rubio a affirmé après le G7 que les États-Unis prévoyaient la fin des opérations militaires en Iran dans « les deux prochaines semaines », une déclaration à prendre avec précaution au vu des multiples revirements depuis le début du conflit.</p>',
  'img/trump-rubio-iran-negociations-2026.jpg',
  'Marco Rubio, secrétaire d\'État américain, à l\'aéroport du Bourget le 27 mars 2026',
  'negociations-iran-usa-plan-paix-15-points-rejete-2026',
  'Iran refuse le plan de paix américain en 15 points – mars 2026',
  'Téhéran rejette la proposition de paix de Washington. Trump repousse son ultimatum au 6 avril et maintient la pression militaire sur l\'Iran.',
  'publie',
  '2026-03-26 18:00:00'
),

-- ── ARTICLE 6 ──────────────────────────────────────────────
(
  2, 2,
  'Bilan du conflit en Iran : plus de 3 000 morts, 303 militaires américains blessés',
  'Après un mois de guerre, le bilan humain du conflit entre les États-Unis, Israël et l\'Iran ne cesse de s\'alourdir. Tour d\'horizon des pertes des deux camps.',
  '<p>Depuis le début de l\'Opération Fureur Épique le 28 février 2026, le conflit a causé des pertes considérables des deux côtés. Selon l\'ONG américaine Human Rights Activists in Iran (HRANA), plus de 3 300 personnes — dont environ 1 400 civils — auraient été tuées en Iran par les frappes américano-israéliennes.</p>\n<h2>Pertes américaines</h2>\n<p>Du côté américain, 303 militaires ont été blessés depuis le début des opérations. La grande majorité de ces blessures sont qualifiées de légères : 273 soldats ont pu reprendre du service. Dix restent gravement blessés. Treize soldats américains ont perdu la vie au total.</p>\n<h2>Front libanais</h2>\n<p>Au Liban, les bombardements israéliens ont causé plus de 1 000 victimes. Une frappe israélienne sur le village de Sir el-Gharbiyeh a tué au moins 19 personnes, dont des enfants. L\'armée israélienne a également perdu deux soldats lors d\'affrontements avec le Hezbollah dans le sud du pays.</p>\n<h2>Pays du Golfe</h2>\n<p>Les frappes iraniennes de représailles ont touché de nombreux pays du Golfe : à Bahreïn, une attaque de drone dans la région de Sitra a fait 32 blessés civils dont plusieurs enfants. Aux Émirats arabes unis, deux personnes ont été tuées par des débris de missiles à Abou Dhabi.</p>',
  'img/bilan-victimes-guerre-iran-2026.jpg',
  'Opérations de secours dans les décombres d\'un immeuble touché au Liban, mars 2026',
  'bilan-humain-guerre-iran-mars-2026-victimes',
  'Bilan humain de la guerre en Iran : +3 000 morts en un mois',
  'Plus de 3 300 morts en Iran, 303 blessés américains, 1 000 victimes au Liban : le bilan complet de la guerre en Iran après un mois de combats.',
  'publie',
  '2026-03-27 08:00:00'
);

INSERT INTO articles_tags (article_id, tag_id) VALUES
-- Article 1 – G7
(1,1),(1,3),(1,4),(1,5),(1,6),(1,7),(1,11),
-- Article 2 – Chronologie
(2,1),(2,2),(2,3),(2,6),(2,8),(2,9),(2,10),(2,15),(2,17),
-- Article 3 – CICR
(3,1),(3,7),(3,13),(3,14),(3,15),
-- Article 4 – Ormuz / Énergie
(4,1),(4,5),(4,18),(4,19),(4,20),
-- Article 5 – Négociations
(5,1),(5,3),(5,10),(5,11),(5,16),
-- Article 6 – Bilan humain
(6,1),(6,2),(6,3),(6,7),(6,8),(6,9),(6,17);