<?php
    session_start();

    if (!isset($_SESSION['idUtilisateur'])) {
        header('Location: ../../../utilisateur/connexion.php');
    }
    
    require ('../../../static/module_php/base_de_donnees.php');
    require ('../../../static/module_php/utilisateur/utilisateur.php');
    require ('../../../static/module_php/utilisateur/connexion_utilisateur.php');
    require ('../../../static/module_php/panel/g_intervenants.php');

    $pdo = connexionBaseDeDonnees();

    // On récupère l'ID de l'utilisateur connecté
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
    <link rel="stylesheet" href="../../../static/css/connexion.css">
    <link rel="stylesheet" href="../../../static/css/main.css">
    <link rel="stylesheet" href="../../../static/css/header.css">
    <link rel="stylesheet" href="../../../static/css/compte.css">
    <link rel="stylesheet" href="../../../static/css/panel.css">
    <link rel="stylesheet" href="../../../static/css/intervenant.css">

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
                                    <span class="hover-underline-active">Thomas Lemaire</span>
                                    <!-- VIDE SI PAS CO -->
                                    <span class="badge-status">étudiant</span>
                                </div>
                            </li>
                            <!-- VIDE SI PAS CO -->
                            <li><i class="fa-regular fa-bell"></i></li>
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
            <span class="titre-panel-ouvert"><span>Gestion des intervenants ></span> Supprimer un intervenant</span>
            <!-- Zone d'ajout manuel -->
            <div class="ajoutManuel">
                <span>Rechercher un intervenant :</span><br>
                <form action="post">
                    <div class="form-item bm15 ">
                        <input type="text" name="nom" id="nom" autocomplete="off" required>
                        <label for="nom">Nom *</label>
                    </div>
                    <div class="form-item bm15">
                        <input type="text" name="entreprise" id="entreprise" autocomplete="off" required>
                        <label for="entreprise">Entreprise *</label>
                    </div>
                </form>
            </div>

            <!-- Zone de prévisualisation de l'ajout final --> 
            <div class="previsualisation">
                <table class="tablePrevisualisation" id="TablePrevisualisation">
					<tr>
						<!--- Contenu -->
						<th>
							<!--- Colonne nom -->
							Nom
						</th>
						<th>
							<!--- Colonne Fonction -->
							Fonction    
						</th>
						<th>
							<!--- Colonne Entreprise -->
							Entreprise
						</th>
						<th>
							<!--- Colonne Filiere -->
							Filiere
						</th>							
					</tr>
					<?php       
					// Récupération des intervenants
					$listeIntervenants=listeDesIntervenants($pdo); 

					// Boucle afficher la liste des intervenants
					foreach($listeIntervenants as $intervenant) {
						$nom=$intervenant['nom'];
						$fonction=$intervenant['fonction']; 
						$entreprise=$intervenant['entreprise']; 
						$filiere=$intervenant['filiere'];
                    
						echo "<tr>";
						echo "<td>".$nom."</td>";
						echo "<td>".$fonction."</td>";
						echo "<td>".$entreprise."</td>";
                        echo "<td>".$filiere."</td>";
						echo "</tr>";   
					}							
					?>
				</table>        
            </div>

            <button class="valider" id="boutonSupprimer">Valider la suppression</button>
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
                                <li class="hover-underline-static">Modifier un utilisateur</li>
                                <li class="hover-underline-static">Supprimer un utilisateur</li>
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
                                <li class="hover-underline-static"><a href="./ajouter-intervenant.php">Ajouter un intervenant</a></li>
                                <li class="hover-underline-static"><a href="./modifier-intervenant.php">Modifier un intervenant</a></li>
                                <li class="hover-underline-static"><a href="#">Supprimer un intervenant</a></li>
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
    <script src="../../../static/js/panel/suppressionIntervenants.js" type="module"></script>
</body>

</html>