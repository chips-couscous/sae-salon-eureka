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

function displayTable(searchForm) {
    /* fonction permettant d'intercepter la requête et d'afficher le résultat sous forme de tableau */
    ajax_request.onreadystatechange = function() {
        /* Si la requête a fini d'être traitée */
        if (ajax_request.readyState == 4 && ajax_request.status == 200) {

            /* Récupération du resultat de la requête */
            response = JSON.parse(ajax_request.responseText);

            let html = ''; 

            /*Si la requête renvoie un résultat autre que vide  */
            if (response != "") {
                html = '<table id="DataS">';
                /* Insertion du résultat de la requête dans un tableau */
                html += '<tbody>';
                for(let i=0; i < response.length; i++) {
                    console.log(response[i].nom_secteur);
                    html += '<tr class="clickableU" dataID='+i+'><td>'+response[i].nom_secteur+'</td></tr>';
                }
                html += '</tbody></table>';
            } 

            /* Affiche le tableau sur l'écran*/
            sectorResult.innerHTML = html;

            hideSector(searchForm);
        }
    }   
}

function hideSector(searchForm) {
    const businessSector = document.querySelectorAll("#DataS tbody tr");

    /* Associe chaque ligne du tableau à une fonction qui enlève le contenu du tableau */
    businessSector.forEach(row => {

        row.addEventListener('click', () => {

            /* Récupérer l'id de la ligne */
            id = row.getAttribute('dataID');

            /* Utiliser la page php pour récupérer les informations */
            searchForm.value = response[id].nom_secteur;

            sectorResult.innerHTML = "";
    });
});
}