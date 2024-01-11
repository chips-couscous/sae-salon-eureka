<?php
function informationsPrimairesUtilisateurById($pdo, $id) {
    $sql = "SELECT nom_utilisateur, prenom_utilisateur, libelle_statut
            FROM se_utilisateur 
            INNER JOIN se_statut
            ON statut_utilisateur = id_statut
            WHERE id_utilisateur = :id";
    $req = $pdo->prepare($sql);
    $req->bindParam("id", $id);
    $req->execute();

    $utilisateur = $req->fetch();
    return $utilisateur;
}

/** @return filiereUtilisateur la filiere de l'utilisateur */
function getFiliereUtilisateur($pdo, $idUtilisateur) {
    $requete = $pdo->prepare("SELECT filiere_appartient
                                FROM se_appartient
                                INNER JOIN se_utilisateur
                                ON utilisateur_appartient = id_utilisateur
                                WHERE id_utilisateur = :idU");
    $requete->bindParam("idU", $idUtilisateur);
    $requete->execute();
    $filiereUtilisateur = $requete->fetch()['filiere_appartient'];
    return $filiereUtilisateur;
}

/** @return listeSouhaits la liste des souhaits de l'utilisateur */
function getListeSouhait($pdo, $idUtilisateurRecherche) {
    $requete = $pdo->prepare("SELECT DISTINCT se_entreprise.id_entreprise, nom_entreprise, codep_entreprise, lieu_alter_entreprise, description_entreprise, logo_entreprise, site_entreprise, nom_secteur, libelle_categorie
                               	FROM se_entreprise
                                INNER JOIN se_secteur
                                ON se_secteur.id_secteur = se_entreprise.secteur_entreprise
                                INNER JOIN se_categorie
                                ON se_categorie.id_categorie = se_entreprise.categorie_entreprise
                                INNER JOIN se_souhait
                                ON se_souhait.id_entreprise = se_entreprise.id_entreprise
                                WHERE se_souhait.id_utilisateur = $idUtilisateurRecherche;");

    $requete->execute();
    $listeSouhaits = $requete->fetchAll();

    return $listeSouhaits;
}