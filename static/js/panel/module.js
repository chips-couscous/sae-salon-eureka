/* Fonction qui récupère les données des entreprises liées au texte de la barre de recherche */
function sending_request(button, phpPath) {

    /* Récupération du texte de la barre de recherche */
    search = button.value;

    /* Création d'un objet FormData */
    var form_data = new FormData();

    /* On l'associe à la clé search le texte récupéré */
    form_data.append('search', search);

    /* Création d'un objet XMLHttpRequest */
    ajax_request = new XMLHttpRequest(); 

    /* Adresse une requête au fichier php demandé en paramètre avec la méthode POST */
    ajax_request.open('POST', phpPath);

    /* Envoi de la requête */
    ajax_request.send(form_data);
}