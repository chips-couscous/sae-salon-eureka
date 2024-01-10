<?php

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