<?php

/** @return listeEntreprise contenant la liste des entreprise et leurs différentes informations */
function getListeEntreprise($pdo, $filiereUtilisateur) {
    $requete = $pdo->prepare("SELECT DISTINCT id_entreprise, nom_entreprise, codep_entreprise, lieu_alter_entreprise, description_entreprise, logo_entreprise, site_entreprise, nom_secteur, libelle_categorie
                                FROM se_entreprise
                                INNER JOIN se_secteur
                                ON se_secteur.id_secteur = se_entreprise.secteur_entreprise
                                INNER JOIN se_categorie
                                ON se_categorie.id_categorie = se_entreprise.categorie_entreprise
                                INNER JOIN se_intervenant
                                ON entreprise_intervenant = id_entreprise
                                INNER JOIN se_intervient 
                                ON id_intervenant = intervenant_intervient
                                WHERE filiere_intervient = $filiereUtilisateur;");

    $requete->execute();
    $listeEntreprise = $requete->fetchAll();

    return $listeEntreprise;
}

/** Ajoute l'entreprise et l'utilisateur dont les id sont passés en paramètre dans la liste des souhaits */
function ajouterAuxSouhaits($pdo, $idEntreprise, $idUtilisateur) {
    $requete = $pdo->prepare("INSERT INTO se_souhait (id_utilisateur, id_entreprise) VALUES (:idU, :idE)");
    $pdo->beginTransaction();
    $requete->bindParam("idU", $idUtilisateur);
    $requete->bindParam("idE", $idEntreprise);
    try {
        $requete->execute();
        $pdo->commit();
    } catch (PDOException $e) {
        $pdo->rollback();
    }
}

/** Ajoute l'entreprise et l'utilisateur dont les id sont passés en paramètre dans la liste des souhaits */
function retirerDesSouhaits($pdo, $idEntreprise, $idUtilisateur) {
    $requete = $pdo->prepare("DELETE FROM se_souhait WHERE id_entreprise = :idE AND id_utilisateur = :idU");
    $pdo->beginTransaction();
    $requete->bindParam("idU", $idUtilisateur);
    $requete->bindParam("idE", $idEntreprise);
    try {
        $requete->execute();
        $pdo->commit();
    } catch (PDOException $e) {
        $pdo->rollback();
    }
}

/** @return true si l'utilisateur l'entreprise dans sa liste de souhaits */
function estSouhait($pdo, $idEntreprise, $idUtilisateur) {
    $requete = $pdo->prepare("SELECT id_utilisateur, id_entreprise FROM se_souhait");
    try {
        $requete->execute();
        $listeSouhait = $requete->fetchAll();
        foreach($listeSouhait as $souhait) {
            if ($souhait['id_utilisateur'] == $idUtilisateur && $souhait['id_entreprise'] == $idEntreprise) {
                return true;
            }
        }
    } catch (PDOException $e) {
        return false;
    }
}

?>