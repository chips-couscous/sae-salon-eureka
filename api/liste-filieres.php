<?php
require './../static/module_php/panel/base_de_donnees.php';

$pdo = connexionBaseDeDonnees();

try {	
    // REquete avec agrégats pour calculer le solde
    $maRequete = $pdo->prepare("
    SELECT DISTINCT se_filiere.libelle_filiere AS filiere
    FROM se_filiere 
    ORDER BY se_filiere.libelle_filiere ;");
    if ($maRequete->execute()) {
        echo json_encode($maRequete->fetchAll());
    }
}
catch ( Exception $e ) {
    echo null;
}