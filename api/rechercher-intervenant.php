<?php
require "../static/module_php/panel/base_de_donnees.php";

$pdo = connexionBaseDeDonnees();

try {
    $nom = isset($_REQUEST['nom']) ? $_REQUEST['nom'] . "%" : "";
    $entreprise = isset($_REQUEST['entreprise']) ? $_REQUEST['entreprise'] . "%" : "";
    $params = array();
    
    $sql = "SELECT se_intervenant.nom_intervenant AS nom, 
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
            WHERE 1";
    
    if (!empty($nom)) {
        $sql .= " AND se_intervenant.nom_intervenant LIKE :nom";
        $params["nom"] = $nom;
    }
    if (!empty($entreprise)) {
        $sql .= " AND se_entreprise.nom_entreprise LIKE :entreprise";
        $params["entreprise"] = $entreprise;
    }

    $sql .= " ORDER BY se_intervenant.nom_intervenant 
             LIMIT 0, 25";

    // Préparation de la requête avec des paramètres nommés
    $req = $pdo->prepare($sql);

    // Liaison des valeurs aux paramètres
    $req->bindParam(":nom", $params["nom"]);
    $req->bindParam(":entreprise", $params["entreprise"]);

    $req->execute();

    $intervenant = $req->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($intervenant);
} catch (\Throwable $th) {
    // Gestion des erreurs
}