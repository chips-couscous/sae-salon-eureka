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