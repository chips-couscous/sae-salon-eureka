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


function informationsTotalesUtilisateurById($pdo, $id) {
    $maRequete = $pdo->prepare ("SELECT 
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
            WHERE se_utilisateur.id_utilisateur = :id
            ");
    // Rajout du parametre manquant à la requête                            
    $maRequete->bindValue(':id', $id);
    //Execution de la requete
    if ($maRequete->execute()) {
        $maRequete->setFetchMode(PDO::FETCH_OBJ);
        //création d'un tableau contenant les informations des utilisateurs
        while ($ligne=$maRequete->fetch()) {			
            $listeUtilisateurs['idUtilisateur'] = $ligne->id_utilisateur;
            $listeUtilisateurs['prenomUtilisateur'] = $ligne->prenom_utilisateur;
            $listeUtilisateurs['nomUtilisateur'] = $ligne->nom_utilisateur;
            $listeUtilisateurs['mailUtilisateur'] = $ligne->mail_utilisateur;
            $listeUtilisateurs['mdpUtilisateur'] = $ligne->mdp_utilisateur;
            $listeUtilisateurs['libelleFiliere'] = $ligne->filieres;
            $listeUtilisateurs['statutUtilisateur'] = $ligne->libelle_statut;
            $listeUtilisateur[] = $listeUtilisateurs;
        }
    }
    // On renvoie la liste des utilisateurs sous forme de tableau
    return $listeUtilisateur;
}