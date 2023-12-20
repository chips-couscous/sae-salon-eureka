<?php

    include('base_de_donnees.php');
    $pdo = connexionBaseDeDonnees();

    // Fonction qui renvoie la liste des utilisateurs avec la totalités de leurs informations
    function listeDesUtilisateurs() {
        global $pdo;
        try{ 
            $connecte=false;
            $maRequete = $pdo->prepare("SELECT id_utilisateur, prenom_utilisateur, nom_utilisateur, mail_utilisateur, mdp_utilisateur, libelle_filiere, libelle_statut 
                                        FROM se_utilisateur
                                        INNER JOIN se_statut
                                        ON se_utilisateur.statut_utilisateur = se_statut.id_statut
                                        INNER JOIN se_appartient
                                        ON se_utilisateur.id_utilisateur = se_appartient.utilisateur_appartient
                                        INNER JOIN se_filiere
                                        ON se_appartient.filiere_appartient = se_filiere.id_filiere
                                        GROUP BY id_utilisateur");
            if ($maRequete->execute()) {
                $maRequete->setFetchMode(PDO::FETCH_OBJ);
                while ($ligne=$maRequete->fetch()) {			
                    $listeUtilisateurs['idUtilisateur'] = $ligne->id_utilisateur;
                    $listeUtilisateurs['prenomUtilisateur'] = $ligne->prenom_utilisateur;
                    $listeUtilisateurs['nomUtilisateur'] = $ligne->nom_utilisateur;
                    $listeUtilisateurs['mailUtilisateur'] = $ligne->mail_utilisateur;
                    $listeUtilisateurs['mdpUtilisateur'] = $ligne->mdp_utilisateur;
                    $listeUtilisateurs['libelleFiliere'] = $ligne->libelle_filiere;
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
?>