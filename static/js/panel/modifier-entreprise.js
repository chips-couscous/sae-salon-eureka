/* Récupère le texte de la barre de recherche */
const searchForm = document.getElementById('Entreprise');
const companyElements = document.querySelectorAll("tbody tr");

/* Récupère les zones de texte du formulaire de modification */
const nomE = document.getElementById("NomE");
const descrE = document.getElementById("Description");
const codePE = document.getElementById("CodePostal");
const lieuAlterE = document.getElementById("LieuAlternance");
const tailleE = document.getElementById("TailleEntreprise");
const secteurE = document.getElementById("SiteInternet");
const siteE = document.getElementById("SecteurActivites");

/* Récupère le formulaire de modification */
const formContainer = document.getElementById("EditForm");

/* Récupère la balise qui va afficher les résultats de la recherche */
const resultList = document.getElementById("resultats");

let clicked = true;
let search;

/* Contient la requête à envoyer à la page php */
let ajax_request;

/* Contient la réponse de la page php */
let response;

/* Fonction qui récupère les données des entreprises liées au texte de la barre de recherche */
function sending_request(phpPath) {

    /* Récupération du texte de la barre de recherche */
    search = searchForm.value;

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

/* Associe chaque ligne du tableau à une fonction qui affiche ou cache le formulaire avec ses informations en fonction de l'entreprise cliquée */
companyElements.forEach(row => {
    console.log(this);
    /* Récupérer l'id de la ligne */
    id = row.getAttribute('dataID');

    row.addEventListener('click', function() {
        console.log("j'appuie");

        /* Utiliser la page php pour récupérer les informations */
        nomE.innerHTML = response[id].nom_entreprise;
        descrE.innerHTML = response[id].description_entreprise;
        codePE.innerHTML = response[id].codep_entreprise;
        lieuAlterE.innerHTML = response[id].lieu_alter_entreprise;
        siteE = response[id].site_entreprise;
        secteurE.innerHTML = response[id].secteur_entreprise;
        /* les afficher dans les zones de texte du formulaire */
        /*console.log("j'appuie");
        if (clicked) {
            formContainer.style.display = 'block';
            clicked = false;

        } else {
            formContainer.style.display = 'none';
            clicked = true;
        }*/
    });
});

/* Evènement déclenchant l'autocomplétion de la barre de recherche */
searchForm.addEventListener('keyup', function() {

    sending_request('../../../api/rechercher-entreprise.php');
    
    /* fonction permettant d'intercepter la requête et d'afficher le résultat sous forme de tableau */
    ajax_request.onreadystatechange = function() {
        /* Si la requête a fini d'être traitée */
        if (ajax_request.readyState == 4 && ajax_request.status == 200) {

            /* Récupération du resultat de la requête */
            response = JSON.parse(ajax_request.responseText);

            let html = '<table>'; 

            /*Si la requête renvoie un résultat autre que vide  */
            if (response != "") {

                /* Insertion du résultat de la requête dans un tableau */
                html += '<thead><tr><th>ID</th><th>Nom</th><th>Code Postal</th><th>Lieu de l\'alternance</th><th>site de l\'entreprise</th><th>Secteur de l\'entreprise</th></tr></thead><tbody>';
                for(let i=0; i < response.length; i++) {
                    html += '<tr class="clickable" dataID='+i+'><td class="SearchID">'+response[i].id_entreprise+'</td>';
                    html += '<td>'+response[i].nom_entreprise+'</td>';
                    html += '<td>'+response[i].codep_entreprise+'</td>';
                    html += '<td>'+response[i].lieu_alter_entreprise+'</td>';
                    html += '<td>'+response[i].site_entreprise+'</td>';
                    html += '<td>'+response[i].secteur_entreprise+'</td></tr>';
                }
            } else {
                html += '<tbody><tr><td>Aucune entreprise trouvée</td></tr>';
            }

            html += '</tbody></table>';

            /* Affiche le tableau sur l'écran*/
            resultList.innerHTML = html;
        }
    }   
});

