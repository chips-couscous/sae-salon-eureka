<?php

/** @return listeEntreprise contenant la liste des entreprise et leurs différentes informations */
function getListeEntreprise($pdo, $filiereUtilisateur) {
    $requete = $pdo->prepare("SELECT DISTINCT nom_entreprise, codep_entreprise, lieu_alter_entreprise, description_entreprise, logo_entreprise, site_entreprise, nom_secteur, libelle_categorie
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

?>