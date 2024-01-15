<?php

/* Fonction qui renvoie la date du forum sous forme écrite */
function getDateForum($pdo) {
    global $pdo;
    $datesForum = array();

    /* Requete pour récupérer les dates du forum */
    $requete = $pdo->prepare("SELECT date_deb_forum, date_fin_forum FROM se_forum");
    if ($requete->execute()) {
        $requete->setFetchMode(PDO::FETCH_OBJ);
        while ($ligne = $requete->fetch()) {			
            $dateDebut = new DateTime($ligne->date_deb_forum);
            $dateFin = new DateTime($ligne->date_fin_forum);

            $datesForum[] = array(
                'dateDebut' => $dateDebut->format('d F Y'),
                'dateFin' => $dateFin->format('d F Y')
            );
        }
    }

    return $datesForum;
}
?>
