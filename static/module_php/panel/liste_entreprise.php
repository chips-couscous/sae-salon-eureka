<?php

/** @return listeEntreprise contenant la liste des entreprise et leurs différentes informations */
function getListeEntreprise($pdo) {
    $requete = $pdo->prepare("SELECT nom_entreprise, codep_entreprise, lieu_alter_entreprise, description_entreprise, logo_entreprise, site_entreprise, nom_secteur, libelle_categorie
                                FROM se_entreprise
                                INNER JOIN se_secteur
                                ON se_secteur.id_secteur = se_entreprise.secteur_entreprise
                                INNER JOIN se_categorie
                                ON se_categorie.id_categorie = se_entreprise.categorie_entreprise;");

    $requete->execute();
    $listeEntreprise = $requete->fetchAll();

    return $listeEntreprise;
}

?>