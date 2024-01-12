<?php
header('Access-Control-Allow-Origin: *');
require "../static/module_php/base_de_donnees.php";

$pdo = connexionBaseDeDonnees();

try {
    $idUtilisateurRecherche = $_REQUEST['idUtilisateur'] ?? isset($_REQUEST['idUtilisateur']);
    $params = array();
    
    $sql = "SELECT DISTINCT se_entreprise.id_entreprise, nom_entreprise, codep_entreprise, lieu_alter_entreprise, description_entreprise, logo_entreprise, site_entreprise, nom_secteur, libelle_categorie
                FROM se_entreprise
                INNER JOIN se_secteur
                ON se_secteur.id_secteur = se_entreprise.secteur_entreprise
                INNER JOIN se_categorie
                ON se_categorie.id_categorie = se_entreprise.categorie_entreprise
                INNER JOIN se_souhait
                ON se_souhait.id_entreprise = se_entreprise.id_entreprise
                WHERE 1";
    
    if (!empty($idUtilisateurRecherche)) {
        $sql .= " AND se_souhait.id_utilisateur = :idUtilisateur";
        $params["idUtilisateur"] = $idUtilisateurRecherche;
    }    
    
    $req = $pdo->prepare($sql);
    
    $req->execute($params);

    $utilisateur = $req->fetchAll();

    

    echo json_encode($utilisateur);
} catch (\Throwable $th) {
    // Gestion des erreurs
}
