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