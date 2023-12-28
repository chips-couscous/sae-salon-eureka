<?php
    include('../static/module_php/panel/base_de_donnees.php');

    if (isset($_POST["search"])) {
        $pdo = connexionBaseDeDonnees();

        $donnees = array();

        $condition = preg_replace('/[^A-Za-z0-9\- ]/','',$_POST["resultats"]);

        $requete = "SELECT id_entreprise, nom_entreprise, codep_entreprise, lieu_alter_entreprise, site_entreprise, secteur_entreprise 
                  FROM se_entreprise
                  WHERE nom_entreprise LIKE '%".$condition."%'
                  LIMIT 10";
        
        $resultat = $pdo->prepare($requete);

        $replace_string = $condition;
        foreach($resultat as $row) {
            $data[] = array(
                'id_entreprise' => str_ireplace($condition, $replace_string, $row["id_entreprise"]),
                'nom_entreprise' => str_ireplace($condition, $replace_string, $row["nom_entreprise"]),
                'codep_entreprise' => str_ireplace($condition, $replace_string, $row["codep_entreprise"]),
                'lieu_alter_entreprise' => str_ireplace($condition, $replace_string, $row["lieu_alter_entreprise"]),
                'site_entreprise' => str_ireplace($condition, $replace_string, $row["site_entreprise"]),
                'secteur_entreprise' => str_ireplace($condition, $replace_string, $row["secteur_entreprise"])
            );
        }

        echo json_encode($data);
    }
?>