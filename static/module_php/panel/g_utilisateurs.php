<?php
    // Fonction qui renvoie la liste des utilisateurs avec la totalités de leurs informations
    function listeDesUtilisateurs($pdo, $idAdmin) {
        global $pdo;
        try{ 
            $connecte=false;
            // Fonction renvoyant la liste des utilisateurs 
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
                                        WHERE se_utilisateur.id_utilisateur != :idAdmin
                                        GROUP BY se_utilisateur.id_utilisateur
                                        ");
            // Rajout du parametre manquant à la requête                            
            $maRequete->bindValue(':idAdmin', $idAdmin);
            //Execution de la requete
            if ($maRequete->execute()) {
                $maRequete->setFetchMode(PDO::FETCH_OBJ);
                //création d'un tableau contenant les informations des utilisateurs
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
            // On renvoie la liste des utilisateurs sous forme de tableau
            return $listeUtilisateur;
        } catch ( Exception $e ) {
            // Message d'erreur si la connexion à la base de données n'a pas pu se faire
            echo "<h1>Erreur de connexion à la base de données ! </h1><br/>";
            // On renvoie un tableau vide
            return $listeUtilisateur;
        } 
    }

    /* Fonction qui renvoie le mot de passe de l'administrateur connecté */
    function recupMdpAdmin($pdo, $id) {
        global $pdo;
        try{ 
            $connecte=false;
            // Requête permettant de renvoyer le mot de passe
            $maRequete = $pdo->prepare("SELECT mdp_utilisateur FROM se_utilisateur WHERE id_utilisateur = :id");
            $maRequete->bindValue(':id', $id);
            $maRequete->execute();
            $resultat = $maRequete->fetchAll(PDO::FETCH_COLUMN);
            // On renvoie le résultat de la requête
            return $resultat;  
        }
        catch ( Exception $e ) {
            echo "<h1>Erreur de connexion à la base de données ! </h1><br/>";
            return null;
        } 
    }

    /* Fonction qui renvoie la liste des filières avec son identifiant et son libelle */
    function listeDesFilieres($pdo) {
        global $pdo;
        try{ 
            $connecte=false;
            // Requête permettant de renvoyer la liste des filieres
            $maRequete = $pdo->prepare("SELECT id_filiere, libelle_filiere
                                        FROM se_filiere");
            if ($maRequete->execute()) {
                $maRequete->setFetchMode(PDO::FETCH_OBJ);
                while ($ligne=$maRequete->fetch()) {
                    // On met le résultat de la requête dans un tableau		
                    $listeFilieres['idFiliere'] = $ligne->id_filiere;
                    $listeFilieres['libelleFiliere'] = $ligne->libelle_filiere;
                    $listeFiliere[] = $listeFilieres;
                }
            }
            // On renvoie le tableau contenant la liste des filières
            return $listeFiliere;
        }
        catch ( Exception $e ) {
            echo "<h1>Erreur de connexion à la base de données ! </h1><br/>";
            return $listeFiliere;
        } 
    }

    /* Fonction qui renvoie la liste des différents rôles possibles */
    function listeStatut($pdo) {
        global $pdo;
        try{ 
            $connecte=false;
            // Requête permettant de renvoyer la liste des rôles existants
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
            // Renvoie du tableau contenant le résultat
            return $listeStatut;
        }
        catch ( Exception $e ) {
            echo "<h1>Erreur de connexion à la base de données ! </h1><br/>";
            return $listeStatut;
        } 
    }

     /* Fonction permettant la suppression complète d'un utilisateur */
    function suppressionUtilisateurs($pdo, $id) {
        global $pdo;
        // Requêtes permettant la suppression d'un utilisateur
        $maRequete = $pdo->prepare("DELETE FROM se_appartient WHERE utilisateur_appartient  = :id");
        $maRequete2 = $pdo->prepare("DELETE FROM se_utilisateur WHERE id_utilisateur  = :id");
        try{ 
            // Début d'une transaction pour effectuer plusieurs requêtes d'un coup
            $pdo->beginTransaction();
            // Ajout des paramètres à nos requêtes
            $maRequete->bindValue(':id', $id);
            $maRequete2->bindValue(':id', $id);
            // Exécution des deux requêtes
            $maRequete->execute();
            $maRequete2->execute();
            // Commit dans la base de données si tout a fonctionné
            $pdo->commit();
            return true;
        }
        catch ( Exception $e ) {
            echo "<h1>Erreur de connexion à la base de données ! </h1><br/>";
            $pdo->rollback();
            return false;
        } 
    }
     
    /* Fonction permettant la modification d'un utilisateur sauf la filiere */
    function majUtilisateur($pdo, $id, $prenom, $nom, $mail, $mdp, $statut) {
        try {
            // Début d'une transaction pour effectuer plusieurs requêtes d'un coup
            $pdo->beginTransaction();
    
            // Requête permettant de mettre à jour un utilisateur
            $majNom = $pdo->prepare("UPDATE se_utilisateur SET prenom_utilisateur = :prenom WHERE id_utilisateur = :id");
            $majPrenom = $pdo->prepare("UPDATE se_utilisateur SET nom_utilisateur = :nom WHERE id_utilisateur = :id");
            $majMail = $pdo->prepare("UPDATE se_utilisateur SET mail_utilisateur = :mail WHERE id_utilisateur = :id");
            $majMdp = $pdo->prepare("UPDATE se_utilisateur SET mdp_utilisateur = :mdp WHERE id_utilisateur = :id");
            $majStatut = $pdo->prepare("UPDATE se_utilisateur SET statut_utilisateur = :statut WHERE id_utilisateur = :id");
    
            // Ajout des paramètres dans la requête
            $majNom->bindParam(':prenom', $prenom);
            $majNom->bindParam(':id', $id);
            $majPrenom->bindParam(':nom', $nom);
            $majPrenom->bindParam(':id', $id);
            $majMail->bindParam(':mail', $mail);
            $majMail->bindParam(':id', $id);
            $majMdp->bindParam(':mdp', $mdp);
            $majMdp->bindParam(':id', $id);
            $majStatut->bindParam(':statut', $statut);
            $majStatut->bindParam(':id', $id);
    
            // Exécution des requêtes
            $majNom->execute();
            $majPrenom->execute();
            $majMail->execute();
            $majMdp->execute();
            $majStatut->execute();
    
            // Commit dans la base de données si tout a fonctionné
            $pdo->commit();
            return true;
    
        } catch (Exception $e) {
            echo "<h1>Erreur de connexion à la base de données ! </h1><br/>";
            $pdo->rollback();
            return false;
        }
    }
        

    function rechercherUtilisateur($pdo, $searchQuery, $filiere, $typeUtilisateur) {

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
?>