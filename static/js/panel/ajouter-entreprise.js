/* Récupère le texte de la barre d'ajout de secteur d'activites*/
const searchFormA = document.getElementById('SecteurActivites');

/* Récupère le contenu de la zone d'affichage de l'autocomplétion */
const sectorResult = document.getElementById("Secteur");

let search;

/* Contient la requête à envoyer à la page php */
let ajax_request;

/* Contient la réponse de la page php */
let response;

searchFormA.addEventListener('keyup', function() {

    /* Appelle une fonction envoie une requête à un fichier php */
    sending_request(searchFormA, '../../../api/rechercher-secteur.php');

    displayTable(searchFormA);
});

