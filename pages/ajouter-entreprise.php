<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Salon Eureka</title>

    <!-- css -->
    <link rel="stylesheet" href="../css/gestionEntreprise.css">
    <link rel="stylesheet" href="../css/connexion.css">
    <link rel="stylesheet" href="../css/main.css">
    <link rel="stylesheet" href="../css/header.css">
    <link rel="stylesheet" href="../css/compte.css">

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
                    $host="localhost";
                    $user="root";
                    $pass="root";
                    $db="salon_eureka_cps";
                    $charset="utf8mb4";
        
                    $dsn="mysql:host=$host;dbname=$db;charset=$charset";
        
                    $options = [
                        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, 
                        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, 
                        PDO::ATTR_EMULATE_PREPARES => false
                    ];
                    $dsn="mysql:host=$host;dbname=$db;charset=$charset";
        
                    $pdo = new PDO($dsn, $user, $pass, $options);

                    #if (isset($_POST['nomE']) && $_POST['nomE'] == "") {
                    #    $stmt = $pdo->prepare("INSERT INTO (nom_entreprise, codep_entreprise, lieu_alter_entreprise, description_entreprise, site_entreprise, secteur_entreprise)se_entreprises 
                    #                       VALUES (:nomE, :codePE, :lieualterE, :descrE, :siteE, :secteurE,)");
                    #    $stmt->bindParam("nomE", $_POST["nomE"]);
                    #    $stmt->bindParam("codePE", $_POST["codePostal"]);
                    #    $stmt->bindParam("lieuAlterE", $_POST["nomE"]);
                    #    $stmt->bindParam("descrE", $_POST["description"]);
                    #    $stmt->bindParam("nomE", $_POST["nomE"]);
                    #    $stmt->lastInsertId();
                    #}
                
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
                    <input type="text" name="identifiant" id="Identifiant" autocomplete="off" required>
                    <label for="Identifiant">Lieu de l'alternance</label>
                </div>
                <div class="form-item bm15">
                    <input type="text" name="codePostal" id="CodePostal" autocomplete="off" required>
                    <label for="CodePostal">Code Postal </label>
                </div>
                <div class="form-item bm15">
                    <input type="text" name="identifiant" id="Identifiant" autocomplete="off" required>
                    <label for="Identifiant">Secteur d'activité</label>
                </div>
                <div class="form-item bm15">
                    <input type="text" name="siteInternet" id="SiteInternet" autocomplete="off" required>
                    <label for="SiteInternet">Site internet</label>
                </div>
                <div class="form-item bm15">
                    <input type="text" name="secteurActivites" id="SecteurActivites" autocomplete="off" required>
                    <label for="SecteurActivites">Secteur d'activité</label>
                    <div class="result-box">
                        <ul>
                        <?php
                            $requete = $pdo->prepare("SELECT nom_secteur FROM se_secteur");
                            $requete->execute();
                            while($value = $requete->fetch()) {    
                        ?>
                        <li> <?php echo $value["nom_secteur"] ?> </li>
                        <?php 
                            }
                        ?>
                        </ul>
                    </div> 
                </div>
                <div class="form-item">
                    <input type="submit" value="Ajouter">
                </div>
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

    <script src="../js/header.js"></script>
    <script src="../js/compte.js"></script>
    <script src="../js/autocomplete.js"></script>
</body>

</html>