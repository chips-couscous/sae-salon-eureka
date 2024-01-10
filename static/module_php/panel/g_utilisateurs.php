<?php 
    include('base_de_donnees.php');
    $pdo = connexionBaseDeDonnees();
    /////////////////////////////////////////////////////////////////////////////////////////////
    function listeDesIntervenants() {
        // Retourne la liste des intervenants enregistrés sous forme de tableau
        // Fonction qui retourne la liste des intervenants enregistrés sous forme de tableau
        // avec pour chaque ligne une collection indicée sur les noms des colonnes de la BD
        // Parametre $IdClient=Identifiant du client dans la BD pour lequel on veut la liste des comptes
        global $pdo;  // Connexion à la BD

        $tableauIntervenants=array() ; // Tableau qui sera retourné contenant les intervenants enregistrés

        try {	
            // REquete avec agrégats pour calculer le solde
            $maRequete = $pdo->prepare("
            SELECT se_intervenant.nom_intervenant AS nom, 
            IFNULL(se_intervenant.fonction_intervenant, 'Aucune fonction renseignée') AS fonction,
            se_entreprise.nom_entreprise AS entreprise, 
            se_filiere.libelle_filiere AS filiere
            FROM se_intervenant 
            INNER JOIN se_entreprise
            ON se_intervenant.entreprise_intervenant = se_entreprise.id_entreprise
            INNER JOIN se_intervient
            ON se_intervenant.id_intervenant = se_intervient.intervenant_intervient
            INNER JOIN se_filiere
            ON se_intervient.filiere_intervient = se_filiere.id_filiere
            ORDER BY se_intervenant.nom_intervenant;");
            if ($maRequete->execute()) {
                $maRequete->setFetchMode(PDO::FETCH_OBJ);
                while ($ligne=$maRequete->fetch()) {
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

     /////////////////////////////////////////////////////////////////////////////////////////////
     function ajouterIntervenant($nom_intervenant, $fonction_intervenant, $entreprise_intervenant, $filiere_intervenant) {
        // Fonction renvoyant les informations d'un compte
        // Paramétre $IdCompte=Identifiant du compte dans la BD
        // Retourne les détails du sous forme de collection indicée sur les noms des colonnes de la table compte.

        global $pdo;  // Connexion à la BD

        try{ // Bloc try bd injoignable 

            $maRequete = $pdo->prepare("INSERT INTO 'se_intervenant' (nom_intervenant, fonction_intervenant, entreprise_intervenant)
                                        VALUES (:nomIntervenant, :fonctionIntervenant, :entrepriseIntervenant)");
            $maRequete->bindParam(':nomIntervenant', $nom_intervenant);
            $maRequete->bindParam(':fonctionIntervenant', $fonction_intervenant); 
            $maRequete->bindParam(':entrepriseIntervenant', $entreprise_intervenant);
            
            return true;
        }
        catch ( Exception $e ) {
            return false;
        } 	
    }
    /////////////////////////////////////////////////////////////////////////////////////////////

    /* Retourne la liste des filières présentes dans la BD */
    function getListeFiliere() {
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
    function getListeStatut() {
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
    function getListeFonction() {
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
?>