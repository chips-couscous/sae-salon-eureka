<?php
require './../static/module_php/panel/base_de_donnees.php';

$pdo = connexionBaseDeDonnees();

try {	
    // REquete avec agrégats pour calculer le solde
    $maRequete = $pdo->prepare("
    SELECT DISTINCT se_entreprise.nom_entreprise AS entreprise
    FROM se_entreprise 
    ORDER BY se_entreprise.nom_entreprise ;");
    if ($maRequete->execute()) {
        echo json_encode($maRequete->fetchAll());
    }
}
catch ( Exception $e ) {
    echo null;
}