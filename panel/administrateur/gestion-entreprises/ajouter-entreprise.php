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
    <link rel="stylesheet" href="../../../static/css/gestionEntreprise.css">

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
            <span class="titre-panel-ouvert"><span>Gestion des entreprises ></span> Ajouter une entreprise</span>
            <?php
                try {
                    require ('../../../static/module_php/panel/base_de_donnees.php');
                    $pdo = connexionBaseDeDonnees();
                    $formValide = true;
                
            ?>
            <form action="./ajouter-entreprise.php" method="post">
                <div class="form-item bm15">
                    <input type="text" name="nomE" id="NomE" autocomplete="off" required>
                    <label for="NomE">Nom</label>
                </div>
                <div class="form-item bm15">
                    <input type="text" name="description" id="Description" autocomplete="off" required>
                    <label for="Description">Description</label>
                </div>
                <div class="form-item bm15">
                    <input type="text" name="codePostal" id="CodePostal" autocomplete="off" required>
                    <label for="CodePostal">Code Postal </label>
                    <?php
                        if (isset($_POST["codePostal"])) {
                            $codeP = (int)($_POST["codePostal"]);
                            if ($codeP == 0 || strlen($codeP) != 5) {
                                $formValide = false;
                            }
                        }
                    ?>
                </div>
                <div class="form-item bm15">
                    <input type="text" name="lieuAlternance" id="LieuAlternance" autocomplete="off" required>
                    <label for="LieuAlternance">Lieu de l'alternance</label>
                </div>
                <div class="form-item bm15">
                    <select name="tailleEntreprise" id="TailleEntreprise" autocomplete="off" required>
                        <option value="" class="grise">catégorie de l'entreprise</option>
                        <option value="1">1 - 9</option>
                        <option value="2">10-99</option>
                        <option value="3">100-499</option>
                        <option value="4">500-999</option>
                        <option value="5">1000+</option>
                    </select>
                </div>
                <div class="form-item bm15">
                    <input type="text" name="siteInternet" id="SiteInternet" autocomplete="off" required>
                    <label for="SiteInternet">Site internet</label>
                    <?php
                        #$regex = "/^[_a-zA-Z0-9-]+(\.[_a-zA-Z0-9-]+)*@([a-zA-Z0-9-]+\.)+[a-zA-Z]{2,4}$/";
                        #if (isset($_POST["lieuAlternance"]) && !preg_match($regex, $_POST["lieuAlternance"])) {
                        #    $formValide = false;
                        #}
                    ?>
                </div>
                <div class="form-item bm15">
                    <input type="text" name="secteurActivites" id="SecteurActivites" autocomplete="off" required>
                    <label for="SecteurActivites">Secteur d'activité</label>
                    <span id="Secteur"></span>
                </div>
                <div class="form-item">
                    <input type="submit" value="Ajouter">
                </div>
                <?php
                    if (isset($_POST['nomE']) && $_POST['nomE'] != "" && $formValide == true) {
                        $requete = "SELECT nom_secteur FROM se_secteur";
                        $stmt = $pdo->prepare($requete);
                        $stmt->execute();
                        $stmt->fetch();
                        $secteurExistant = false;
                        foreach($stmt as $secteur) {
                            if($_POST["secteurActivites"] == $secteur["nom_secteur"]) {
                                $secteurExistant = true;
                            }
                        }

                        # insertion d'un secteur d'activité
                        if (!$secteurExistant) {
                            # le secteur d'activité n'existe pas
                            $stmt = $pdo->prepare("INSERT INTO se_secteur (nom_secteur) VALUES (:nomSecteur)");
                            $stmt->bindParam("nomSecteur", $_POST["secteurActivites"]);
                            $stmt->execute();
                        }
                        

                        # Récupération id_secteur 
                        $requete = $pdo->prepare("SELECT id_secteur FROM se_secteur WHERE nom_secteur = :nomS");
                        $requete->bindParam("nomS", $_POST["secteurActivites"]);
                        $requete->execute();
                        $numSecteur = $requete->fetch();

                        # Insertion des données relatives à l'entreprise
                        $stmt = $pdo->prepare("INSERT INTO se_entreprise (nom_entreprise, codep_entreprise, lieu_alter_entreprise, description_entreprise, site_entreprise, categorie_entreprise, secteur_entreprise)
                                           VALUES (:nomE, :codePE, :lieuAlterE, :descrE, :siteE, :categorieE, :secteurE)");
                        $stmt->bindParam("nomE", $_POST["nomE"]);
                        $stmt->bindParam("codePE", $codeP);
                        $stmt->bindParam("lieuAlterE", $_POST["lieuAlternance"]);
                        $stmt->bindParam("descrE", $_POST["description"]);
                        $stmt->bindParam("siteE", $_POST["siteInternet"]);
                        $stmt->bindParam("categorieE", $_POST["tailleEntreprise"]);
                        $stmt->bindParam("secteurE", $numSecteur["id_secteur"]);
                        #$stmt->execute();

                        echo "<h1>insertion</h1>";
                        var_dump($numSecteur["id_secteur"]);
                    } else if (isset($codeP)) {
                        echo "<h1>formulaire pas valide</h1>";
                    }
                ?>
            </form>
        </div>
                <?php
                    } catch (PDOException $e){
                        $e -> getMessage();
                        echo "<h1>Erreur de connexion à la base de données</h1>";
                    }
                ?>
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
                                <a href="./modifier-entreprise.php"><li class="hover-underline-static">Modifier une entreprise</li></a>
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
    <script src="../../../static/js/panel/ajouter-entreprise.js"></script>
    <script src="../../../static/js/panel/module.js"></script>
</body>

</html>