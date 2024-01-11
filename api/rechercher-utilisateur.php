<?php
require "../static/module_php/base_de_donnees.php";

$pdo = connexionBaseDeDonnees();

try {
    $prenom = isset($_REQUEST['prenom']) ? $_REQUEST['prenom'] . "%" : "";
    $statut = isset($_REQUEST['statut']) ? $_REQUEST['statut'] : "";
    $filiere = isset($_REQUEST['filiere']) ? $_REQUEST['filiere'] : "";
    $params = array();
    
    $sql = "SELECT 
                se_utilisateur.id_utilisateur,
                se_utilisateur.prenom_utilisateur,
                se_utilisateur.nom_utilisateur,
                se_utilisateur.mail_utilisateur,
                se_utilisateur.mdp_utilisateur,
                GROUP_CONCAT(DISTINCT se_filiere.libelle_filiere ORDER BY se_filiere.libelle_filiere SEPARATOR ', ') AS filieres,
                se_statut.libelle_statut
            FROM se_utilisateur
            INNER JOIN se_statut ON se_utilisateur.statut_utilisateur = se_statut.id_statut
            INNER JOIN se_appartient ON se_utilisateur.id_utilisateur = se_appartient.utilisateur_appartient
            INNER JOIN se_filiere ON se_appartient.filiere_appartient = se_filiere.id_filiere
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
        $sql .= " AND (
                        se_appartient.filiere_appartient = :filiere
                        OR se_utilisateur.id_utilisateur IN (
                            SELECT utilisateur_appartient
                            FROM se_appartient
                            WHERE  filiere_appartient = :filieres
                        )
                    )";

        $params["filiere"] = $filiere;
        $params["filieres"] = $filiere;
    }

    $sql .= " GROUP BY se_utilisateur.id_utilisateur";

    
    
    $req = $pdo->prepare($sql);
    
    $req->execute($params);

    $utilisateur = $req->fetchAll();

    

    echo json_encode($utilisateur);
} catch (\Throwable $th) {
    // Gestion des erreurs
}
