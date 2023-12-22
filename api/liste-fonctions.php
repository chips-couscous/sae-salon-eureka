<?php
require './../static/module_php/panel/base_de_donnees.php';

$pdo = connexionBaseDeDonnees();

try {	
    // REquete avec agrégats pour calculer le solde
    $maRequete = $pdo->prepare("
    SELECT DISTINCT se_intervenant.fonction_intervenant AS fonction
    FROM se_intervenant 
    ORDER BY se_intervenant.fonction_intervenant ;");
    if ($maRequete->execute()) {
        echo json_encode($maRequete->fetchAll());
    }
}
catch ( Exception $e ) {
    echo null;
}