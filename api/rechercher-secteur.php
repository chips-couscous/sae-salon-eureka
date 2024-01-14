<?php
    include('../static/module_php/panel/base_de_donnees.php');

    $pdo = connexionBaseDeDonnees();

    $data[] = array();
        
    $condition = preg_replace('/[^A-Za-z0-9\- ]/','',$_POST["search"]);

    $requete = "SELECT *
              FROM se_secteur
              WHERE nom_secteur LIKE '%".$condition."%'";
        
    $resultat = $pdo->prepare($requete);
    $resultat->execute();
        
    
    foreach($resultat as $secteur) {

        $data[] = array(
            'id_secteur' => $secteur["id_secteur"],
            'nom_secteur' => $secteur["nom_secteur"]
            
        );
    }
    if (!isset($data)) {
        echo json_encode("");
    } else {
        echo json_encode($data);
    }
?>