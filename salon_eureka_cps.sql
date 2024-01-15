-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost
-- Généré le : lun. 15 jan. 2024 à 15:06
-- Version du serveur : 5.7.11
-- Version de PHP : 7.2.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `salon_eureka_cps`
--

-- --------------------------------------------------------

--
-- Structure de la table `se_appartient`
--

CREATE TABLE `se_appartient` (
  `utilisateur_appartient` int(11) NOT NULL,
  `filiere_appartient` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `se_appartient`
--

INSERT INTO `se_appartient` (`utilisateur_appartient`, `filiere_appartient`) VALUES
(3, 1),
(4, 1),
(9, 1),
(14, 1),
(19, 1),
(24, 1),
(29, 1),
(5, 2),
(10, 2),
(15, 2),
(20, 2),
(25, 2),
(30, 2),
(6, 3),
(11, 3),
(16, 3),
(21, 3),
(26, 3),
(31, 3),
(33, 3),
(7, 4),
(12, 4),
(17, 4),
(22, 4),
(27, 4),
(32, 4),
(5, 5),
(8, 5),
(13, 5),
(18, 5),
(23, 5),
(28, 5);

-- --------------------------------------------------------

--
-- Structure de la table `se_categorie`
--

CREATE TABLE `se_categorie` (
  `id_categorie` int(11) NOT NULL,
  `libelle_categorie` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `se_categorie`
--

INSERT INTO `se_categorie` (`id_categorie`, `libelle_categorie`) VALUES
(1, '1-9'),
(2, '10-99'),
(3, '100-499'),
(4, '500-999'),
(5, '1000+');

-- --------------------------------------------------------

--
-- Structure de la table `se_entreprise`
--

CREATE TABLE `se_entreprise` (
  `id_entreprise` int(11) NOT NULL,
  `nom_entreprise` varchar(64) NOT NULL,
  `codep_entreprise` char(5) NOT NULL,
  `lieu_alter_entreprise` varchar(256) NOT NULL,
  `description_entreprise` blob NOT NULL,
  `logo_entreprise` varchar(256) DEFAULT NULL,
  `site_entreprise` varchar(256) DEFAULT NULL,
  `categorie_entreprise` int(11) NOT NULL,
  `secteur_entreprise` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `se_entreprise`
--

INSERT INTO `se_entreprise` (`id_entreprise`, `nom_entreprise`, `codep_entreprise`, `lieu_alter_entreprise`, `description_entreprise`, `logo_entreprise`, `site_entreprise`, `categorie_entreprise`, `secteur_entreprise`) VALUES
(1, 'Sopra', '12800', 'Centre d\'Affaire de Bourran, 1 Rue de Lisbonne', 0x536f7072612065737420756e6520656e747265707269736520696e7465726e6174696f6e616c65207370c3a96369616c6973c3a9652064616e73206c61207472616e73666f726d6174696f6e206e756dc3a972697175652e204176656320756e652065787065727469736520617070726f666f6e6469652064616e73206c657320646f6d61696e6573206465206c6120746563686e6f6c6f6769652065742064657320736572766963657320696e666f726d617469717565732c20536f707261206163636f6d7061676e652073657320636c69656e74732064616e73206c65757220706172636f757273206e756dc3a972697175652e, '0_Sopra.png', 'soprasteria.com', 2, 1),
(2, 'Linov', '12740', '675 Av. Joël Pilon', 0x4c696e6f762065737420756e6520656e747265707269736520696e6e6f76616e7465206178c3a96520737572206c652064c3a976656c6f7070656d656e7420646520736f6c7574696f6e73206c6f67696369656c6c657320737572206d65737572652e20456c6c65207365207370c3a96369616c6973652064616e73206c61206372c3a96174696f6e206465206c6f67696369656c7320706572736f6e6e616c6973c3a97320706f75722072c3a9706f6e64726520617578206265736f696e73207370c3a963696669717565732064652073657320636c69656e74732c20636f6e7472696275616e742061696e736920c3a0206c6575722073756363c3a8732e, '1_Linov.png', 'linov.fr', 1, 2),
(3, 'TechVision', '13000', '22 Rue de la République', 0x54656368566973696f6e2065737420756e6520656e74726570726973652064796e616d697175652064c3a96469c3a96520c3a0206c6120636f6e63657074696f6e20657420c3a0206c61206d69736520656e20c5937576726520646520736f6c7574696f6e7320746563686e6f6c6f676971756573206176616e63c3a965732e204176656320756e20656e676167656d656e7420656e76657273206c27696e6e6f766174696f6e2c2054656368566973696f6e207472617661696c6c6520c3a0206c276176616e742d6761726465206465206c27696e6475737472696520706f7572206f6666726972206465732070726f647569747320657420736572766963657320646520706f696e74652e, '2_TechVision.png', 'techvision.com', 2, 3),
(4, 'InnoTech', '13100', '410 Avenue de l\'Indépendance', 0x496e6e6f5465636820736520706f736974696f6e6e6520636f6d6d6520756e206c656164657220656e206d617469c3a87265206427696e6e6f766174696f6e20746563686e6f6c6f67697175652e204c27656e74726570726973652073276566666f726365206465206372c3a965722064657320736f6c7574696f6e73206176616e742d67617264697374657320706f75722072656c65766572206c65732064c3a96669732061637475656c73206475206d6f6e6465206e756dc3a972697175652c20746f757420656e206d61696e74656e616e7420756e20656e676167656d656e7420656e76657273206c27657863656c6c656e63652e, '3_InnoTech.png', 'innotech-solutions.fr', 2, 4),
(5, 'DataMinds', '13200', '15 Rue des Algorithmes', 0x446174614d696e647320657863656c6c652064616e73206c27616e616c797365206574206c612067657374696f6e2064657320646f6e6ec3a965732e20456e2074616e7420717527656e7472657072697365206178c3a96520737572206c6120736369656e63652064657320646f6e6ec3a965732c20656c6c65207472617661696c6c6520c3a020666f75726e69722064657320696e736967687473207075697373616e747320c3a02073657320636c69656e74732c206c657320616964616e742061696e736920c3a0207072656e647265206465732064c3a9636973696f6e7320c3a9636c616972c3a965732e, '4_DataMinds.png', 'dataminds.com', 1, 5),
(6, 'MegaBuild', '13300', '888 Avenue des Ingénieurs', 0x4d6567614275696c64207365207370c3a96369616c6973652064616e73206c6120636f6e737472756374696f6e20646520736f6c7574696f6e7320726f6275737465732e20456e20636f6d62696e616e7420756e652065787065727469736520617070726f666f6e64696520656e20696e67c3a96e6965726965206176656320756e20656e676167656d656e7420656e76657273206c61207175616c6974c3a92c206c27656e7472657072697365206f66667265206465732070726f647569747320657420736572766963657320666961626c657320c3a02073657320636c69656e74732e, '5_MegaBuild.png', 'megabuild-construction.com', 3, 6),
(7, 'EcoGreen', '13400', '27 Boulevard de l\'Environnement', 0x45636f477265656e206573742064c3a96469c3a96520c3a0206c61206475726162696c6974c3a920656e7669726f6e6e656d656e74616c652e204c27656e74726570726973652070726f706f73652064657320736f6c7574696f6e7320c3a9636f6c6f67697175657320696e6e6f76616e74657320706f75722061696465722073657320636c69656e747320c3a02072c3a96475697265206c65757220656d707265696e746520636172626f6e6520657420c3a020636f6e7472696275657220706f7369746976656d656e7420c3a0206c27656e7669726f6e6e656d656e742e, '6_EcoGreen.png', 'ecogreen-solutions.fr', 1, 7),
(8, 'CyberGuard', '13500', '5 Rue de la CyberSécurité', 0x4379626572477561726420736520706f736974696f6e6e6520656e2074616e742071752765787065727420656e20637962657273c3a96375726974c3a92e204c27656e7472657072697365207327656e6761676520c3a02070726f74c3a96765722073657320636c69656e747320636f6e747265206c6573206d656e61636573206e756dc3a972697175657320656e2064c3a976656c6f7070616e742064657320736f6c7574696f6e732064652073c3a96375726974c3a9206176616e63c3a9657320657420666961626c65732e, '7_CyberGuard.png', 'cyberguard-security.com', 2, 8),
(9, 'FutureTech', '13600', '123 Avenue du Futur', 0x467574757265546563682065737420c3a0206c6120706f696e7465206465206c27696e6e6f766174696f6e20746563686e6f6c6f67697175652e204c27656e747265707269736520696e7665737469742064616e73206c6120726563686572636865206574206c652064c3a976656c6f7070656d656e7420706f7572206372c3a965722064657320736f6c7574696f6e732072c3a9766f6c7574696f6e6e61697265732071756920616e7469636970656e74206c6573206265736f696e7320667574757273206465206c27696e647573747269652e, '8_FutureTech.png', 'futuretech-innovations.com', 2, 9),
(10, 'PrecisionSys', '13700', '99 Rue de la Précision', 0x507265636973696f6e53797320736520636f6e736163726520c3a0206c6120666f75726e69747572652064652073797374c3a86d657320696e666f726d6174697175657320646520706f696e74652e204c27656e74726570726973652073276566666f72636520646520676172616e746972206c61207072c3a9636973696f6e206574206c612066696162696c6974c3a9206465207365732070726f647569747320706f75722072c3a9706f6e647265206175782065786967656e63657320636f6d706c657865732064652073657320636c69656e74732e, '9_PrecisionSys.png', 'precisionsys.com', 2, 10),
(11, 'SmartSolutions', '13800', '12 Avenue de l\'Intelligence', 0x536d617274536f6c7574696f6e73206f666672652064657320736f6c7574696f6e7320696e74656c6c6967656e74657320706f7572206c65732064c3a966697320636f6d6d6572636961757820642761756a6f757264276875692e20456e20636f6d62696e616e74206c27696e74656c6c6967656e6365206172746966696369656c6c65206574206c2765787065727469736520736563746f7269656c6c652c206c27656e747265707269736520666f75726e697420646573206f7574696c73207075697373616e747320706f7572206f7074696d69736572206c65732070726f636573737573206574207374696d756c6572206c612063726f697373616e63652e, '10_SmartSolutions.png', 'smartsolutions-group.com', 2, 1),
(12, 'AlphaInnovate', '13900', '50 Rue Alpha', 0x416c706861496e6e6f76617465206573742064c3a96469c3a96520c3a0206c27696e6e6f766174696f6e20636f6e74696e75652e204c27656e7472657072697365206368657263686520636f6e7374616d6d656e7420c3a0207265706f7573736572206c6573206c696d6974657320746563686e6f6c6f67697175657320706f7572206f66667269722064657320736f6c7574696f6e7320717569207472616e73666f726d656e74206c657320696e6475737472696573206574207374696d756c656e74206c652070726f6772c3a8732e, '11_AlphaInnovate.png', 'alphainnovate-tech.com', 2, 2),
(13, 'AgriTech', '14000', '355 Avenue de l\'Agriculture', 0x41677269546563682070726f706f73652064657320736f6c7574696f6e7320746563686e6f6c6f67697175657320706f7572206c27696e647573747269652061677269636f6c652e204c27656e7472657072697365207327656e6761676520c3a020616dc3a96c696f726572206c27656666696361636974c3a9206574206c61206475726162696c6974c3a9206465206c276167726963756c74757265206772c3a2636520c3a02064657320696e6e6f766174696f6e7320746563686e6f6c6f67697175657320646520706f696e74652e, '12_AgriTech.png', 'agritech-solutions.com', 1, 3),
(14, 'UrbanTech', '14100', '28 Rue de l\'Urbanisme', 0x557262616e54656368207365207370c3a96369616c6973652064616e73206c652064c3a976656c6f7070656d656e7420646520746563686e6f6c6f6769657320706f7572206c657320656e7669726f6e6e656d656e74732075726261696e732e204c27656e7472657072697365207669736520c3a0206372c3a965722064657320736f6c7574696f6e7320696e74656c6c6967656e74657320706f75722072656c65766572206c65732064c3a9666973206465732076696c6c6573206d6f6465726e657320657420c3a020616dc3a96c696f726572206c61207175616c6974c3a9206465207669652e, '13_UrbanTech.png', 'urbantech-innovations.com', 2, 4),
(15, 'GreenEnergie', '14200', '75 Avenue de l\'Énergie Verte', 0x477265656e456e657267696520736520636f6e63656e74726520737572206c652064c3a976656c6f7070656d656e7420646520736f6c7574696f6e7320c3a96e657267c3a97469717565732064757261626c65732e204c27656e7472657072697365206368657263686520c3a02070726f6d6f75766f6972206c277574696c69736174696f6e20726573706f6e7361626c652064657320726573736f757263657320c3a96e657267c3a974697175657320746f757420656e2072c3a9706f6e64616e7420617578206265736f696e732063726f697373616e7473206465206c6120736f6369c3a974c3a92e, '14_GreenEnergie.png', 'greenenergie-solutions.com', 3, 5),
(16, 'OceanicTech', '14300', '42 Rue de l\'Océan', 0x4f6365616e696354656368206578706c6f7265206c657320746563686e6f6c6f6769657320706f7572206c657320656e7669726f6e6e656d656e7473206d6172696e732e204c27656e747265707269736520636f6e74726962756520c3a0206c6120726563686572636865206f63c3a9616e6f67726170686971756520656e20666f75726e697373616e742064657320736f6c7574696f6e7320746563686e6f6c6f676971756573206176616e63c3a9657320706f7572206c276578706c6f726174696f6e206574206c61207072c3a9736572766174696f6e20646573206f63c3a9616e732e, '15_OceanicTech.png', 'oceanictech-exploration.com', 2, 6),
(17, 'CosmoTech', '14300', '18 Boulevard Cosmique', 0x436f736d6f5465636820657863656c6c652064616e73206c6120636f6e63657074696f6e20646520746563686e6f6c6f6769657320636f736d69717565732e204c27656e7472657072697365207327656e6761676520c3a0207265706f7573736572206c65732066726f6e7469c3a8726573206465206c276578706c6f726174696f6e207370617469616c6520656e2064c3a976656c6f7070616e742064657320736f6c7574696f6e7320696e6e6f76616e74657320706f75722072c3a9706f6e647265206175782064c3a9666973206465206c27756e69766572732e, '16_CosmoTech.png', 'cosmotech-exploration.com', 2, 7),
(18, 'QuantumSys', '14400', '30 Rue Quantique', 0x5175616e74756d537973207365207370c3a96369616c6973652064616e73206c657320746563686e6f6c6f67696573207175616e7469717565732e204c27656e7472657072697365206578706c6f7265206c657320706f73736962696c6974c3a973206f6666657274657320706172206c27696e666f726d617469717565207175616e746971756520706f75722072c3a9736f75647265206465732070726f626cc3a86d657320636f6d706c65786573206574207374696d756c6572206c27696e6e6f766174696f6e2064616e73206469766572732073656374657572732e, '17_QuantumSys.png', 'quantumsys-innovations.com', 2, 8),
(19, 'BioTech Innovations', '14500', '85 Avenue de la Biotechnologie', 0x42696f5465636820496e6e6f766174696f6e732065737420c3a0206c276176616e742d67617264652064657320696e6e6f766174696f6e732062696f746563686e6f6c6f6769717565732e204c27656e747265707269736520736520636f6e736163726520c3a0206c61207265636865726368652065742061752064c3a976656c6f7070656d656e7420646520736f6c7574696f6e73207175692072c3a9766f6c7574696f6e6e656e74206c6520646f6d61696e65206465206c612062696f746563686e6f6c6f67696520706f7572206c65206269656e206465206c6120736f6369c3a974c3a92e, '18_BioTechInnovations.png', 'biotechinnovations.com', 1, 9),
(20, 'NanoSolutions', '14600', '25 Rue Nanotechnologique', 0x4e616e6f536f6c7574696f6e7320736520636f6e63656e74726520737572206c657320746563686e6f6c6f67696573206e616e6f746563686e6f6c6f6769717565732e204c27656e7472657072697365206578706c6f697465206c65732070726f707269c3a974c3a97320756e697175657320646573206e616e6f6d6174c3a9726961757820706f7572206372c3a965722064657320736f6c7574696f6e7320696e6e6f76616e7465732064616e732064697665727320646f6d61696e65732c206465206c27c3a96c656374726f6e6971756520c3a0206c61206dc3a9646563696e652e, '19_NanoSolutions.png', 'nanosolutions-tech.com', 2, 10),
(21, 'SolarisTech', '14700', '60 Avenue Solaire', 0x536f6c617269735465636820657374207370c3a96369616c6973c3a9652064616e73206c657320746563686e6f6c6f6769657320736f6c61697265732e204c27656e74726570726973652064c3a976656c6f7070652064657320736f6c7574696f6e7320c3a96e657267c3a97469717565732070726f707265732065742064757261626c657320656e206578706c6f6974616e74206c61207075697373616e636520647520736f6c65696c20706f75722072c3a9706f6e64726520617578206265736f696e732063726f697373616e747320656e20c3a96e65726769652e, '20_SolarisTech.png', 'solaristech-solutions.com', 3, 1);

-- --------------------------------------------------------

--
-- Structure de la table `se_filiere`
--

CREATE TABLE `se_filiere` (
  `id_filiere` int(11) NOT NULL,
  `libelle_filiere` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `se_filiere`
--

INSERT INTO `se_filiere` (`id_filiere`, `libelle_filiere`) VALUES
(1, 'GEA'),
(2, 'Informatique'),
(3, 'QLIO'),
(4, 'INFOCOM'),
(5, 'Carrières juridiques');

-- --------------------------------------------------------

--
-- Structure de la table `se_fonction`
--

CREATE TABLE `se_fonction` (
  `id_fonction` int(11) NOT NULL,
  `libelle_fonction` varchar(90) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `se_fonction`
--

INSERT INTO `se_fonction` (`id_fonction`, `libelle_fonction`) VALUES
(1, 'DRH'),
(2, 'Développeur'),
(3, 'Spécialiste en marketing'),
(4, 'Chef de projet'),
(5, 'Responsable des ventes'),
(6, 'Analyste financier'),
(7, 'Ingénieur logiciel'),
(8, 'Responsable des opérations'),
(9, 'Spécialiste en marketing'),
(10, 'Développeur web'),
(11, 'Responsable des ressources humaines'),
(12, 'Architecte système'),
(13, 'Gestionnaire de projet'),
(14, 'Responsable qualité'),
(15, 'Designer graphique'),
(16, 'Analyste de données'),
(17, 'Spécialiste en communication'),
(18, 'Chef de produit'),
(19, 'Analyste de systèmes'),
(20, 'Spécialiste en RH');

-- --------------------------------------------------------

--
-- Structure de la table `se_forum`
--

CREATE TABLE `se_forum` (
  `id_forum` int(11) NOT NULL,
  `duree_min_rdv_forum` int(11) NOT NULL,
  `duree_max_rdv_forum` int(11) NOT NULL,
  `date_deb_forum` date NOT NULL,
  `date_fin_forum` date NOT NULL,
  `heure_deb_forum` time NOT NULL,
  `heure_fin_forum` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `se_forum`
--

INSERT INTO `se_forum` (`id_forum`, `duree_min_rdv_forum`, `duree_max_rdv_forum`, `date_deb_forum`, `date_fin_forum`, `heure_deb_forum`, `heure_fin_forum`) VALUES
(1, 5, 15, '2024-04-12', '2024-04-12', '14:00:00', '18:00:00');

-- --------------------------------------------------------

--
-- Structure de la table `se_intervenant`
--

CREATE TABLE `se_intervenant` (
  `id_intervenant` int(11) NOT NULL,
  `nom_intervenant` varchar(64) NOT NULL,
  `fonction_intervenant` varchar(128) NOT NULL,
  `entreprise_intervenant` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `se_intervenant`
--

INSERT INTO `se_intervenant` (`id_intervenant`, `nom_intervenant`, `fonction_intervenant`, `entreprise_intervenant`) VALUES
(1, 'Lapeyre', 'DRH', 2),
(2, 'Lechat', 'Développeur', 7),
(3, 'Dufeu', 'Directeur général', 8),
(4, 'Gagnon', 'Chef de projet', 1),
(5, 'Bertrand', 'Responsable des ventes', 2),
(6, 'Martineau', 'Analyste financier', 9),
(7, 'Lavoie', 'Ingénieur logiciel', 10),
(8, 'Pelletier', 'Responsable des opérations', 3),
(9, 'Beaulieu', 'Spécialiste en marketing', 4),
(10, 'Bernard', 'Développeur web', 5),
(11, 'Fortin', 'Responsable des ressources humaines', 5),
(12, 'Roy', 'Architecte système', 6),
(13, 'Gaucher', 'Gestionnaire de projet', 11),
(14, 'Morin', 'Responsable qualité', 12),
(15, 'Lefebvre', 'Designer graphique', 13),
(16, 'Lemieux', 'Analyste de données', 15),
(17, 'Lachance', 'Spécialiste en communication', 17),
(18, 'Perron', 'Chef de produit', 16),
(19, 'Caron', 'Analyste des systèmes', 18),
(20, 'Lapointe', 'Spécialiste en RH', 19),
(21, 'Intervenant 2', 'Analyste financier', 1);

-- --------------------------------------------------------

--
-- Structure de la table `se_intervient`
--

CREATE TABLE `se_intervient` (
  `intervenant_intervient` int(11) NOT NULL,
  `filiere_intervient` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `se_intervient`
--

INSERT INTO `se_intervient` (`intervenant_intervient`, `filiere_intervient`) VALUES
(3, 1),
(8, 1),
(13, 1),
(18, 1),
(21, 1),
(4, 2),
(9, 2),
(14, 2),
(19, 2),
(1, 3),
(5, 3),
(7, 3),
(10, 3),
(15, 3),
(20, 3),
(2, 4),
(6, 4),
(11, 4),
(16, 4),
(2, 5),
(4, 5),
(7, 5),
(12, 5),
(17, 5);

-- --------------------------------------------------------

--
-- Structure de la table `se_rdv`
--

CREATE TABLE `se_rdv` (
  `id_rdv` int(11) NOT NULL,
  `heure_rdv` time NOT NULL,
  `duree_rdv` int(3) NOT NULL,
  `utilisateur_rdv` int(11) DEFAULT NULL,
  `intervenant_rdv` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `se_secteur`
--

CREATE TABLE `se_secteur` (
  `id_secteur` int(11) NOT NULL,
  `nom_secteur` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `se_secteur`
--

INSERT INTO `se_secteur` (`id_secteur`, `nom_secteur`) VALUES
(1, 'Technologie de l\'information'),
(2, 'Santé'),
(3, 'Finance'),
(4, 'Énergie'),
(5, 'Industrie manufacturière'),
(6, 'Services professionnels'),
(7, 'Éducation'),
(8, 'Commerce de détail'),
(9, 'Tourisme et hospitalité'),
(10, 'Transport et logistique'),
(11, 'fi'),
(12, 'Technologie de l\'information');

-- --------------------------------------------------------

--
-- Structure de la table `se_souhait`
--

CREATE TABLE `se_souhait` (
  `utilisateur_souhait` int(11) NOT NULL,
  `entreprise_souhait` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `se_souhait`
--

INSERT INTO `se_souhait` (`utilisateur_souhait`, `entreprise_souhait`) VALUES
(21, 2),
(21, 5);

-- --------------------------------------------------------

--
-- Structure de la table `se_statut`
--

CREATE TABLE `se_statut` (
  `id_statut` int(11) NOT NULL,
  `libelle_statut` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `se_statut`
--

INSERT INTO `se_statut` (`id_statut`, `libelle_statut`) VALUES
(1, 'Administrateur'),
(2, 'Gestionnaire'),
(3, 'Étudiant');

-- --------------------------------------------------------

--
-- Structure de la table `se_utilisateur`
--

CREATE TABLE `se_utilisateur` (
  `id_utilisateur` int(11) NOT NULL,
  `prenom_utilisateur` varchar(64) NOT NULL,
  `nom_utilisateur` varchar(64) NOT NULL,
  `mail_utilisateur` varchar(256) NOT NULL,
  `mdp_utilisateur` varchar(32) NOT NULL,
  `statut_utilisateur` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `se_utilisateur`
--

INSERT INTO `se_utilisateur` (`id_utilisateur`, `prenom_utilisateur`, `nom_utilisateur`, `mail_utilisateur`, `mdp_utilisateur`, `statut_utilisateur`) VALUES
(3, 'Jule', 'Charle', 'jule.charle@iut-rodez.fr', 'PqZbKM!x8a', 1),
(4, 'Juliette', 'Chevalier', 'juliette.chevalier@iut-rodez.fr', 'P@Zb8KM!x1a', 1),
(5, 'Lucas', 'Gagnon', 'lucas.gagnon@iut-rodez.fr', 'G@n10uX2p!', 2),
(6, 'Léa', 'Bertrand', 'lea.bertrand@iut-rodez.fr', 'B@1eR!s7v', 2),
(7, 'Marianne', 'Martin', 'marianne.martin@iut-rodez.fr', 'M@r7i@n3M', 2),
(8, 'Alexandre', 'Dupuis', 'alexandre.dupuis@iut-rodez.fr', 'D@p1!xA2rE', 2),
(9, 'Emma', 'Lavoie', 'emma.lavoie@iut-rodez.fr', 'L@v01eM!2x', 2),
(10, 'Louis', 'Bélanger', 'louis.belanger@iut-rodez.fr', 'B3l@n8erX!', 2),
(11, 'Camille', 'Renaud', 'camille.renaud@iut-rodez.fr', 'R3n@ud4Cm!', 2),
(12, 'Thomas', 'Lemieux', 'thomas.lemieux@iut-rodez.fr', 'L3mi3uX@2', 2),
(13, 'Éva', 'Fournier', 'eva.fournier@iut-rodez.fr', 'F@u2n13rE!', 2),
(14, 'Camille', 'Dubois', 'camille.dubois@iut-rodez.fr', 'M!x8aPqZbK', 3),
(15, 'Lucas', 'Lefevre', 'lucas.lefevre@iut-rodez.fr', '3hD#mLpR7s', 3),
(16, 'Émilie', 'Martin', 'emilie.martin@iut-rodez.fr', 'B3o@xYsP1f', 3),
(17, 'Charlotte', 'Tremblay', 'charlotte.tremblay@iut-rodez.fr', '9Gz*QkFv3L', 3),
(18, 'Alexandre', 'Girard', 'alexandre.girard@iut-rodez.fr', '5rU!w3oPzA', 3),
(19, 'Mélanie', 'Lambert', 'melanie.lambert@iut-rodez.fr', 'L8v@F!oZ3b', 3),
(20, 'Mathis', 'Rocher', 'mathis.rocher@iut-rodez.fr', '6Ew#sL3aHq', 3),
(21, 'Léa', 'Boucher', 'lea.boucher@iut-rodez.fr', 'T3n@Rb7P1k', 3),
(22, 'Anaïs', 'Dupont', 'anais.dupont@iut-rodez.fr', 'P!x3oN9uRv', 3),
(23, 'Nicolas', 'Marchand', 'nicolas.marchand@iut-rodez.fr', 'X5z@W1jO7l', 3),
(24, 'Chloé', 'Bergeron', 'chloe.bergeron@iut-rodez.fr', '4Mv#dU8yRz', 3),
(25, 'Jérôme', 'Lemoine', 'jerome.lemoine@iut-rodez.fr', '9Qs@B3oPzF', 3),
(26, 'Clara', 'Gauthier', 'clara.gauthier@iut-rodez.fr', 'G1a@KoL5zT', 3),
(27, 'Romain', 'Dubois', 'romain.dubois@iut-rodez.fr', 'L3z@N1rT6f', 3),
(28, 'Amélie', 'Poirier', 'amelie.poirier@iut-rodez.fr', 'P7z@W8xR4v', 3),
(29, 'Luc', 'Moreau', 'luc.moreau@iut-rodez.fr', 'M!k3oT7rPz', 3),
(30, 'Laura', 'Fontaine', 'laura.fontaine@iut-rodez.fr', 'F5z@L8oW3r', 3),
(31, 'Philippe', 'Caron', 'philippe.caron@iut-rodez.fr', 'C8z@H1oP7w', 3),
(32, 'Amandine', 'Roux', 'amandine.roux@iut-rodez.fr', 'R1z@A5mD8o', 3),
(33, 'Vincent', 'Leclerc', 'vincent.leclerc@iut-rodez.fr', 'L9z@C1oP3v', 3);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `se_appartient`
--
ALTER TABLE `se_appartient`
  ADD PRIMARY KEY (`utilisateur_appartient`,`filiere_appartient`),
  ADD KEY `fk_filiere_appartient` (`filiere_appartient`);

--
-- Index pour la table `se_categorie`
--
ALTER TABLE `se_categorie`
  ADD PRIMARY KEY (`id_categorie`);

--
-- Index pour la table `se_entreprise`
--
ALTER TABLE `se_entreprise`
  ADD PRIMARY KEY (`id_entreprise`),
  ADD KEY `fk_categorie_entreprise` (`categorie_entreprise`),
  ADD KEY `fk_secteur_entreprise` (`secteur_entreprise`);

--
-- Index pour la table `se_filiere`
--
ALTER TABLE `se_filiere`
  ADD PRIMARY KEY (`id_filiere`);

--
-- Index pour la table `se_fonction`
--
ALTER TABLE `se_fonction`
  ADD PRIMARY KEY (`id_fonction`);

--
-- Index pour la table `se_forum`
--
ALTER TABLE `se_forum`
  ADD PRIMARY KEY (`id_forum`);

--
-- Index pour la table `se_intervenant`
--
ALTER TABLE `se_intervenant`
  ADD PRIMARY KEY (`id_intervenant`),
  ADD KEY `fk_entreprise_intervenant` (`entreprise_intervenant`);

--
-- Index pour la table `se_intervient`
--
ALTER TABLE `se_intervient`
  ADD PRIMARY KEY (`intervenant_intervient`,`filiere_intervient`),
  ADD KEY `fk_filiere_intervient` (`filiere_intervient`);

--
-- Index pour la table `se_rdv`
--
ALTER TABLE `se_rdv`
  ADD PRIMARY KEY (`id_rdv`),
  ADD KEY `fk_utilisateur_rdv` (`utilisateur_rdv`),
  ADD KEY `fk_intervenant_rdv` (`intervenant_rdv`);

--
-- Index pour la table `se_secteur`
--
ALTER TABLE `se_secteur`
  ADD PRIMARY KEY (`id_secteur`);

--
-- Index pour la table `se_souhait`
--
ALTER TABLE `se_souhait`
  ADD PRIMARY KEY (`utilisateur_souhait`,`entreprise_souhait`),
  ADD KEY `fk_entreprise_souhait` (`entreprise_souhait`);

--
-- Index pour la table `se_statut`
--
ALTER TABLE `se_statut`
  ADD PRIMARY KEY (`id_statut`);

--
-- Index pour la table `se_utilisateur`
--
ALTER TABLE `se_utilisateur`
  ADD PRIMARY KEY (`id_utilisateur`),
  ADD UNIQUE KEY `mail_utilisateur` (`mail_utilisateur`),
  ADD KEY `fk_statut_utilisateur` (`statut_utilisateur`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `se_categorie`
--
ALTER TABLE `se_categorie`
  MODIFY `id_categorie` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `se_entreprise`
--
ALTER TABLE `se_entreprise`
  MODIFY `id_entreprise` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT pour la table `se_filiere`
--
ALTER TABLE `se_filiere`
  MODIFY `id_filiere` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `se_fonction`
--
ALTER TABLE `se_fonction`
  MODIFY `id_fonction` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT pour la table `se_forum`
--
ALTER TABLE `se_forum`
  MODIFY `id_forum` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `se_intervenant`
--
ALTER TABLE `se_intervenant`
  MODIFY `id_intervenant` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT pour la table `se_secteur`
--
ALTER TABLE `se_secteur`
  MODIFY `id_secteur` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT pour la table `se_statut`
--
ALTER TABLE `se_statut`
  MODIFY `id_statut` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `se_utilisateur`
--
ALTER TABLE `se_utilisateur`
  MODIFY `id_utilisateur` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=124;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `se_appartient`
--
ALTER TABLE `se_appartient`
  ADD CONSTRAINT `fk_filiere_appartient` FOREIGN KEY (`filiere_appartient`) REFERENCES `se_filiere` (`id_filiere`),
  ADD CONSTRAINT `fk_utilisateur_appartient` FOREIGN KEY (`utilisateur_appartient`) REFERENCES `se_utilisateur` (`id_utilisateur`);

--
-- Contraintes pour la table `se_entreprise`
--
ALTER TABLE `se_entreprise`
  ADD CONSTRAINT `fk_categorie_entreprise` FOREIGN KEY (`categorie_entreprise`) REFERENCES `se_categorie` (`id_categorie`),
  ADD CONSTRAINT `fk_secteur_entreprise` FOREIGN KEY (`secteur_entreprise`) REFERENCES `se_secteur` (`id_secteur`);

--
-- Contraintes pour la table `se_intervenant`
--
ALTER TABLE `se_intervenant`
  ADD CONSTRAINT `fk_entreprise_intervenant` FOREIGN KEY (`entreprise_intervenant`) REFERENCES `se_entreprise` (`id_entreprise`);

--
-- Contraintes pour la table `se_intervient`
--
ALTER TABLE `se_intervient`
  ADD CONSTRAINT `fk_filiere_intervient` FOREIGN KEY (`filiere_intervient`) REFERENCES `se_filiere` (`id_filiere`),
  ADD CONSTRAINT `fk_intervenant_intervient` FOREIGN KEY (`intervenant_intervient`) REFERENCES `se_intervenant` (`id_intervenant`);

--
-- Contraintes pour la table `se_rdv`
--
ALTER TABLE `se_rdv`
  ADD CONSTRAINT `fk_intervenant_rdv` FOREIGN KEY (`intervenant_rdv`) REFERENCES `se_intervenant` (`id_intervenant`),
  ADD CONSTRAINT `fk_utilisateur_rdv` FOREIGN KEY (`utilisateur_rdv`) REFERENCES `se_utilisateur` (`id_utilisateur`);

--
-- Contraintes pour la table `se_souhait`
--
ALTER TABLE `se_souhait`
  ADD CONSTRAINT `fk_entreprise_souhait` FOREIGN KEY (`entreprise_souhait`) REFERENCES `se_entreprise` (`id_entreprise`),
  ADD CONSTRAINT `fk_utilisateur_souhait` FOREIGN KEY (`utilisateur_souhait`) REFERENCES `se_utilisateur` (`id_utilisateur`);

--
-- Contraintes pour la table `se_utilisateur`
--
ALTER TABLE `se_utilisateur`
  ADD CONSTRAINT `fk_statut_utilisateur` FOREIGN KEY (`statut_utilisateur`) REFERENCES `se_statut` (`id_statut`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
