<?php
require "../static/module_php/panel/base_de_donnees.php";

$pdo = connexionBaseDeDonnees();
try {
    $nom = isset($_REQUEST['nom']) ? $_REQUEST['nom'] : "";
    $fonction = isset($_REQUEST['fonction']) ? $_REQUEST['fonction'] : "";
    $entreprise = isset($_REQUEST['entreprise']) ? $_REQUEST['entreprise'] : "";
    $filiere = isset($_REQUEST['filiere']) ? $_REQUEST['filiere'] : "";    
    $id = isset($_REQUEST['id']) ? $_REQUEST['id'] : "";    

    // Début de la transaction
    $pdo->beginTransaction();

    // Première requête
    $sql = "UPDATE se_intervenant
            SET nom_intervenant = :nom,
                fonction_intervenant = :fonction
            WHERE id_intervenant = :id";

    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':nom', $nom);
    $stmt->bindParam(':fonction', $fonction);
    $stmt->bindParam(':id', $id);
    $stmt->execute();

    // Deuxième requête
    $sql = "UPDATE se_intervenant
            SET entreprise_intervenant = (
                SELECT id_entreprise 
                FROM se_entreprise 
                WHERE nom_entreprise LIKE :entreprise
            )
            WHERE id_intervenant = :id";

    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':entreprise', $entreprise);
    $stmt->bindParam(':id', $id);
    $stmt->execute();

    // Troisième requête
    $sql = "UPDATE se_intervient
            SET filiere_intervient = (
                SELECT id_filiere 
                FROM se_filiere 
                WHERE libelle_filiere LIKE :filiere
            )
            WHERE intervenant_intervient = :id";

    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':filiere', $filiere);
    $stmt->bindParam(':id', $id);
    $stmt->execute();

    // Commit de la transaction
    $pdo->commit();

    echo "Mise à jour réussie.";

} catch (\Throwable $th) {
    // En cas d'erreur, annuler la transaction
    $pdo->rollBack();
    echo "Erreur lors de la mise à jour : " . $th->getMessage();
}