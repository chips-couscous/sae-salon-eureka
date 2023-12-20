$(document).ready(function(){
    let isInitial = false;

    function headerInitialContent() {
        // Copier le contenu HTML de #HeaderResponsive vers #HeaderInitial et vider #HeaderResponsive
        let headerResponsiveHTML = $('#HeaderResponsive').html();
        $('#HeaderInitial').html(headerResponsiveHTML);
        $('#HeaderResponsive').empty();
        isInitial = false;
    }

    function headerResponsiveContent() {
        // Copier le contenu HTML de #HeaderInitial vers #HeaderResponsive et vider #HeaderInitial
        let headerInitialHTML = $('#HeaderInitial').html();
        $('#HeaderResponsive').html(headerInitialHTML);
        $('#HeaderInitial').empty();
        isInitial = true;
    }

    // Fonction pour gérer le basculement du contenu entre #HeaderInitial et #HeaderResponsive
    function toggleHeaderContent() {
        // Vérifier si la largeur de l'écran est inférieure à 1124 pixels
        if ($(window).width() < 1124) {
            if (!isInitial) {
                headerResponsiveContent();
            }
        } else {
            if (isInitial) {
                headerInitialContent();
            }
        }
    }

    if ($(window).width() < 1124) {
        toggleHeaderContent();
    }

    // Attacher la fonction à l'événement resize de la fenêtre
    $(window).resize(function() {
        toggleHeaderContent();
    });

    // Attacher la fonction au clic sur #Biggachou
    $('#Biggachou').click(function(){
        $(this).toggleClass('eat');
        // Toggle classes pour #HeaderResponsive
        $('#HeaderResponsive').toggleClass('open');
    });
});
