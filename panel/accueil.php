<?php
session_start();
if (!isset($_SESSION['idUtilisateur'])) {
    header('Location: ../utilisateur/connexion.php');
}

/* Utilisation des fichiers PHP pour communiquer avec la base de données */
require ('../static/module_php/base_de_donnees.php');
require ('../static/module_php/utilisateur/utilisateur.php');
require ('../static/module_php/utilisateur/connexion_utilisateur.php');
require('../static/module_php/panel/g_accueil.php');

/* Connexion à la base de données */
$pdo = connexionBaseDeDonnees();
/* Récupération de l'ID de l'utilisateur connecté */
$idUtilisateur = $_SESSION['idUtilisateur'];
/* Récupération de informations de l'utilisateur connecté */
$informationsUtilisateur = informationsPrimairesUtilisateurById($pdo, $idUtilisateur);


?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Présentation du forum</title>

    <!-- css -->
    <link rel="stylesheet" href="../static/css/utilisateur/connexion.css">
    <link rel="stylesheet" href="../static/css/main.css">
    <link rel="stylesheet" href="../static/css/header.css">
    <link rel="stylesheet" href="../static/css/panel.css">
    <link rel="stylesheet" href="../static/css/accueil.css">

    <!-- fontawesome link -->
    <script src="https://kit.fontawesome.com/4d6659720c.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js" crossorigin="anonymous"></script>
</head>

