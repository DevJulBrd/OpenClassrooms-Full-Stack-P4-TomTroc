-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost
-- Généré le : ven. 21 nov. 2025 à 14:20
-- Version du serveur : 10.4.28-MariaDB
-- Version de PHP : 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `P4-Tom-Troc`
--

-- --------------------------------------------------------

--
-- Structure de la table `books`
--

CREATE TABLE `books` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `author` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `image_path` varchar(255) NOT NULL,
  `status` enum('available','reserved','unavailable') NOT NULL DEFAULT 'available',
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `books`
--

INSERT INTO `books` (`id`, `user_id`, `title`, `author`, `description`, `image_path`, `status`, `created_at`, `updated_at`) VALUES
(4, 1, '1984', 'George Orwell', '1984 est communément considéré comme une référence du roman d\'anticipation, de la dystopie, voire de la science-fiction en général. La principale figure du roman, Big Brother, est devenue une figure métaphorique du régime policier et totalitaire, de la société de la surveillance, ainsi que de la réduction des libertés.', 'https://static.wixstatic.com/media/2f8927_7d0b96e1219a4f69850d09ff2012b894~mv2.jpg/v1/fill/w_136,h_209,al_c,q_80,usm_0.66_1.00_0.01,enc_avif,quality_auto/George%20Orwell.jpg', 'available', '2025-10-14 22:27:05', '2025-10-14 22:27:05'),
(5, 1, 'Ne tirez pas sur l\'oiseau moqueur', 'Harper Lee', 'Un roman qui tient à la fois de la fiction mêlée d\'éléments biographiques et du roman d\'apprentissage, mais qui contient également les éléments d\'un thriller qui le rapprochent du roman policier. Prix Pulitzer, le chef-d\'oeuvre traite de l\'héroïsme d\'une homme face à une haine raciale aveugle et violente dans le sud des États-Unis.', 'https://static.wixstatic.com/media/2f8927_22c57bf25eea4c27a9e2a6f6ebd9249b~mv2.jpg/v1/fill/w_136,h_209,al_c,q_80,usm_0.66_1.00_0.01,enc_avif,quality_auto/Harper%20Lee.jpg', 'available', '2025-10-14 22:28:52', '2025-10-14 22:28:52'),
(6, 1, 'Le meilleur des mondes', 'Aldous Huxley', 'Ce tour de force d’Aldous Huxley est une vision sombre et satirique d’un avenir «utopique», et un puissant travail de fiction spéculative qui a captivé et terrorisé les lecteurs pendant des générations. Il reste remarquablement pertinent à ce jour, à la fois comme un avertissement à prendre en compte  et comme divertissement hautement stimulant.', 'https://static.wixstatic.com/media/2f8927_fc1cac0f6d4f47eca6db21441652acfc~mv2.jpg/v1/fill/w_136,h_209,al_c,q_80,usm_0.66_1.00_0.01,enc_avif,quality_auto/Aldous%20Huxley.jpg', 'available', '2025-10-14 22:28:52', '2025-10-14 22:28:52'),
(7, 1, 'La voleuse de livres', 'Markus Zusak', 'La Voleuse de livres a obtenu un succès international auprès du public comme des critiques, qui ont salué l\'aspect déconcertant du récit et les valeurs qu\'il défend contre la barbarie comme l\'importance des liens familiaux, l\'amitié, la solidarité humaine et la puissance des mots.', 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcR30BWE7XkdkLg5lLm1_dcgGYFWjQDPZo2KLZspGSK3teC4BqNksRnK_bYTYeQOeaLC09N96N382cWM01P6vIy8brwNcwoIY94L9bvUITWCpg&s=10', 'available', '2025-10-14 22:29:42', '2025-11-11 21:05:45'),
(8, 2, 'Le deuxième sexe', 'Simone de Beauvoir', '\r\nDans Le deuxième sexe de Simone de Beauvoir, les points de vue adoptés sur la femme seront discutés par la biologie, la psychanalyse, le matérialisme historique. Cet ouvrage tentera ensuite de montrer positivement comment la « réalité féminine » s\'est constituée, pourquoi la femme a été définie comme l\'Autre et quelles en ont été les conséquences du point de vue des hommes. Alors, il décrira du point de vue des femmes le monde tel qu\'il leur est proposé ; et nous permettra de comprendre à quelles difficultés sont heurtées les femmes, au moment où, essayant de s\'évader de la sphère qui leur a été jusqu\'à présent assignée, elles prétendent participer au mitsein humain.', 'https://back.decitre.fr/media/wysiwyg/Blog/2024/04-avril/le_deuxi_me_sexe.jpg', 'available', '2025-11-11 20:57:47', '2025-11-11 20:57:47'),
(9, 2, 'L\'écume des jours', 'Boris Vian', 'Un titre évoquant légèreté et éclat préface cette œuvre narrative, oscillant entre l\'humour et la mordacité, la douceur et la gravité, tout en captivant et marquant les esprits. Créé par un jeune auteur de vingt-six ans, le récit se déroule dans un univers où se mêlent l\'ère du jazz, la science-fiction, l\'humour et l\'émotion, le bonheur et la tragédie, ainsi que le merveilleux et le déchirement. Cette création audacieusement moderne, vénérée comme un classique depuis plus d\'un demi-siècle, entrelace les univers de Duke Ellington et des cartoons, transforme Sartre en une caricature de marionnette, et où la mort prend les traits d\'un nénuphar, plongeant le cauchemar dans les profondeurs du désespoir. Cependant, deux éléments ressortent comme éternels et victorieux : la joie indescriptible de l\'amour inconditionnel et la musique emblématique des Afro-Américains.', 'https://back.decitre.fr/media/wysiwyg/Blog/2024/04-avril/l_cume_des_jours.jpg', 'available', '2025-11-11 20:57:47', '2025-11-11 20:57:47'),
(10, 2, 'L\'insoutenable légèreté de l\'être', 'Milan Kundera', 'Que reste-t-il des souffrances au Cambodge ? Une photo imposante d\'une célébrité américaine serrant un enfant cambodgien dans ses bras. Et de Tomas ? Une épitaphe gravée : Il aspirait à instaurer le Royaume de Dieu sur Terre. Que demeure-t-il de Beethoven ? L\'image d\'un homme sombre, aux cheveux ébouriffés, murmurant d\'une voix grave : \"Es muss sein !\" (Cela doit être !). Et de Franz ? Un simple mot : Après une longue errance, le retour. Ainsi va la suite, invariablement. Avant que l\'oubli ne nous emporte, nous serons transformés en kitsch. Le kitsch, cet intermédiaire entre l\'existence et l\'effacement.', 'https://back.decitre.fr/media/wysiwyg/Blog/2024/04-avril/insoutenable_legerte_de_l_etre.jpg', 'available', '2025-11-11 20:57:47', '2025-11-11 20:57:47'),
(11, 2, 'La métamorphose', 'Frans Kafka', 'Un matin, après une nuit troublée par des rêves tumultueux, Gregor Samsa se réveilla pour découvrir qu\'il s\'était métamorphosé dans son lit en un gigantesque insecte. \"Que m\'est-il arrivé ? \", se demanda-t-il, réalisant que ce n\'était pas le fruit d\'un rêve. L\'idée de prolonger son sommeil pour échapper à cette absurdité lui traversa l\'esprit, mais c\'était peine perdue. Habitué à dormir sur le côté droit, il se trouva dans l\'impossibilité d\'adopter cette position avec sa nouvelle forme. Malgré tous ses efforts pour se retourner sur le côté, il finissait invariablement par retomber sur le dos.', 'https://back.decitre.fr/media/wysiwyg/Blog/2024/04-avril/la_metamorphose.jpg', 'available', '2025-11-11 20:57:47', '2025-11-11 20:57:47'),
(12, 3, 'L\'attrape-coeur', 'Jérôme David Salinger', 'Né dans une famille privilégiée de New York, Holden Caulfield se retrouve au pensionnat Pencey Prep en Pennsylvanie. Expulsé en fin de semestre pour avoir échoué dans quatre matières, il quitte l\'établissement plus tôt que prévu, se lançant dans une escapade de quelques jours. Ainsi, nous le suivons, devenant son complice et confident dans cette escapade marquée par une désobéissance juvénile. Malgré son aversion à partager \"toutes ces idioties\", il nous dévoile son histoire - pour notre plus grand plaisir, révélant un récit fascinant, une représentation emblématique de l\'Amérique post-Deuxième Guerre mondiale et l\'un des personnages les plus chéris de la littérature.\r\n\r\nHolden navigue entre les taxis, les clubs de jazz, et les rencontres avec les habitants d\'un New York glacé à l\'époque de McCarthy. La ville, tour à tour éclatante et déconcertante, reste inoubliable alors qu\'Holden tente d\'échapper aux \"imbéciles\" et de trouver sa propre voie. Lorsqu\'il envisage de s\'enfuir, seule Phoebe, sa jeune sœur et probablement sa seule véritable amie depuis la perte de son frère cadet, Allie, désire le rejoindre dans son aventure.', 'https://back.decitre.fr/media/wysiwyg/Blog/2024/04-avril/l_attrape_coeur.jpg', 'available', '2025-11-11 21:00:56', '2025-11-21 14:16:39'),
(13, 3, 'Sa majesté des mouches', 'William Golding', 'Un groupe de garçons âgés de six à douze ans se retrouve échoué sur une île déserte, montagneuse, ornée d\'arbres tropicaux et habitée par des animaux sauvages, suite à un naufrage. Ce qui commence comme une aventure exaltante, presque comme des vacances idylliques où l\'on se délecte de fruits, se baigne et joue à l\'aventurier, prend rapidement une tournure sérieuse. Inspirés par l\'esprit des écoles britanniques, ils procèdent à l\'élection d\'un chef : Ralph, assisté de Piggy, l\'\"intellectuel\" quelque peu dérisoire, et de Simon. Cependant, la situation dégénère lorsque un rival de Ralph prend le commandement d\'un groupe opposé, menant à un conflit si intense que Simon et Piggy perdent la vie. Ralph, quant à lui, ne doit sa survie qu\'à l\'intervention opportune des adultes.\r\n\r\nCe roman, au-delà de son récit captivant, porte une dimension allégorique évidente, illustrant de manière tragique l\'aventure des sociétés humaines à travers le prisme de l\'enfance. L\'intérêt majeur de l\'œuvre réside dans l\'exploration fine du comportement des enfants, enveloppée dans une atmosphère à la fois joyeuse, mystérieuse et terrifiante.', 'https://back.decitre.fr/media/wysiwyg/Blog/2024/04-avril/sa_majeste_des_mouches.jpg', 'available', '2025-11-11 21:00:56', '2025-11-11 21:00:56'),
(14, 3, 'Le chien des baskerville', 'Arthur Conan Doyle', 'Une sombre malédiction semble frapper la famille Baskerville, résidant dans l\'ancien manoir familial, isolé au cœur d\'une lande désolée. La légende raconte qu\'à l\'apparition d\'un monstrueux chien-démon, la mort n\'est pas loin. Le mystérieux et soudain décès de Sir Charles Baskerville, ainsi que les cris sinistres s\'élevant parfois du marais de Grimpen, semblent confirmer cette terrifiante tradition. À peine arrivé de Londres, en provenance du Canada, Sir Henry Baskerville, l\'unique successeur de Sir Charles, reçoit une lettre anonyme l\'avertissant : \"Pour votre propre sécurité et santé mentale, restez loin de la lande.\"\r\n\r\nEn dépit de cet avertissement, Sir Henry choisit de se diriger vers le manoir de Baskerville, épaulé par Sherlock Holmes et son fidèle assistant.\r\n\r\n', 'https://back.decitre.fr/media/wysiwyg/Blog/2024/04-avril/le_chien_des_baskerville.jpg', 'available', '2025-11-11 21:00:56', '2025-11-11 21:00:56'),
(15, 3, 'Le dahlia noir', 'James Ellroy', 'Le 15 janvier 1947, un corps coupé en deux à la taille est retrouvé sur un terrain inoccupé de Los Angeles, celui d\'Elizabeth Short, une jeune femme aspirant à devenir actrice et surnommée \"Le Dahlia Noir\" par le Los Angeles Herald Examiner, en raison de sa préférence pour les vêtements sombres. Ce meurtre non résolu demeure l\'un des mystères les plus notoires de l\'histoire criminelle américaine.', 'https://back.decitre.fr/media/wysiwyg/Blog/2024/04-avril/dahlia_noir.jpg', 'available', '2025-11-11 21:00:56', '2025-11-11 21:00:56'),
(16, 4, 'De sang froid', 'Truman Capote', 'En plein midi, au cœur du désert de Mojave, Perry était assis sur une valise de paille, jouant de l\'harmonica. Dick, quant à lui, se tenait au bord de l\'emblématique Route 66, scrutant le vide avec une telle intensité, comme s\'il pouvait matérialiser des véhicules par la force de son regard. Peu de voitures circulaient, et aucune ne marquait un arrêt pour les deux auto-stoppeurs. Ils guettaient un conducteur seul, au volant d\'un véhicule décent, avec un portefeuille bien rempli : une cible à dépouiller, étrangler, puis à laisser pour morte dans l\'immensité du désert.\r\n\r\n', 'https://back.decitre.fr/media/wysiwyg/Blog/2024/04-avril/de_sang_froid.jpg', 'available', '2025-11-11 21:04:10', '2025-11-11 21:04:10'),
(17, 4, 'In tenebris', 'Maxime Chattam', 'Nul ne traverse les ténèbres sans en être marqué. Les mots de Julia, retrouvée sans son cuir chevelu, déambulant dans les rues de Brooklyn, semblent n\'avoir de sens que pour elle-même. Elle prétend revenir des abysses de l\'Enfer, après avoir échappé au Diable. Et selon elle, elle n\'était pas la seule... Sous le manteau neigeux de New York, se cache une incandescence de souffrances, un autodafé d\'innocents. Le profileur Joshua Brolin comprend qu\'il doit s\'immerger dans cet enfer. Sans aucune illusion de rédemption.', 'https://back.decitre.fr/media/wysiwyg/Blog/2024/04-avril/in_tenebris.jpg', 'available', '2025-11-11 21:04:10', '2025-11-11 21:04:10'),
(18, 4, 'Jane Eyre', 'Charlotter Brontë', 'Orpheline dès son jeune âge, Jane Eyre trouve refuge chez M. Reed, son oncle. Suite au décès de celui-ci, sa tante la prend en grippe, la blâmant pour tous les maux. À l\'aube de ses dix ans, Mme Reed, déterminée à se séparer d\'elle pour de bon, expédie Jane dans un internat pour jeunes filles démunies. Là, Jane est confrontée aux dures leçons de la vie, enseignées avec sévérité.', 'https://back.decitre.fr/media/wysiwyg/Blog/2024/04-avril/jane_eyre.jpg', 'available', '2025-11-11 21:04:10', '2025-11-11 21:04:10'),
(19, 4, 'Orgueils et préjugés ', 'Jane Austen', 'Dans ce chef-d\'œuvre de Jane Austen, Elizabeth Bennet, dotée d\'un esprit vif et malicieux et issue d\'une famille modeste de la gentry anglaise, croise le chemin du distant Mr Darcy lors d\'un bal. Ce dernier, parmi les hommes les plus fortunés mais également les plus orgueilleux d\'Angleterre, suscite immédiatement son antipathie. Cependant, après avoir sous-estimé l\'attrait d\'Elizabeth, il se trouve épris d\'elle, entamant un combat intérieur entre les inclinations de son cœur et les exigences de sa position sociale.\r\n\r\nLeur parcours vers l\'amour sera-t-il entravé par leurs préjugés et leur fierté ? Publié en 1813, Jane Austen livre avec Orgueil et Préjugés une des plus belles histoires d\'amour de la littérature anglaise, incarnée par la pétillante Miss Elizabeth Bennet et le mystérieux Mr Darcy.\r\n\r\n', 'https://back.decitre.fr/media/wysiwyg/Blog/2024/04-avril/orgueil_pr_jug_s.jpg', 'available', '2025-11-11 21:04:10', '2025-11-11 21:04:10');

-- --------------------------------------------------------

--
-- Structure de la table `conversations`
--

CREATE TABLE `conversations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user1_id` bigint(20) UNSIGNED NOT NULL,
  `user2_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ;

--
-- Déchargement des données de la table `conversations`
--

INSERT INTO `conversations` (`id`, `user1_id`, `user2_id`, `created_at`, `updated_at`) VALUES
(1, 4, 1, '2025-10-30 10:34:58', '2025-11-10 21:19:35'),
(2, 4, 3, '2025-11-11 21:18:18', '2025-11-21 14:02:45'),
(4, 4, 2, '2025-11-21 13:49:30', '2025-11-21 13:56:21');

-- --------------------------------------------------------

--
-- Structure de la table `messages`
--

CREATE TABLE `messages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `conversation_id` bigint(20) UNSIGNED NOT NULL,
  `sender_id` bigint(20) UNSIGNED NOT NULL,
  `content` text NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `read_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `messages`
--

INSERT INTO `messages` (`id`, `conversation_id`, `sender_id`, `content`, `created_at`, `read_at`) VALUES
(1, 1, 4, 'J\'aime beaucoup ton livre.', '2025-10-30 14:33:15', '2025-10-31 11:03:52'),
(2, 1, 4, 'Message plus long pour voir comment rend le overflow sur la page inbox', '2025-10-30 14:46:38', '2025-10-31 11:03:52'),
(3, 1, 1, 'Oui c\'est un super livre, je te conseil de le lire tu ne serras pas déçu. Je peux te le poster dans la journée si tu es d\'accord. Je te laisse me joindre tes coordonnées.', '2025-10-31 11:15:49', '2025-10-31 11:21:48'),
(4, 1, 4, 'Super, merci pour ton conseil. C\'est vrai que ça fait un moment qu\'on me le recommande. Je peux venir le récupérer sur la place du marché demain à 18h30. Je t\'enverrai un message une fois sur place. A demain', '2025-10-31 11:23:26', '2025-11-04 13:28:14'),
(5, 1, 4, 'Salut !!', '2025-11-06 21:06:19', '2025-11-06 21:06:40'),
(7, 1, 1, 'Super la discussion !!', '2025-11-07 12:56:09', '2025-11-07 13:01:44'),
(8, 1, 4, 'Test count', '2025-11-07 13:02:18', '2025-11-07 13:02:59'),
(9, 1, 1, 'Pourquoi j\'ai eu un seul message qui ne prenait la taille qu\'il fallait ?? Très étrange, essayons avec celui là.', '2025-11-10 21:19:35', '2025-11-11 17:30:38'),
(10, 2, 4, 'Salut Marie, ce livre à l\'air génial. J\'aimerai bien te l\'emprunter si possible.', '2025-11-11 21:22:03', '2025-11-21 13:58:53'),
(11, 2, 4, 'Super on peut discuter', '2025-11-20 20:38:05', '2025-11-21 13:58:53'),
(12, 4, 4, 'Super une étape en plus !!!', '2025-11-21 13:56:21', NULL),
(13, 2, 4, 'Test', '2025-11-21 13:57:03', '2025-11-21 13:58:53'),
(14, 2, 3, 'Test', '2025-11-21 14:02:26', NULL),
(15, 2, 3, 'test', '2025-11-21 14:02:35', NULL),
(16, 2, 3, 'Test', '2025-11-21 14:02:45', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `email` varchar(255) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `username` varchar(60) NOT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `email`, `password_hash`, `username`, `image_url`, `created_at`) VALUES
(1, 'mjulien.bernard@icloud.com', '$2y$12$VH5600n//I1WdD/OnmD04.C/SNtxy0H9vHN4sgHnuGc0ciljbYWt2', 'JulBrd', NULL, '2025-10-14 21:32:08'),
(2, 'lucas.exemple@gmail.com', '$2y$12$G6xC3/wX6xBLEFZqD4IauehN7RAc5vWIucWqWAVv/gpRfIdMFP8L2', 'LucasBook', NULL, '2025-10-29 18:10:14'),
(3, 'marie.exemple@gmail.com', '$2y$12$Tzgx9DE4gHsl0jDCM93gV.aiNU28qxM2Lrgylsrt7XAaxNbgQyZeS', 'MariLivre', NULL, '2025-10-29 18:16:36'),
(4, 'victoir.exemple@icloud.com', '$2y$12$cY587G4tMPFzmo77gGU2/.k8xApYU8AwzSsTHBB5FMEuVViARdgHy', 'VicLivre', NULL, '2025-10-29 18:18:32'),
(5, 'test@gmail.com', '$2y$12$HqgbmH9hHbnIwOlvi00L/u.mrD.1hYMsQ7CSB/IdVrVnaTi9RWp66', 'Test', NULL, '2025-11-14 10:47:54');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `books`
--
ALTER TABLE `books`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_books_user` (`user_id`),
  ADD KEY `idx_books_status` (`status`),
  ADD KEY `idx_books_title` (`title`);

--
-- Index pour la table `conversations`
--
ALTER TABLE `conversations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_conv_user1` (`user1_id`),
  ADD KEY `fk_conv_user2` (`user2_id`);

--
-- Index pour la table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_msg_conv_created` (`conversation_id`,`created_at`),
  ADD KEY `idx_msg_sender` (`sender_id`),
  ADD KEY `idx_msg_read` (`read_at`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_users_email` (`email`),
  ADD UNIQUE KEY `uq_users_username` (`username`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `books`
--
ALTER TABLE `books`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT pour la table `conversations`
--
ALTER TABLE `conversations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `books`
--
ALTER TABLE `books`
  ADD CONSTRAINT `fk_books_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `conversations`
--
ALTER TABLE `conversations`
  ADD CONSTRAINT `fk_conv_user1` FOREIGN KEY (`user1_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_conv_user2` FOREIGN KEY (`user2_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `messages`
--
ALTER TABLE `messages`
  ADD CONSTRAINT `fk_msg_conv` FOREIGN KEY (`conversation_id`) REFERENCES `conversations` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_msg_sender` FOREIGN KEY (`sender_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
