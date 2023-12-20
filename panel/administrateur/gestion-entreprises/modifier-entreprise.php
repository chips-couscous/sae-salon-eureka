<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Salon Eureka</title>

    <!-- css -->
    <link rel="stylesheet" href="../css/compte.css">
    <link rel="stylesheet" href="../css/main.css">
    <link rel="stylesheet" href="../css/header.css">
    <link rel="stylesheet" href="../css/entreprise.css">
    <link rel="stylesheet" href="../css/connexion.css">

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
            <form>
                <div class="form-item bm15">
                    <input type="text" name="entreprise" id="Entreprise" autocomplete="off" required>
                    <label for="Entreprise">Rechercher une entreprise</label>
                    <input type="submit" value="Chercher"/>
                </div>
            </form>
            <div class="liste-entreprise">
                <?php
                    $stmt = $pdo->prepare("SELECT nom_entreprise, logo_entreprise, description_entreprise, nom_secteur
                                           FROM se_entreprise
                                           JOIN se_possede
                                           ON entreprise_possede = id_entreprise
                                           JOIN se_secteur
                                           ON secteur_possede = id_secteur
                                           WHERE nom_entreprise LIKE \"%:nomE\"");
                    if (isset($_POST["entreprise"])) {
                        $stmt->bindParam("nomE", $_POST["nomE"]);
                        $listeEntreprises = $stmt->execute();
                        foreach($listeEntreprises as $value) {
                            echo '<div class="carte">
                                <div class="entreprise-container">
                                    <div class="carte-entreprise">
                                        <div class="recto">
                                            <div class="identite">
                                                <img src="../img/sopra.png" alt="Logo sopra" draggable="false">
                                                <span>Sopra</span>
                                            </div>
                                            <div class="tags">
                                                <span><i class="fa-solid fa-location-dot"></i>Rodez</span>
                                                <span><i class="fa-solid fa-tag"></i>Informatique</span>
                                                <span><i class="fa-solid fa-users"></i>10-100</span>
                                            </div>
                                        </div>
                                        <div class="verso">
                                            <div class="description-container">
                                                <div class="description-content">
                                                    Lorem, ipsum dolor sit amet consectetur adipisicing elit. Debitis, enim consequuntur! Ad vero exercitationem quidem, nesciunt deleniti fugit odio magni. Qui officiis consequatur, explicabo autem eaque ducimus beatae earum dignissimos ?
                                                    Lorem ipsum, dolor sit amet consectetur adipisicing elit. Ducimus officiis tenetur saepe recusandae quia delectus eaque aliquid doloribus repudiandae minus. Libero assumenda dolore nostrum quam officiis quibusdam itaque nisi corporis.
                                                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Architecto maxime quisquam facere. Rerum modi quam aut ducimus laborum, velit unde autem! Voluptate ducimus reiciendis est. Quasi autem facere ad doloribus?
                                                </div>
                                            </div>
                                            <div class="fin-verso">
                                            <div class="lien-site">
                                                <a href="#" class="hover-underline-active">Sopra.com</a>
                                            </div>
                                            <div class="btn-souhait">
                                                <span>Ajouter aux souhaits</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>';
                        }
                    } 
                ?>
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
</body>

</html>