<body>
    <header>
        <div class="menu-header">
            <!-- header logo -->
            <div class="header-brand">
                <span class="light">
                    <i class="fa-solid fa-graduation-cap ic-wm-el-header"></i>SALON</span><span
                    class="bold">EUREKA</span>
            </div>

            <!-- header responsive -->
            <div id="HeaderResponsive"></div>

            <!-- header taille initiale -->
            <div class="header-navigation" id="HeaderInitial">
                <div class="navigation-onglets">
                    <nav>
                        <ul>
                            <li class="hover-underline-active">informations du forum</li>
                            <li class="hover-underline-active"><a href="./../index.html">liste des entreprises</a></li>
                        </ul>
                    </nav>
                </div>
                <div class="navigation-compte">
                      <nav>
                          <ul>
                              <li>
                                  <i class="fa-regular fa-circle-user ic-wm-el-header"></i>
                                  <div class="header-compte">
                                      <a class="hover-underline-active" href=<?php echo validerUneSessionUtilisateur($idUtilisateur) ? "\"#\">" . $informationsUtilisateur['prenom_utilisateur'] . " " . $informationsUtilisateur['nom_utilisateur'] : "\"./utilisateur/connexion.php\">" . "Se connecter" ?></a>
                                      <?php echo validerUneSessionUtilisateur($idUtilisateur) ? "<span class='badge-status'>" . $informationsUtilisateur['libelle_statut'] . "</span>" : "" ?>
                                  </div>
                              </li>
                              <?php echo validerUneSessionUtilisateur($idUtilisateur) ? "<li><i class='fa-regular fa-bell'></i></li>" : "" ?>
                          </ul>
                      </nav>
                  </div>
            </div>

            <!-- hambuger header responsive -->
            <div id="Biggachou"><span></span><span></span><span></span><span></span></div>
        </div>
    </header>

    <div class="container">
        <div class="container-content">
            <div class="fondPresentation">
                <div class="textePresentation">
                    <img src="../static/img/salonEureka.jpg" class="logoEureka">
                    <div class="fixeTitre">
                        <h2 class="nomForum">Salon Eureka</h2>
                        <h3 class="lieuForum"> Rodez </h3>
                        <h1 class="lieuForum">
                            <?php
                                // utilisation de la fonction php qui répère les dates
                                $dateForum = getDateForum($pdo);
                                /* Résultat sous forme de tableau, on récupère les données */
                                $premiereDate = $dateForum[0];
    
                                // Afficher les dates au format souhaité
                                if ($premiereDate['dateDebut'] == $premiereDate['dateFin']) {
                                    echo "Le " . $premiereDate['dateDebut'];
                                } else  {
                                    echo "Du " . $premiereDate['dateDebut'] . " au" . $premiereDate['dateFin'];
                                }
                            ?>
                        </h1>
                    </div>
                </div>
            </div>
            <hr class="traitSeparation">
            <div class="containerSalon">
                <div class="grid">
                    <img src="../static/img/logoIUT.jpg" class="logo logoIUT">
                    
                    <div class="grid-item">
                        <h2>Ou nous retrouver ?</h2>
                        
                        <p>Venez nous rejoindre à l'IUT de Rodez <?php if ($premiereDate['dateDebut'] == $premiereDate['dateFin']) { //On écrit la date du forum
                                                                                echo "Le " . $premiereDate['dateDebut'];
                                                                            } else  {
                                                                                echo "Du " . $premiereDate['dateDebut'] . " au" . $premiereDate['dateFin'];
                                                                            } 
                                                                 ?></p>
                        <h2>Pourquoi venir ?</h2>
                        <p>Trouver une alternance peut être stressant... Le salon eureka est fait pour vous, il permet la Rencontre entre étudiants en recherche d’alternance et professionnels qui recrutent !</p>
                        <h2>Quoi prendre ?</h2>
                        <p>Venez muni de votre CV, afin de proposer vos candidatures !</p>
                    </div>
                </div>
                
		    </div>
            <div class="container-info">
                <h1 class="autreInfo">Autres informations</h1> 
                <div class="bulleTexte">
                    <div class="bulle">
                        <h2>3</h2>
                        <p>ateliers gratuits proposés</p>
                    </div>
                    <div class="bulle">
                        <h2>+30</h2>
                        <p>entreprises</p>
                    </div>
                    <div class="bulle">
                        <h2>2 à 40</h2>
                        <p>rdv par entreprise</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="container-asyde">
            <div class="asyde-content">
                <div class="asyde-navigation">

                    <div class="panel">
                        <div class="titre-content">
                            <span class="titre">Paramètres</span>
                            <span class="badge-status">administrateur</span>
                        </div>
                        <i class="fa-solid fa-arrow-right" id="clickToOpenPanel"></i>
                    </div>

                    <div class="groupe-navigation">
                        <span class="titre-navigation-asyde"><i class="fa-solid fa-chevron-up"></i>Gestion du compte</span>
                        <nav>
                            <ul>
                                <li class="hover-underline-static">Mon compte</li>
                            </ul>
                        </nav>
                    </div>
                    
                    <div class="groupe-navigation">
                        <span class="titre-navigation-asyde"><i class="fa-solid fa-chevron-up"></i>Gestion du salon</span>
                        <nav>
                            <ul>
                                <li class="hover-underline-static">Préparer le salon</li>
                                <li class="hover-underline-static">Réinitialiser le salon</li>
                            </ul>
                        </nav>
                    </div>

                    <div class="groupe-navigation">
                        <span class="titre-navigation-asyde"><i class="fa-solid fa-chevron-up"></i>Gestion des utilisateurs</span>
                        <nav>
                            <ul>
                                <li class="hover-underline-static">Ajouter un utilisateur</li>
                                <li class="hover-underline-static"><a href="./modifierUtilisateur.php">Modifier un utilisateur</a></li>
                                <li class="hover-underline-static"><a href="./supprimerUtilisateur.php">Supprimer un utilisateur</a></li>
                                <li class="hover-underline-static">Retrouver un mot de passe</li>
                            </ul>
                        </nav>
                    </div>

                    <div class="groupe-navigation">
                        <span class="titre-navigation-asyde"><i class="fa-solid fa-chevron-up"></i>Gestion des entreprises</span>
                        <nav>
                            <ul>
                                <li class="hover-underline-static">Ajouter une entreprise</li>
                                <li class="hover-underline-static">Modifier une entreprise</li>
                                <li class="hover-underline-static">Supprimer une entreprise</li>
                                <li class="hover-underline-static">Ajouter un intervenant</li>
                                <li class="hover-underline-static">Modifier un intervenant</li>
                                <li class="hover-underline-static">Supprimer un intervenant</li>
                            </ul>
                        </nav>
                    </div>

                    <div class="groupe-navigation">
                        <span class="titre-navigation-asyde"><i class="fa-solid fa-chevron-up"></i>Gestion des emplois du temps</span>
                        <nav>
                            <ul>
                                <li class="hover-underline-static">Générer les emplois du temps</li>
                                <li class="inclickable">Voir un emploi du temps</li>
                                <li class="inclickable">Entreprises rejetées</li>
                            </ul>
                        </nav>
                    </div>

                    <div class="groupe-navigation">
                        <nav>
                            <ul>
                                <li class="hover-underline-static"><i class="fa-solid fa-right-from-bracket"></i> Se déconnecter</li>
                            </ul>
                        </nav>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <script src="../../../static/js/header.js"></script>
    <script src="../../../static/js/compte.js"></script>
    <script src="../../../static/js/panel/supprimer-utilisateur.js"></script>
</body>

</html>