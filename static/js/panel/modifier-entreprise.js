function load_data(search) {
    var form_data = new FormData();

    form_data.append('search', search);

    var ajax_request = new XMLHttpRequest(); 

    ajax_request.open('POST', 'http://localhost/sae-salon-eureka/api/rechercher-entreprise.php');

    ajax_request.send(form_data);

    ajax_request.onreadystatechange = function() {
        if (ajax_request.readyState == 4 && ajax_request.status == 200) {
            var response = JSON.parse(ajax_request.responseText);

            var html = '<table><tr>';

            if (response.length > 0) {
                for(var i=0; i < response.length; i++) {
                    html += '<td>'+response[i].id_entreprise+'<td>'
                            '<td>'+response[i].nom_entreprise+'<td>'
                            '<td>'+response[i].codep_entreprise+'<td>'
                            '<td>'+response[i].lieu_alter_entreprise+'<td>'
                            '<td>'+response[i].site_entreprise+'<td>'
                            '<td>'+response[i].secteur_entreprise+'<td>'
                }
            } else {
                html += '<a href="#">Aucune entreprise trouvée</a>';
            }

            html += '</div>';

            document.getElementById('resultats').innerHTML = html;
        }
    }   
}