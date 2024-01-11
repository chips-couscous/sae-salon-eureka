<?php
session_start();
if (!isset($_SESSION['idUtilisateur'])) {
    header('Location: ../../../utilisateur/connexion.php');
}


require ('../../../static/module_php/base_de_donnees.php');
require ('../../../static/module_php/utilisateur/utilisateur.php');
require ('../../../static/module_php/utilisateur/connexion_utilisateur.php');
require('../../../static/module_php/panel/g_utilisateurs.php');


$mdpIncorrect = "";
$pdo = connexionBaseDeDonnees();
$idUtilisateur = $_SESSION['idUtilisateur'];
$informationsUtilisateur = informationsPrimairesUtilisateurById($pdo, $idUtilisateur);

if (isset($_POST['statutUtilisateur'])) {
    if ($_POST['statutUtilisateur'] == 'Gestionnaire' || 'Administrateur' && isset($_POST['motDePasseAdmin'])) {
        $recupMdpAdmin = recupMdpAdmin($pdo, $_SESSION['idUtilisateur']); 
        if($_POST['motDePasseAdmin'] == $recupMdpAdmin[0]) {
            suppressionUtilisateurs($pdo, $_POST['idUtilisateur']);
        } else {
            $mdpIncorrect = "Mot de passe administrateur incorrect";
        }
    } else if ($_POST['statutUtilisateur'] == 'Étudiant') {
        suppressionUtilisateurs($pdo, $_POST['idUtilisateur']);
    }
}

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Supprimer un utilisateur</title>

    <!-- css -->
    <link rel="stylesheet" href="../../../static/css/utilisateur/connexion.css">
    <link rel="stylesheet" href="../../../static/css/main.css">
    <link rel="stylesheet" href="../../../static/css/header.css">
    <link rel="stylesheet" href="../../../static/css/panel.css">
    <link rel="stylesheet" href="../../../static/css/modifierUtilisateur.css">

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
        <div class="zoneRecherche">
                <span>Suppresion d'un utilisateur :</span><br>
                <div class="form-item">
                    <input type="text" name="triUtilisateur" id="triUtilisateur" autocomplete="off" required>
                    <label for="triUtilisateur" placeholder="Entrez un pseudo">Rechercher un utilisateur</label>
                </div>
                <div class="form-item">
                    <select name="filiere" id="filiere">
                        <option value="">Choisir une filière</option>
                        <?php 
                            $filiere = listeDesFilieres($pdo);
                            foreach($filiere as $listeFiliere) {
                                echo "<option value = '". $listeFiliere["idFiliere"]. "'>". $listeFiliere["libelleFiliere"] . "</option>";
                            }
                        ?>
                    </select>
                </div>
                <div class="form-item">
                    <select name="typeUtilisateur" id="typeUtilisateur">
                        <option value="">Choisir un type d'utilisateur</option>
                        <?php 
                            $statut = listeStatut($pdo);
                            foreach($statut as $listeStatut) {
                                echo "<option value = '". $listeStatut["idStatut"]. "'>". $listeStatut["libelleStatut"] . "</option>";
                            }
                        ?>
                    </select>
                </div>
            </div>
            <!-- Zone d'affichage des utilisateurs -->
            <div class="listeUtilisateurs">
                <table class="tableListeUtilisateur" id="tableListeUtilisateur"> 
                    <tr>
                        <th>Identifiant</th>
                        <th>Prenom</th>
                        <th>Nom</th>
                        <th>Email</th>
                        <th>Mot de passe</th>
                        <th>Filiere</th>
                        <th>Statut</th>
                    </tr>
                    <?php 
                        $listeUtilisateurs = listeDesUtilisateurs($pdo, $idUtilisateur);
                        foreach ($listeUtilisateurs as $liste) {
                            echo "<tr class='cliquable item-utilisateur'>";
                            echo "<td>". $liste['idUtilisateur'] . "</td>";
                            echo "<td>". $liste['prenomUtilisateur'] . "</td>";
                            echo "<td>". $liste['nomUtilisateur'] . "</td>";
                            echo "<td>". $liste['mailUtilisateur'] . "</td>";
                            echo "<td>". $liste['mdpUtilisateur'] . "</td>";
                            echo "<td>". $liste['libelleFiliere'] . "</td>";
                            echo "<td>". $liste['statutUtilisateur'] . "</td>";
                            echo "</tr>";
                        }
                    ?>
                </table>
            </div>
            <div class="affichageUtilisateur" id ="affichageUtilisateur">
                <?php echo $mdpIncorrect; ?>
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