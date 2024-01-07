<?php
    include('../static/module_php/panel/base_de_donnees.php');

    if (isset($_POST["search"])) {
        $pdo = connexionBaseDeDonnees();

        $data[] = array();
        
        $condition = preg_replace('/[^A-Za-z0-9\- ]/','',$_POST["search"]);

        $requete = "SELECT id_entreprise, nom_entreprise, codep_entreprise, description_entreprise, lieu_alter_entreprise, site_entreprise, secteur_entreprise 
                  FROM se_entreprise
                  WHERE nom_entreprise LIKE '%".$condition."%'
                  LIMIT 10";
        
        $resultat = $pdo->query($requete);
    
        foreach($resultat as $row) {
            $data[] = array(
                'id_entreprise' => str_ireplace($condition, $condition, $row["id_entreprise"]),
                'nom_entreprise' => str_ireplace($condition, $condition, $row["nom_entreprise"]),
                'description_entreprise' => $row["description_entreprise"],
                'codep_entreprise' => str_ireplace($condition, $condition, $row["codep_entreprise"]),
                'lieu_alter_entreprise' => str_ireplace($condition, $condition, $row["lieu_alter_entreprise"]),
                'site_entreprise' => str_ireplace($condition, $condition, $row["site_entreprise"]),
                'secteur_entreprise' => str_ireplace($condition, $condition, $row["secteur_entreprise"])
            );
        }
        if (!isset($data)) {
            echo json_encode("");
        } else {
            echo json_encode($data);
        }
        
    }
?>