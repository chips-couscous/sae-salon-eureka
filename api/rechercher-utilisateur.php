<?php
require "../static/module_php/panel/base_de_donnees.php";

$pdo = connexionBaseDeDonnees();

try {
    $prenom = isset($_REQUEST['prenom']) ? $_REQUEST['prenom'] . "%" : "";
    $statut = isset($_REQUEST['statut']) ? $_REQUEST['statut'] : "";
    $filiere = isset($_REQUEST['filiere']) ? $_REQUEST['filiere'] : "";
    $params = array();
    
    $sql = "SELECT id_utilisateur, prenom_utilisateur, nom_utilisateur, mail_utilisateur, mdp_utilisateur, libelle_filiere, libelle_statut 
            FROM se_utilisateur
            INNER JOIN se_statut
            ON se_utilisateur.statut_utilisateur = se_statut.id_statut
            INNER JOIN se_appartient
            ON se_utilisateur.id_utilisateur = se_appartient.utilisateur_appartient
            INNER JOIN se_filiere
            ON se_appartient.filiere_appartient = se_filiere.id_filiere
            WHERE 1";
    
    if (!empty($prenom)) {
        $sql .= " AND prenom_utilisateur LIKE :prenom";
        $params["prenom"] = $prenom;
    }
    if (!empty($statut)) {
        $sql .= " AND se_statut.id_statut = :statut";
        $params["statut"] = $statut;
    }
    // Ajout de conditions supplémentaires pour la filière, si nécessaire
    if (!empty($filiere)) {
        $sql .= " AND se_filiere.id_filiere = :filiere";
        $params["filiere"] = $filiere;
    }
    
    $req = $pdo->prepare($sql);
    $req->execute($params);
    
    $utilisateur = $req->fetchAll();

    echo json_encode($utilisateur);
} catch (\Throwable $th) {
    // Gestion des erreurs
}