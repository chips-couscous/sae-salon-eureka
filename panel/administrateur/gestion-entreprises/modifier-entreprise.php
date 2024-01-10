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
            <span class="titre-panel-ouvert"><span>Gestion des entreprises ></span> Modifier une entreprise</span>
            <form action="" method="post">
                <div class="form-item bm15">
                    <input type="text" name="entreprise" id="Entreprise" autocomplete="off" required/>
                    <label for="Entreprise">Rechercher une entreprise</label>
                    <span id="resultats"></span>
                </div>
            </form>
            <?php
                
            ?>
            <form action="modifier-entreprise.php" id="EditForm" method="post">
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
                </div>
                <div class="form-item bm15">
                    <input type="text" name="secteurActivites" id="SecteurActivites" autocomplete="off" required>
                    <label for="SecteurActivites">Secteur d'activité</label>
                </div>
                <div class="form-item">
                    <input type="submit" value="Modifier">
                </div>
            </form>
        </div>
        <?php
            try {
                require ('../../../static/module_php/panel/base_de_donnees.php');
                $pdo = connexionBaseDeDonnees();
            } catch(Exception $e) {
                echo "<h1>Connexion impossible</h1>";
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
                                <li class="hover-underline-static"><a href="./ajouter-entreprise.php">Ajouter une entreprise</a></li>
                                <li class="hover-underline-static"><a href="./modifier-entreprise.php">Modifier une entreprise</a></li>
                                <li class="hover-underline-static"><a href="./supprimer-entreprise.php">Supprimer une entreprise</a></li>
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
    <script src="../../../static/js/panel/modifier-entreprise.js"></script>
</body>

</html>