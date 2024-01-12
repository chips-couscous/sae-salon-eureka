/* Récupère le texte de la barre de recherche de modification*/
const searchFormD = document.getElementById('EntrepriseS');

/* Récupère la balise qui va afficher les résultats de la recherche */
const resultList = document.getElementById("resultats");

searchFormD.addEventListener('keyup', function() {

    /* Appelle une fonction envoie une requête à un fichier php */
    sending_request(searchFormD, '../../../api/rechercher-entreprise.php');

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
                    html += '<tr class="clickableD" dataID='+i+'><td class="SearchID">'+response[i].id_entreprise+'</td>';
                    html += '<td>'+response[i].nom_entreprise+'</td>';
                    html += '<td>'+response[i].codep_entreprise+'</td>';
                    html += '<td>'+response[i].lieu_alter_entreprise+'</td>';
                    html += '<td>'+response[i].site_entreprise+'</td>';
                    html += '<td>'+response[i].secteur_entreprise+'</td>';
                    html += '<td><form action="supprimer-entreprise.php" method="post"><input type="submit" value="Supprimer" id="Bouton nSuppression"/></form></td></tr>';
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