<?php
    /* Récupération des utilisateurs */
    $donneeCookie = "";
    $tableauUtilisateurs = null;
    if (isset($_POST["enregistrer"]) && $_POST["enregistrer"] == "true") {
        if (isset($_COOKIE["utilisateurs"])) {
            $donneeCookie = $_COOKIE["utilisateurs"];

            $tableauUtilisateurs = json_decode($donneeCookie);
        }
    }

    /* Récupération de l'objet PDO */
    require "../../../static/module_php/base_de_donnees.php";

    if ($pdo == null) {
        ?><script>alert("Base de données non accessible !");</script><?php
    }

    /* Ecriture dans la base de données */
    if ($tableauUtilisateurs != null && $pdo != null) {
        $insertionUtilisateurs = $pdo->prepare("INSERT INTO se_utilisateur (prenom_utilisateur,nom_utilisateur,mail_utilisateur,mdp_utilisateur,statut_utilisateur) VALUES (:prenom,:nom,:mail,:mdp,:statutU)");
        $insertionFiliere = $pdo->prepare("INSERT INTO se_appartient VALUES (:idU,:idF)");
        $recupererIDStatut = $pdo->prepare("SELECT id_statut FROM se_statut WHERE libelle_statut = :statut");
        $recupererIDFiliere = $pdo->prepare("SELECT id_filiere FROM se_filiere WHERE libelle_filiere = :filiere");
    
        try {
            $pdo->beginTransaction();
            foreach($tableauUtilisateurs as $objectUtilisateur) {
                $utilisateur = (array)$objectUtilisateur;

                /* Récupération de l'id du statut */
                $recupererIDStatut->bindParam("statut",$utilisateur["statut"]);
                $recupererIDStatut->execute();
                $idStatut = $recupererIDStatut->fetch()["id_statut"];

                /* Insertion de l'utilisateur */
                $insertionUtilisateurs->bindParam("prenom",$utilisateur["prenom"]);
                $insertionUtilisateurs->bindParam("nom",$utilisateur["nom"]);
                $insertionUtilisateurs->bindParam("mail",$utilisateur["mail"]);
                $insertionUtilisateurs->bindParam("mdp",$utilisateur["mdp"]);
                $insertionUtilisateurs->bindParam("statutU",$idStatut);
                $insertionUtilisateurs->execute();

                /* Récupération de l'id de l'utilisateur */
                $idUtilisateur = $pdo->lastInsertId();

                /* Récupération de l'id de la filiaire */
                $recupererIDFiliere->bindParam("filiere",$utilisateur["filiere"]);
                $recupererIDFiliere->execute();
                $idFiliere = $recupererIDFiliere->fetch()["id_filiere"];

                /* Insertion de la filiaire */
                $insertionFiliere->bindParam("idU",$idUtilisateur);
                $insertionFiliere->bindParam("idF",$idFiliere);
                $insertionFiliere->execute();
            }
            $pdo->commit();
            /* Message indiquant la réussite de l'insertion dans la bdd */
            ?><script>alert("SUCCES ! Tous les utilisateurs ont bien été importés !");</script><?php
        } catch (PDOException $e) {
            $pdo->rollback();
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
    <title>Salon Eureka - Ajouter un utilisateur</title>

    <!-- css -->
    <link rel="stylesheet" href="../../../static/css/connexion.css">
    <link rel="stylesheet" href="../../../static/css/main.css">
    <link rel="stylesheet" href="../../../static/css/header.css">
    <link rel="stylesheet" href="../../../static/css/panel.css">
    <link rel="stylesheet" href="../../../static/css/utilisateur.css">

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
                            <li class="hover-underline-active"><a href="../../../index.php">liste des entreprises</a></li>
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

            <?php
            /* Affichage d'un message si la BD est innaccessible */
            if ($pdo == null) {
                ?><h1 class="erreurBD">Base de données non accessible, peut entraîner des problèmes</h1><?php
            }
            ?>

            <!-- Zone d'importation d'une liste d'utilisateur -->
            <div class="zoneImporterEtudiant" id="zoneImporterEtudiant">
                <span>Déposer un fichier ou</span>&nbsp;<input type="file" name="importerEtudiant" id="importerEtudiant" class="btnImporterEtudiant" accept=".csv" value="Importer">
            </div>

            <!-- Zone d'ajout manuel -->
            <div class="ajoutManuel">
                <div class="form-item bm15 nom">
                    <input type="text" name="nom" id="nom" autocomplete="off" class="" required>
                    <label for="nom">Nom</label>
                </div>
                <div class="form-item bm15 prenom">
                    <input type="text" name="prenom" id="prenom" autocomplete="off" class="" required>
                    <label for="prenom">Prénom</label>
                </div>
                <div class="form-item bm15 mail">
                    <input type="text" name="mail" id="mail" autocomplete="off" class="" required>
                    <label for="mail">Mail</label>
                </div>
                <div class="form-item bm15 mdp">
                    <input type="password" name="mdp" id="mdp" autocomplete="off" class="" required>
                    <label for="mdp">Mot de passe</label>
                </div>
                <div class="form-item bm15 filiere">
                    <input type="text" name="filiere" id="filiere" autocomplete="off" class="" required>
                    <label for="filiere">Filiere</label>
                </div>
                <div class="form-item bm15 status">
                    <input type="text" name="status" id="status" autocomplete="off" class="" required>
                    <label for="status">Status</label>
                </div>
                <div class="form-item ajouter">
                    <button id="ajouterUtilisateur" class="valider ajouterManuel">Ajouter</button>
                </div>
            </div>

            <!-- Zone de prévisualisation de l'ajout final --> 
            <div class="previsualisation">
                <div class="row titre">
                    <div class="prenom"><span>Prénom</span></div>
                    <div class="nom"><span>Nom</span></div>
                    <div class="mail"><span>Mail</span></div>
                    <div class="mot-de-passe"><span>Mot de passe</span></div>
                    <div class="statut"><span>Statut</span></div>
                    <div class="filiere"><span>Filiere</span></div>
                    <div class="btnSup"></div>
                </div>

                <div class="item" id="tablePrevisualisation">
            
                </div>
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
    <script src="../../../static/js/panel/ajouter-utilisateur.js"></script>
</body>

</html>