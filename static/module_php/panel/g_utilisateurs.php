<?php
    // Fonction qui renvoie la liste des utilisateurs avec la totalités de leurs informations
    function listeDesUtilisateurs() {
        global $pdo;
        try{ 
            $connecte=false;
            $maRequete = $pdo->prepare("SELECT 
                                            se_utilisateur.id_utilisateur,
                                            se_utilisateur.prenom_utilisateur,
                                            se_utilisateur.nom_utilisateur,
                                            se_utilisateur.mail_utilisateur,
                                            se_utilisateur.mdp_utilisateur,
                                            GROUP_CONCAT(DISTINCT se_filiere.libelle_filiere ORDER BY se_filiere.libelle_filiere SEPARATOR ', ') AS filieres,
                                            se_statut.libelle_statut
                                        FROM se_utilisateur
                                        INNER JOIN se_statut ON se_utilisateur.statut_utilisateur = se_statut.id_statut
                                        INNER JOIN se_appartient ON se_utilisateur.id_utilisateur = se_appartient.utilisateur_appartient
                                        INNER JOIN se_filiere ON se_appartient.filiere_appartient = se_filiere.id_filiere
                                        GROUP BY se_utilisateur.id_utilisateur
                                        ");
            if ($maRequete->execute()) {
                $maRequete->setFetchMode(PDO::FETCH_OBJ);
                while ($ligne=$maRequete->fetch()) {			
                    $listeUtilisateurs['idUtilisateur'] = $ligne->id_utilisateur;
                    $listeUtilisateurs['prenomUtilisateur'] = $ligne->prenom_utilisateur;
                    $listeUtilisateurs['nomUtilisateur'] = $ligne->nom_utilisateur;
                    $listeUtilisateurs['mailUtilisateur'] = $ligne->mail_utilisateur;
                    $listeUtilisateurs['mdpUtilisateur'] = $ligne->mdp_utilisateur;
                    $listeUtilisateurs['libelleFiliere'] = $ligne->filieres;
                    $listeUtilisateurs['statutUtilisateur'] = $ligne->libelle_statut;
                    $listeUtilisateur[] = $listeUtilisateurs;
                }
            }
            return $listeUtilisateur;
        }
        catch ( Exception $e ) {
            echo "<h1>Erreur de connexion à la base de données ! </h1><br/>";
            return $listeUtilisateur;
        } 
    }

    // Fonction qui renvoie la liste des filières avec son identifiant et son libelle
    function listeDesFilieres() {
        global $pdo;
        try{ 
            $connecte=false;
            $maRequete = $pdo->prepare("SELECT id_filiere, libelle_filiere
                                        FROM se_filiere");
            if ($maRequete->execute()) {
                $maRequete->setFetchMode(PDO::FETCH_OBJ);
                while ($ligne=$maRequete->fetch()) {			
                    $listeFilieres['idFiliere'] = $ligne->id_filiere;
                    $listeFilieres['libelleFiliere'] = $ligne->libelle_filiere;
                    $listeFiliere[] = $listeFilieres;
                }
            }
            return $listeFiliere;
        }
        catch ( Exception $e ) {
            echo "<h1>Erreur de connexion à la base de données ! </h1><br/>";
            return $listeFiliere;
        } 
    }

    // Fonction qui renvoie la liste des différents rôles possibles
    function listeStatut() {
        global $pdo;
        try{ 
            $connecte=false;
            $maRequete = $pdo->prepare("SELECT id_statut, libelle_statut
                                        FROM se_statut");
            if ($maRequete->execute()) {
                $maRequete->setFetchMode(PDO::FETCH_OBJ);
                while ($ligne=$maRequete->fetch()) {			
                    $listeStatuts['idStatut'] = $ligne->id_statut;
                    $listeStatuts['libelleStatut'] = $ligne->libelle_statut;
                    $listeStatut[] = $listeStatuts;
                }
            }
            return $listeStatut;
        }
        catch ( Exception $e ) {
            echo "<h1>Erreur de connexion à la base de données ! </h1><br/>";
            return $listeStatut;
        } 
    }

    
    function suppressionUtilisateurs($id) {
        global $pdo;
        try{ 
            $connecte=false;
            $maRequete = $pdo->prepare("DELETE FROM se_appartient WHERE utilisateur_appartient  = :id");
            $maRequete2 = $pdo->prepare("DELETE FROM se_utilisateur WHERE id_utilisateur  = :id");
            $maRequete->bindValue(':id', $id);
            $maRequete2->bindValue(':id', $id);
            $maRequete->execute();
            $maRequete2->execute();
        }
        catch ( Exception $e ) {
            echo "<h1>Erreur de connexion à la base de données ! </h1><br/>";
            return ;
        } 
    }

    
    function modificationUtilisateur($id) { // Rajouter tous les parametres de la fonction
        global $pdo;
        try{ 
            $connecte=false;
            //Ecrire la fonction 
        }
        catch ( Exception $e ) {
            echo "<h1>Erreur de connexion à la base de données ! </h1><br/>";
            return ;
        } 
    }

    function rechercherUtilisateur($searchQuery, $filiere, $typeUtilisateur) {

        // Requête pour récupérer les utilisateurs correspondant à la recherche
        $query = "SELECT * FROM utilisateurs WHERE nomUtilisateur LIKE :search";

        // Ajout des conditions pour les select filiere et typeUtilisateur s'ils sont renseignés
        if ($filiere !== '') {
            $query .= " AND idFiliere = :filiere";
        }

        if ($typeUtilisateur !== '') {
            $query .= " AND idStatut = :typeUtilisateur";
        }

        $stmt = $pdo->prepare($query);
        $stmt->bindValue(':search', '%' . $searchQuery . '%');

        // Ajout des valeurs des selects s'ils sont renseignés
        if ($filiere !== '') {
            $stmt->bindValue(':filiere', $filiere);
        }

        if ($typeUtilisateur !== '') {
            $stmt->bindValue(':typeUtilisateur', $typeUtilisateur);
        }

        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Retourne les résultats de la recherche
        return $results;
    }

    //
    //  ajouter-utilisateur
    //

    /** @return true si la base de données est en ligne */
    function estBDConnecte($pdo) {

        if ($pdo == null) {
            return false;
        }
        return true;
    }

    /**
     *  Ecrit dans la BD le tableau d'utilisateurs fourni en paramètre
     * @return true si l'insertion est bien effectuée
     */
    function insererBD($pdo, $tableauUtilisateurs) {

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

                /* Insertion de chaques filiaires */
                $filieres = explode("/", $utilisateur["filiere"]);

                foreach ($filieres as $filiere) {
                    /* Récupération de l'id de la filiaire */
                    $recupererIDFiliere->bindParam("filiere",$filiere);
                    $recupererIDFiliere->execute();
                    $idFiliere = $recupererIDFiliere->fetch()["id_filiere"];

                    /* Insertion de la filiaire */
                    $insertionFiliere->bindParam("idU",$idUtilisateur);
                    $insertionFiliere->bindParam("idF",$idFiliere);
                    $insertionFiliere->execute();
                }
            }

            $pdo->commit();
            return true;   

        } catch (PDOException $e) {
            $pdo->rollback();
            return false;
        }
    }

    /** 
     * Vérifie si il existe un cookie et si oui récupères les données des utilisateurs
     * présents dans le cookie
     */
    function recupererCookie() {
        $donneeCookie = "";
        
        if (isset($_POST["enregistrer"]) && $_POST["enregistrer"] == "true") {
            if (isset($_COOKIE["utilisateurs"])) {
                $donneeCookie = $_COOKIE["utilisateurs"];

                return json_decode($donneeCookie);
            }
        }
        return null;
    }

    /* Retourne la liste des filières présentes dans la BD */
    function getListeFiliere($pdo) {
        $listeFiliere = null;

        $requete = $pdo->prepare("SELECT id_filiere, libelle_filiere
                                            FROM se_filiere");
        if ($requete->execute()) {
            $requete->setFetchMode(PDO::FETCH_OBJ);
            while ($ligne=$requete->fetch()) {			
                $filiere['idFiliere'] = $ligne->id_filiere;
                $filiere['libelleFiliere'] = $ligne->libelle_filiere;
                $listeFiliere[] = $filiere;
            }
        }

        return $listeFiliere;
    }

    /* Retourne la liste des statut présents dans la BD */
    function getListeStatut($pdo) {
        $listeStatut = null;

        $requete = $pdo->prepare("SELECT id_statut, libelle_statut
                                            FROM se_statut");
        if ($requete->execute()) {
            $requete->setFetchMode(PDO::FETCH_OBJ);
            while ($ligne=$requete->fetch()) {			
                $statut['idStatut'] = $ligne->id_statut;
                $statut['libelleStatut'] = $ligne->libelle_statut;
                $listeStatut[] = $statut;
            }
        }

        return $listeStatut;
    }
?>