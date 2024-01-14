<?php
    require('../../../static/module_php/panel/g_utilisateurs.php');
    $bdConnecte = estBDConnecte(); // Vérification de la connection à la BD
    $tableauIntervenants = recupererCookie();
    $estBtnValideClique = isset($_POST["enregistrer"]) && $_POST["enregistrer"] == true;

    if (!$bdConnecte) {
        ?><script>alert("Base de données non accessible !");</script><?php
    }

    /* Insertion dans la BD */
    if ($tableauIntervenants != null && $bdConnecte && $estBtnValideClique) {
        if (insererBDIntervenants($tableauIntervenants)) {
            ?><script>alert("SUCCES ! Tous les utilisateurs ont bien été importés !");</script><?php
        } else {
            ?>
            <script>
                alert("ERREUR ! Impossible d'ajouter les utilisateurs !\n\n Vérifiez les status ou les filieres."
                        + "\n Utilisateur peut être déjà présent dans la base de données");
            </script>
            <?php
        }        
    }
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
        <span class="titre-panel-ouvert"><span>Gestion des intervenants ></span> Ajouter un intervenant</span>
            <!-- Zone d'ajout manuel -->
            <div class="ajoutManuel">
                <div>
                    <label for="entreprise">Sélectionnez une entreprise :</label>
                    <select name="entreprise" id="selectionEntreprise">
                        <option value="">-- Choisissez une entreprise --</option>
                        <?php
                        foreach(getListeEntreprise() as $entreprise) {
                            ?><option value="<?php echo $entreprise['nomEntreprise'];?>"><?php echo $entreprise['nomEntreprise'];?></option><?php
                        }
                        ?>
                    </select>
                </div>
                <div class="form-item bm15 champsIntervenantInvisible champsAjoutIntervenant">
                    <input type="text" name="nom" id="nom" required >
                    <label for="nom">Nom *</label>
                </div>
                <div class="form-item bm15 champsIntervenantInvisible champsAjoutIntervenant">
                    <select name="fonction" id="fonction">
                        <option value="-1">Fonction</option>
                        <?php
                        foreach(getListeFonction() as $fonction) {
                            ?><option value="<?php echo $fonction['libelleFonction'];?>"><?php echo $fonction['libelleFonction'];?></option><?php
                        }
                        ?>
                    </select>
                </div>
                <div class="form-item bm15 champsIntervenantInvisible champsAjoutIntervenant" >
                    <select name="filiere" id="filiere">
                        <option value="-1">Filiere</option>
                        <?php
                        foreach(getListeFiliere() as $filiere) {
                            ?><option value="<?php echo $filiere['libelleFiliere'];?>"><?php echo $filiere['libelleFiliere'];?></option><?php
                        }
                        ?>
                    </select>
                </div>
                <div class="form-item ajouter champsIntervenantInvisible champsAjoutIntervenant" >
                    <button id="ajouterUtilisateur" class="valider ajouterManuel">Ajouter</button>
                </div>
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
				</table>        
            </div>
            <form action="" method="post" class="formValider">
                <input type="hidden" name="enregistrer" value="true">
                <input type="submit" class="valider" value="Valider les ajouts">
            </form>
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
                                <li class="hover-underline-static"><a href="#">Ajouter un intervenant</a></li>
                                <li class="hover-underline-static"><a href="./modifier-intervenant.php">Modifier un intervenant</a></li>
                                <li class="hover-underline-static"><a href="./supprimer-intervenant.php">Supprimer un intervenant</a></li>
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
    <script src="../../../static/js/panel/ajouter-intervenant.js"></script>
</body>

</html>