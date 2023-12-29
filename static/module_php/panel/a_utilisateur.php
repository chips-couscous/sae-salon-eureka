<?php
include ('base_de_donnees.php');
$pdo = connexionBaseDeDonnees();

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
function insererBD($tableauUtilisateurs) {
    global $pdo;

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
