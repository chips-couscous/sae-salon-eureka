<?php
function verifierUneConnexionUtilisateur($pdo) {;
    $identifiant = isset($_POST['identifiant']) ? $_POST['identifiant'] : null;
    $motDePasse = isset($_POST['motDePasse']) ? $_POST['motDePasse'] : null;

    if($identifiant != null && $motDePasse != null) {
        try {
            $sql = "SELECT id_utilisateur FROM se_utilisateur WHERE mail_utilisateur = :mail AND mdp_utilisateur = :mdp";
            $req = $pdo->prepare($sql);
            $req->bindParam('mail', $identifiant);
            $req->bindParam('mdp', $motDePasse);
            $req->execute();

            $idUtilisateur = $req->fetch()['id_utilisateur'];
            return $idUtilisateur;
        } catch (Exception $e) {
            return null;
        }
    }
    return null;
}

function validerUneSessionUtilisateur($idUtilisateur) {
    $_SESSION['estConnecte'] = $idUtilisateur != null;
    $_SESSION['idUtilisateur'] = $idUtilisateur;

    return $_SESSION['estConnecte'];
}