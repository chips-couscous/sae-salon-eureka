<?php
function informationsPrimairesUtilisateurById($pdo, $id) {
    $sql = "SELECT nom_utilisateur, prenom_utilisateur, libelle_statut
            FROM se_utilisateur 
            INNER JOIN se_statut
            ON statut_utilisateur = id_statut
            WHERE id_utilisateur = :id";
    $req = $pdo->prepare($sql);
    $req->bindParam("id", $id);
    $req->execute();

    $utilisateur = $req->fetch();
    return $utilisateur;
}

/** @return filiereUtilisateur la filiere de l'utilisateur */
function getFiliereUtilisateur($pdo, $idUtilisateur) {
    $requete = $pdo->prepare("SELECT filiere_appartient
                                FROM se_appartient
                                INNER JOIN se_utilisateur
                                ON utilisateur_appartient = id_utilisateur
                                WHERE id_utilisateur = :idU");
    $requete->bindParam("idU", $idUtilisateur);
    $requete->execute();
    $filiereUtilisateur = $requete->fetch()['filiere_appartient'];
    return $filiereUtilisateur;
}