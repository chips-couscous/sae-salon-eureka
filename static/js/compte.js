$(document).ready(function() {
    $('.titre-navigation-asyde').click(function() {
        // Cible la liste déroulante suivante (nav ul)
        let navList = $(this).next('nav').find('ul');
        let iconArrow = $(this).find('i');

        iconArrow.toggleClass('open');

        // Bascule la visibilité de la liste déroulante
        navList.slideToggle();
    });

    $('#clickToOpenPanel').click(function() {
        $('.container-asyde').toggleClass('panel-open');
        $('.container-asyde').scrollTop(0);
        $('.container-content').toggleClass('panel-close');
    });
});