<?php
session_start();
require "./static/module_php/base_de_donnees.php";
require "./static/module_php/utilisateur/utilisateur.php";
require "./static/module_php/utilisateur/connexion_utilisateur.php";

$pdo = connexionBaseDeDonnees();
$idUtilisateur = $_SESSION['idUtilisateur'];
$informationsUtilisateur = informationsPrimairesUtilisateurById($pdo, $idUtilisateur);
?>

<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Salon Eureka</title>

        <!-- css -->
        <link rel="stylesheet" href="./static/css/main.css">
        <link rel="stylesheet" href="./static/css/header.css">
        <link rel="stylesheet" href="./static/css/entreprise.css">
        <link rel="stylesheet" href="./static/css/connexion.css">

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
                                <li class="hover-underline-active"><a href="panel/etudiant/entreprise.php">liste des entreprises</a></li>
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


        <script src="./static/js/header.js"></script>
    </body>
</html>