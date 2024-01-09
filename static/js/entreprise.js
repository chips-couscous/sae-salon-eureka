$(document).ready(function() {
    // Au survol de l'entreprise-container
    $('.entreprise-container').hover(function() {
        // Récupérer la description-container à l'intérieur de cette carte-entreprise
        let descriptionContainer = $(this).find('.description-container');
        let descriptionContent = descriptionContainer.find('.description-content');
        // Vérifier si la hauteur de la description est supérieure à 135px
        if (descriptionContent.height() >= 130) {
            // Ajouter la classe de défilement à la description-content
            descriptionContent.addClass('defilement');
        }
    }, function() {
        // Au survol sortant, enlever la classe de défilement
        $(this).find('.description-content').removeClass('defilement');
    });

    // Ajouter un événement de changement à l'élément select avec l'id CategorieFiltre
    $('#CategorieFiltre').change(function() {
        // Récupérer la valeur sélectionnée
        let categorieValue = $(this).val();

        // Vérifier si la valeur est non vide et si le filtre n'existe pas déjà
        if (categorieValue !== "" && !filtreExisteDeja(categorieValue)) {
            // Créer un nouvel élément span avec la classe 'filtre-actif'
            let nouveauFiltre = $('<span>', {
                class: 'filtre-actif'
            });

            // Ajouter le texte de la catégorie à l'élément span
            nouveauFiltre.append($('<span>', {text: categorieValue}));

            // Créer un élément span pour la croix de suppression
            let croixSuppression = $('<i>', {
                class: 'fa-solid fa-xmark croix-suppression',
                text: ''
            });

            // Ajouter un gestionnaire de clic pour supprimer le filtre
            croixSuppression.click(function() {
                $(this).parent().remove(); // Supprimer le parent (le filtre)
            });

            // Ajouter la croix à l'élément span
            nouveauFiltre.append(croixSuppression);

            // Ajouter le nouvel élément span à l'élément avec l'id FiltresActifs
            $('#FiltresActifs').append(nouveauFiltre);
        }
    });

    // Fonction pour vérifier si le filtre existe déjà
    function filtreExisteDeja(nouveauFiltre) {
        let filtresActifs = $('#FiltresActifs .filtre-actif span');
        let existeDeja = false;

        filtresActifs.each(function() {
            if ($(this).text() === nouveauFiltre) {
                existeDeja = true;
                return false; // Sortir de la boucle each dès qu'on a trouvé un filtre identique
            }
        });

        return existeDeja;
    }

    // Attacher la fonction au clic sur #AjouterFiltres
    $('#AjouterFiltres').click(function() {
        // Basculer la classe 'active' sur l'élément #ChoixFiltres
        $('#ChoixFiltres').toggleClass('active');
    });

    $('.entreprise-container').click(function() {
        $(this).find('.carte-entreprise').toggleClass('turn')
    });
});


const rechercheEntreprise = document.getElementById("RechercheEntreprise");

const listeEntreprise = document.getElementById("ListeE");

rechercheEntreprise.addEventListener('keyup', function() {

    console.log(this.value);
    /* Récupération du texte de la barre de recherche */
    search = this.value;

    /* Création d'un objet FormData */
    var form_data = new FormData();

    /* On l'associe à la clé search le texte récupéré */
    form_data.append('search', search);

    /* Création d'un objet XMLHttpRequest */
    ajax_request = new XMLHttpRequest(); 

    /* Adresse une requête au fichier php demandé en paramètre avec la méthode POST */
    ajax_request.open('POST', 'api/rechercher-entreprise.php');

    /* Envoi de la requête */
    ajax_request.send(form_data);
    
    /* fonction permettant d'intercepter la requête et d'afficher le résultat sous forme de tableau */
    ajax_request.onreadystatechange = function() {
        /* Si la requête a fini d'être traitée */
        if (ajax_request.readyState == 4 && ajax_request.status == 200) {

            /* Récupération du resultat de la requête */
            response = JSON.parse(ajax_request.responseText);

            let html = "";

            /*Si la requête renvoie un résultat autre que vide  */
            if (response != "") {
                /* Insertion du résultat de la requête dans une case */
                for(let i=0; i < response.length; i++) {
                    html += '<div class="carte">';
                    html += '<div class="entreprise-container"><div class="carte-entreprise">';
                    html +=  '<div class="recto"><div class="identite">';
                    html += '<img src="static/img/logo_entreprise/'+response[i].logo_entreprise+'" alt="Logo '+response[i].nom_entreprise+'" draggable="false">';
                    html += '<span>'+response[i].nom_entreprise+'</span></div>';
                    html += '<div class="tags">';
                    html += '<span><i class="fa-solid fa-location-dot"></i>'+response[i].nom_entreprise+'</span>';
                    html += '<span><i class="fa-solid fa-tag"></i>'+response[i].secteur_entreprise+'</span>';
                    html += '<span><i class="fa-solid fa-users"></i>'+response[i].categorie_entreprise+'</span></div></div>';
                    html += '<div class="verso"><div class="description-container"><div class="description-content">'+response[i].description_entreprise+'</div></div>';
                    html += '<div class="fin-verso"><div class="lien-site"><a href="#" class="hover-underline-active">'+response[i].site_entreprise+'</a></div>';    
                    html += '<div class="btn-souhait"><span>Ajouter aux souhaits</span></div></div></div></div></div></div>';   
                }
            } else {
                html += '<span>Aucune entreprise trouvée</span>';
            }

            /* Affiche le tableau sur l'écran*/
            listeEntreprise.innerHTML = html;
        }
    }   
});