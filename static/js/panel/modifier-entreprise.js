/* Récupère le texte de la barre de recherche de modification d'une entreprise */
const searchFormU = document.getElementById('EntrepriseM');

/* Récupère le texte de la zone de texte du secteur d'activité de l'entreprise */
const businessSector = document.getElementById('SecteurActivites');

/* Récupère le formulaire de modification d'une entreprise */
const formContainer = document.getElementById("EditForm");

/* Récupère la balise qui va afficher les résultats de la recherche d'entreprise */
const resultList = document.getElementById("resultats");

/* Récupère le contenu de la zone d'affichage de l'autocomplétion des secteurs d'activités */
const sectorResult = document.getElementById("Secteur");

let search;

/* Contient la requête à envoyer à la page php */
let ajax_request;

/* Contient la réponse de la page php */
let response;

function formDisplay() {
    const companyElements = document.querySelectorAll("#CompanyData tbody tr");

    /* Associe chaque ligne du tableau à une fonction qui affiche ou cache le formulaire avec ses informations en fonction de l'entreprise cliquée */
    companyElements.forEach(row => {

        row.addEventListener('click', () => {

            /* les afficher dans les zones de texte du formulaire */
            formContainer.style.display = 'block';

            /* Récupère les zones de texte du formulaire de modification */
            const nomE = document.getElementById("NomE");
            const descrE = document.getElementById("Description");
            const codePE = document.getElementById("CodePostal");
            const lieuAlterE = document.getElementById("LieuAlternance");
            const tailleE = document.getElementById("TailleEntreprise");
            const secteurE = document.getElementById("SecteurActivites");
            const siteE = document.getElementById("SiteInternet");

            /* Récupérer l'id de la ligne */
            id = row.getAttribute('dataID');

            /* Utiliser la page php pour récupérer les informations */
            searchFormU.value = response[id].nom_entreprise;

            nomE.value = response[id].nom_entreprise;
            descrE.value = response[id].description_entreprise;
            codePE.value = response[id].codep_entreprise;
            lieuAlterE.value = response[id].lieu_alter_entreprise;
            tailleE.value = response[id].categorie_entreprise;
            siteE.value = response[id].site_entreprise;
            secteurE.value = response[id].secteur_entreprise;

            resultList.innerHTML = "";
    });
});
}

/* Evènement déclenchant l'autocomplétion de la barre de recherche */
businessSector.addEventListener('keyup', function() {

    sending_request(businessSector, '../../../api/rechercher-secteur.php');
    
    displayTable(businessSector);
});

searchFormU.addEventListener('keyup', function() {

    /* Appelle une fonction envoie une requête à un fichier php */
    sending_request(searchFormU, '../../../api/rechercher-entreprise.php');
    /* fonction permettant d'intercepter la requête et d'afficher le résultat sous forme de tableau */
    ajax_request.onreadystatechange = function() {
        /* Si la requête a fini d'être traitée */
        if (ajax_request.readyState == 4 && ajax_request.status == 200) {

            /* Récupération du resultat de la requête */
            response = JSON.parse(ajax_request.responseText);

            let html = '<table id="CompanyData">'; 

            /*Si la requête renvoie un résultat autre que vide  */
            if (response != "") {
                /* Insertion du résultat de la requête dans un tableau */
                html += '<thead><tr><th>ID</th><th>Nom</th><th>Code Postal</th><th>Lieu de l\'alternance</th><th>site de l\'entreprise</th><th>Secteur de l\'entreprise</th></tr></thead><tbody>';
                for(let i=0; i < response.length; i++) {
                    html += '<form action="modifier-entreprise.php" method="post"><tr class="clickableU" dataID='+i+'><td>'+response[i].id_entreprise+'</td>';
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

            formDisplay();
        }
    }  
    
})