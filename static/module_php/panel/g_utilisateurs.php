<?php
    include('base_de_donnees.php');
    $pdo = connexionBaseDeDonnees();

    function listeDesUtilisateurs() {
        global $pdo;
        try{ 
            $connecte=false;
            $maRequete = $pdo->prepare("SELECT id_utilisateur, prenom_utilisateur, nom_utilisateur, mail_utilisateur, mdp_utilisateur, statut_utilisateur 
                                        FROM se_utilisateur");
            if ($maRequete->execute()) {
                $maRequete->setFetchMode(PDO::FETCH_OBJ);
                while ($ligne=$maRequete->fetch()) {			
                    $listeUtilisateurs['idUtilisateur'] = $ligne->id_utilisateur;
                    $listeUtilisateurs['prenomUtilisateur'] = $ligne->prenom_utilisateur;
                    $listeUtilisateurs['nomUtilisateur'] = $ligne->nom_utilisateur;
                    $listeUtilisateurs['mailUtilisateur'] = $ligne->mail_utilisateur;
                    $listeUtilisateurs['mdpUtilisateur'] = $ligne->mdp_utilisateur;
                    $listeUtilisateurs['statutUtilisateur'] = $ligne->statut_utilisateur;
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
?>