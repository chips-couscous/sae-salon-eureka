<?php
    include('../static/module_php/panel/base_de_donnees.php');

    $pdo = connexionBaseDeDonnees();

    $data[] = array();
        
    $condition = preg_replace('/[^A-Za-z0-9\- ]/','',$_POST["search"]);

    $requete = "SELECT *
              FROM se_entreprise
              WHERE nom_entreprise LIKE '%".$condition."%'";
        
    $resultat = $pdo->prepare($requete);
    $resultat->execute();
        
    
    foreach($resultat as $row) {

        $requete = "SELECT nom_secteur
                    FROM se_secteur
                    WHERE id_secteur = :idS";
        $stmt = $pdo->prepare($requete);
        $stmt->bindParam("idS", $row["secteur_entreprise"]);
        $stmt->execute();
        $secteurEntreprise = $stmt->fetch();

        $data[] = array(
            'id_entreprise' => $row["id_entreprise"],
            'nom_entreprise' => $row["nom_entreprise"],
            'logo_entreprise' => $row["logo_entreprise"],
            'description_entreprise' => $row["description_entreprise"],
            'codep_entreprise' => $row["codep_entreprise"],
            'lieu_alter_entreprise' => $row["lieu_alter_entreprise"],
            'site_entreprise' => $row["site_entreprise"],
            'secteur_entreprise' => $secteurEntreprise['nom_secteur'],
            'categorie_entreprise' => $row['categorie_entreprise']
        );
    }
    if (!isset($data)) {
        echo json_encode("");
    } else {
        echo json_encode($data);
    }
?>