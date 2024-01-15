<?php 
    /** @return true si la base de données est en ligne */
    function estBDConnecte() {
        global $pdo;

        if ($pdo == null) {
            return false;
        }
        return true;
    }

    /**
     *  Ecrit dans la BD le tableau d'utilisateurs fourni en paramètre
     * @return true si l'insertion est bien effectuée
     */
    function insererBDIntervenants($pdo, $tableauIntervenants) {
        global $pdo;

        $insertionIntervenants = $pdo->prepare("INSERT INTO se_intervenant(nom_intervenant,fonction_intervenant,entreprise_intervenant) VALUES (:nom,:fonction,:entreprise)");
        $insertionFiliere = $pdo->prepare("INSERT INTO se_intervient VALUES (:idI,:idF)");
        $recupererIDEntreprise = $pdo->prepare("SELECT id_entreprise FROM se_entreprise WHERE nom_entreprise = :entreprise");
        $recupererIDFiliere = $pdo->prepare("SELECT id_filiere FROM se_filiere WHERE libelle_filiere = :filiere");

        try {
            $pdo->beginTransaction();
            foreach($tableauIntervenants as $objectIntervenant) {
                $intervenant = (array)$objectIntervenant;

                /* Récupération de l'id du statut */
                $recupererIDEntreprise->bindParam("entreprise",$intervenant["entreprise"]);
                $recupererIDEntreprise->execute();
                $idEntreprise = $recupererIDEntreprise->fetch()["id_entreprise"];

                /* Insertion de l'utilisateur */
                $insertionIntervenants->bindParam("nom",$intervenant["nom"]);
                $insertionIntervenants->bindParam("fonction",$intervenant["fonction"]);
                $insertionIntervenants->bindParam("entreprise",$idEntreprise);
                $insertionIntervenants->execute();

                /* Récupération de l'id de l'utilisateur */
                $idIntervenant = $pdo->lastInsertId();

                /* Insertion de chaques filiees */
                $filieres = explode("/", $intervenant["filiere"]);

                foreach ($filieres as $filiere) {
                    /* Récupération de l'id de la filiere */
                    $recupererIDFiliere->bindParam("filiere",$filiere);
                    $recupererIDFiliere->execute();
                    $idFiliere = $recupererIDFiliere->fetch()["id_filiere"];

                    /* Insertion de la filiere */
                    $insertionFiliere->bindParam("idI",$idIntervenant);
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
            if (isset($_COOKIE["intervenants"])) {
                $donneeCookie = $_COOKIE["intervenants"];

                return json_decode($donneeCookie);
            }
        } else {
            return null;
        }
    }
    /////////////////////////////////////////////////////////////////////////////////////////////
    function listeDesIntervenants($pdo) {
        // Retourne la liste des intervenants enregistrés sous forme de tableau
        // Fonction qui retourne la liste des intervenants enregistrés sous forme de tableau
        // avec pour chaque ligne une collection indicée sur les noms des colonnes de la BD
        // Parametre $IdClient=Identifiant du client dans la BD pour lequel on veut la liste des comptes
        global $pdo;  // Connexion à la BD

        $tableauIntervenants=array() ; // Tableau qui sera retourné contenant les intervenants enregistrés

        try {	
            // REquete avec agrégats pour calculer le solde
            $maRequete = $pdo->prepare("
            SELECT se_intervenant.id_intervenant AS id, 
            se_intervenant.nom_intervenant AS nom,
            IFNULL(se_intervenant.fonction_intervenant, 'Aucune fonction renseignée') AS fonction,
            se_entreprise.nom_entreprise AS entreprise,
            GROUP_CONCAT(DISTINCT se_filiere.libelle_filiere ORDER BY se_filiere.libelle_filiere SEPARATOR ', ') AS filiere
            FROM se_intervenant
            INNER JOIN se_entreprise ON se_intervenant.entreprise_intervenant = se_entreprise.id_entreprise
            INNER JOIN se_intervient ON se_intervenant.id_intervenant = se_intervient.intervenant_intervient
            INNER JOIN se_filiere ON se_intervient.filiere_intervient = se_filiere.id_filiere
            GROUP BY se_intervenant.id_intervenant
            ORDER BY se_intervenant.nom_intervenant;");
            if ($maRequete->execute()) {
                $maRequete->setFetchMode(PDO::FETCH_OBJ);
                while ($ligne=$maRequete->fetch()) {
                    $tableauIntervenant['id']=$ligne->id;
                    $tableauIntervenant['nom']=$ligne->nom;
                    $tableauIntervenant['fonction']=$ligne->fonction;
                    $tableauIntervenant['entreprise']=$ligne->entreprise;
                    $tableauIntervenant['filiere']=$ligne->filiere;

                    $tableauIntervenants[] = $tableauIntervenant;
                }
                return $tableauIntervenants;
            }
        }
        catch ( Exception $e ) {
            return $tableauIntervenants;
        }
    }	

     /////////////////////////////////////////////////////////////////////////////////////////////
     function ajouterIntervenant($pdo, $nom_intervenant, $fonction_intervenant, $entreprise_intervenant, $filiere_intervenant) {
        global $pdo;  // Connexion à la BD
    
        try {
            if (!intervenantPresent($nom_intervenant, $fonction_intervenant, $entreprise_intervenant, $filiere_intervenant)) {
                $maRequete = $pdo->prepare("INSERT INTO se_intervenant (nom_intervenant, fonction_intervenant, entreprise_intervenant)
                    VALUES (:nomIntervenant, :fonctionIntervenant, :entrepriseIntervenant)");
                $maRequete->bindParam(':nomIntervenant', $nom_intervenant);
                $maRequete->bindParam(':fonctionIntervenant', $fonction_intervenant);
                $maRequete->bindParam(':entrepriseIntervenant', $entreprise_intervenant);
                $maRequete->execute();  // N'oubliez pas d'exécuter la requête
                return true;
            } else {
                return false;
            }
        } catch (Exception $e) {
            // Gestion de l'exception (vous pouvez choisir de loguer l'erreur ou faire autre chose)
            return false;
        }
    }
    
    function intervenantPresent($pdo, $nom_intervenant, $fonction_intervenant, $entreprise_intervenant, $filiere_intervenant) {
        global $pdo;
    
        try {
            $maRequete = $pdo->prepare("SELECT COUNT(*) AS count FROM se_intervenant
                WHERE nom_intervenant = :nomIntervenant
                AND fonction_intervenant = :fonctionIntervenant
                AND entreprise_intervenant = :entrepriseIntervenant");
            $maRequete->bindParam(':nomIntervenant', $nom_intervenant);
            $maRequete->bindParam(':fonctionIntervenant', $fonction_intervenant);
            $maRequete->bindParam(':entrepriseIntervenant', $entreprise_intervenant);
            $maRequete->execute();
            
            $result = $maRequete->fetch(PDO::FETCH_ASSOC);
    
            return $result['count'] > 0;
        } catch (Exception $e) {
            // Gestion de l'exception (vous pouvez choisir de loguer l'erreur ou faire autre chose)
            return false;
        }
    }

    /* Retourne la liste des filières présentes dans la BD */
    function getListeFiliere($pdo) {
        global $pdo;
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
        global $pdo;
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

    /* Retourne la liste des fonctions présentes dans la BD */
    function getListeFonction($pdo) {
        global $pdo;

        $tableauFonctions = array() ; // Tableau qui sera retourné contenant les fonctions enregistrés

        try {	
            $maRequete = $pdo->prepare("
                        SELECT id_fonction, libelle_fonction
                        FROM se_fonction");
            if ($maRequete->execute()) {
                $maRequete->setFetchMode(PDO::FETCH_OBJ);
                while ($ligne=$maRequete->fetch()) {
                    $tableauFonction['idFonction']=$ligne->id_fonction;
                    $tableauFonction['libelleFonction']=$ligne->libelle_fonction;

                    $tableauFonctions[] = $tableauFonction;
                }
                return $tableauFonctions;
            }
        }
        catch ( Exception $e ) {
            return $tableauFonctions;
        }
    }

    /* Retourne la liste des fonctions présentes dans la BD */
    function getListeEntreprise($pdo) {
        global $pdo;

        $tableauEntreprises = array() ; // Tableau qui sera retourné contenant les fonctions enregistrés

        try {	
            $maRequete = $pdo->prepare("
                        SELECT id_entreprise, nom_entreprise
                        FROM se_entreprise");
            if ($maRequete->execute()) {
                $maRequete->setFetchMode(PDO::FETCH_OBJ);
                while ($ligne=$maRequete->fetch()) {
                    $tableauEntreprise['idEntreprise']=$ligne->id_entreprise;
                    $tableauEntreprise['nomEntreprise']=$ligne->nom_entreprise;

                    $tableauEntreprises[] = $tableauEntreprise;
                }
                return $tableauEntreprises;
            }
        }
        catch ( Exception $e ) {
            return $tableauEntreprises;
        }
    }

    /* Retourne la liste des fonctions présentes dans la BD */
    function getNombreIntervenants($pdo, $entreprise) {
        global $pdo;
    
        $nombreIntervenants = 1; // Variable contenant le nombre d'intervenants
    
        $recupererIDEntreprise = $pdo->prepare("SELECT id_entreprise FROM se_entreprise WHERE nom_entreprise = :entreprise");
        $recupererNombreIntervenants = $pdo->prepare("SELECT COUNT(*) AS nb_intervenant
                                              FROM se_intervenant
                                              WHERE entreprise_intervenant = :idEntreprise");
    
        try {
            $pdo->beginTransaction();
        
            /* Récupération de l'id de l'entreprise */
            $recupererIDEntreprise->bindParam(":entreprise", $entreprise);
            $recupererIDEntreprise->execute();
            $idEntreprise = $recupererIDEntreprise->fetch()["id_entreprise"];
        
            /* Récupération du nombre d'intervenants pour l'entreprise donnée */
            $recupererNombreIntervenants->bindParam(":idEntreprise", $idEntreprise);
            $recupererNombreIntervenants->execute();
            $nombreIntervenants += intval($recupererNombreIntervenants->fetch()["nb_intervenant"]); // Assurez-vous que la valeur est un entier
        
            $pdo->commit();
    
            return $nombreIntervenants;
        
        } catch (PDOException $e) {
            $pdo->rollback();
            return $nombreIntervenants; // Vous pouvez également loguer l'erreur $e si nécessaire
        }
    }  

    function ajouterFiliere($pdo, $idIntervenant, $idFiliere) {
        global $pdo;
        try{ 
            $maRequete = $pdo->prepare("INSERT INTO se_intervient VALUES (:idI,:idF)");
            $maRequete->bindValue(':idI', $idIntervenant);
            $maRequete->bindValue(':idF', $idFiliere);
            $maRequete->execute();
            return true;
        }
        catch ( Exception $e ) {
            return false;
        }  
    }
    
    function supprimerFiliere($pdo, $id) {
        global $pdo;
        try{ 
            $connecte=false;
            $maRequete = $pdo->prepare("DELETE FROM se_intervient WHERE intervenant_intervient  = :id");
            $maRequete->bindValue(':id', $id);
            $maRequete->execute();
            return true;  
        }
        catch ( Exception $e ) {
            return false;
        }  
    }
?>