/* Déclaration des variables */
var btnAjouterManuel = document.getElementById("ajouterIntervenant"); // Bouton Ajouter sur la page
var zoneSaisieNom = document.getElementById("nom"); // Zone de saisie du nom
var zoneSaisieFonction = document.getElementById("fonction"); // Selection de la fonction
var zoneSaisieEntreprise = document.getElementById("selectionEntreprise"); // Selection de l'entreprise
var zoneSaisieFiliere = document.getElementById("filiere"); // Selection de la filiere 
var zonePrevisualisation = document.getElementById("TablePrevisualisation"); // Table contenant les intervenants qui vont être ajoutés
var body = document.body; // Body de la page

var tableauIntervenants = []; // tableau contenant les intervenants qui vont être ajoutés
var nomCorrect; // Booléen vérifiant la validité du nom
var fonctionCorrect; // Booléen vérifiant la validité de la fonction
var entrepriseCorrect; // Booléen vérifiant la validité de l'entreprise
var filiereCorrect; // Booléen vérifiant la validité de la filiere

var entrepriseSelectionnee; // Variable contenant l'entreprise pour lequel l'ajout sera fait

// Selection de l'entreprise pour l'ajout
var selectionEntreprise = document.getElementById("selectionEntreprise");

// Ecouteur d'évènement qui se déclenche lorsqu'une entreprise est selectionne - Appelle afficherChamps()
selectionEntreprise.addEventListener("change", afficherChamps);

/* Ajout d'eventListener sur le pre-ajout */
btnAjouterManuel.addEventListener("click", ajouterIntervenantManuel);

/* Si données déjà présentes dans cookie -> récupération */
if (document.cookie != null) {
    let contenuCookie = readCookie("intervenants");
    if (contenuCookie != null) {
        tableauIntervenants = JSON.parse(contenuCookie);
        if (typeof tableauIntervenants != 'object') {
            tableauIntervenants = [];
        }
        afficherIntervenant();
    }
}

// Zone de saisie du nom
var nomInput = document.getElementById('nom');
// Ecouteur d'évènement qui se déclenche lorsqu'une entreprise est selectionne
selectionEntreprise.addEventListener('change', function() {
    // Récupération de l'entreprise sélectionnée
    entrepriseSelectionnee = this.value;
    // Si l'entreprise sélectionnée est en fait le message indiquant qu'il faut sélectionner
    if (entrepriseSelectionnee == ""){
        masquerChamps();
    }else {
        afficherChamps();
    }
    // Effectuer une requête AJAX pour récupérer le nombre d'intervenants depuis le backend
    var xhr = new XMLHttpRequest();
    xhr.open('POST', '../../../api/nombre_intervenant.php', true);
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhr.onreadystatechange = function() {
        if (xhr.readyState == 4 && xhr.status == 200) {
            var nombreIntervenants = xhr.responseText;
            nomInput.value = "Intervenant " + nombreIntervenants;
        }
    };
    // Envoyer la requête avec les données nécessaires
    var data = 'entreprise=' + encodeURIComponent(entrepriseSelectionnee);
    xhr.send(data);
});

// Fonction qui affiche les champs du formulaire d'ajout
function afficherChamps() {
    // Itère sur tous les éléments avec la classe "champsAjoutIntervenant"
    var champsAjout = document.getElementsByClassName("champsAjoutIntervenant");
    // Applique les styles en fonction de la sélection de l'entreprise
    for (i = 0; i < champsAjout.length; i++){
        var champAjout = champsAjout[i];

        champAjout.classList.add("champsIntervenantVisible");
        champAjout.classList.remove("champsIntervenantInvisible");
    }
}

// Fonction qui masque les champs du formulaire d'ajout
function masquerChamps() {
    // Itère sur tous les éléments avec la classe "champsAjoutIntervenant"
    var champsAjout = document.getElementsByClassName("champsAjoutIntervenant");
    // Applique les styles en fonction de la sélection de l'entreprise
    for (i = 0; i < champsAjout.length; i++){
        var champAjout = champsAjout[i];

        champAjout.classList.remove("champsIntervenantVisible");
        champAjout.classList.add("champsIntervenantInvisible");
    }
}

/* Retourne le contenu du cookie "nom" ou null si il n'existe pas */
function readCookie(nom) {
	var nomCookie = nom + "=";
	var listeCookies = document.cookie.split(';');
	for(var i=0;i < listeCookies.length;i++) {
		var cookie = listeCookies[i];
		while (cookie.charAt(0)==' ') cookie = cookie.substring(1,cookie.length);
		if (cookie.indexOf(nomCookie) == 0) return cookie.substring(nomCookie.length,cookie.length);
	}
	return null;
}

/* Affiche dans la zone de prévisualisation les différents intervenants ajoutés */
function afficherIntervenant() {
    let indiceTableau = 0; // indice de l'intervenant dans le tableau utilisé pour la suppression
    zonePrevisualisation.innerHTML = "";
    tableauIntervenants.forEach(intervenant => {
        zonePrevisualisation.innerHTML +=
        `<tr>
            <td class="nom"><span>${intervenant["nom"]}</span></td>
            <td class="fonction"><span>${intervenant["fonction"]}</span></td>
            <td class="entreprise"><span>${intervenant["entreprise"]}</span></td>
            <td class="filiere"><span>${intervenant["filiere"]}</span></td>
            <td class="btnSup"><button class="supprimerIntervenant" onclick="supprimerUtilisatuer(${indiceTableau});">&#x274C;</button></td>
        </tr>`;
        indiceTableau += 1;
    });
    masquerChamps();
}

/* Fait correspondre les données affichées et celles présentes dans le cookie*/
function ecritureCookie() {
    let tableauIntervenantJSON = JSON.stringify(tableauIntervenants);
    document.cookie = 'intervenants = ' + tableauIntervenantJSON;
}

/* Ajoute un intervenant dans le tableau */
function ajouterIntervenant(donneesIntervenant) {
    tableauIntervenants.unshift({"nom" : donneesIntervenant[0],"fonction" : donneesIntervenant[1],"entreprise" : donneesIntervenant[2],
    "filiere" : donneesIntervenant[3]});

    /* Ecrit dans le cookie au fur et a mesure des ajouts pour que le cookie corresponde a ce qui est affiché */
    ecritureCookie();
}

/* Supprime l'intervenant présent en paramètre */
function supprimerUtilisatuer(i) {
    tableauIntervenants.splice(i, 1);
    
    /* Ecrit dans le cookie au fur et à mesure des ajouts pour que le cookie corresponde à ce qui est affiché */
    ecritureCookie();
    // Ne pas appeler afficherIntervenant() ici pour éviter l'affichage multiple
}

/* Retourne true si l'intervenant passé en paramètre a déjà été ajouté */
function estIntervenantPresent(intervenantATester) {
    let estPresent = false;
    tableauIntervenants.forEach(intervenant => {
        if (intervenant["nom"] == intervenantATester[0] && intervenant["fonction"] == intervenantATester[1] && intervenant["entreprise"] == intervenantATester[2] && intervenant["filiere"] == intervenantATester[3]){
            estPresent = true;
        };
    });
    return estPresent;
}

  ///////////////////////////////////////////////////////////////////////
 //                Ajout manuel d'un intervenant                      //
///////////////////////////////////////////////////////////////////////

/* Ajoute un intervenant au tableau de prévisualisation */
function ajouterIntervenantManuel() {
    let intervenant = [zoneSaisieNom.value, zoneSaisieFonction.value, zoneSaisieEntreprise.value, zoneSaisieFiliere.value];
    if (estChampsCorrects(intervenant)) {
        if (!estIntervenantPresent(intervenant)) {
            console.log("Debut ajout intervenant : " + intervenant);
            ajouterIntervenant(intervenant);
            viderSaisie();
            afficherIntervenant();
        } else {
            alert("Intervenant déjà présent !");
        }
    } else {
        afficherChampsIncorrect();
    }
}

function ajouterIntervenant(donneesIntervenant) {
    tableauIntervenants.unshift({"nom" : donneesIntervenant[0],"fonction" : donneesIntervenant[1],"entreprise" : donneesIntervenant[2],
    "filiere" : donneesIntervenant[3]});

    /* Ecrit dans le cookie au fur et a mesure des ajouts pour que le cookie corresponde a ce qui est affiché */
    ecritureCookie();
}

/* Vide les zones de saisie manuelles*/
function viderSaisie() {
    zoneSaisieNom.value = "";
    zoneSaisieFonction.value = -1;
    zoneSaisieEntreprise.value = "";
    zoneSaisieFiliere.value = -1;
}

/* Vérifie que tous les champs d'ajout manuel ont été rempli et respectent le bon format */
function estChampsCorrects(intervenant) {
    /* Enlève le bord rouge indiquant une erreur */
    zoneSaisieNom.classList.remove("erreur");
    zoneSaisieFonction.classList.remove("erreur");
    zoneSaisieEntreprise.classList.remove("erreur");
    zoneSaisieFiliere.classList.remove("erreur");

    return estIntervenantCorrect(intervenant);
}

/* Vérifie que l'intervenant rentré en paramètre est correct */
function estIntervenantCorrect(intervenant) {

    if (typeof intervenant != 'object' || intervenant.length != 4) {
        return false;
    }

    nomCorrect = intervenant[0].length > 0; // Si le nom a été saisi
    fonctionCorrect = intervenant[1] != -1; // Est ce que la fonction n'est pas celle de base
    entrepriseCorrect = intervenant[2].length > 0; // Si l'entreprise a bien été sélectionnée
    filiereCorrect = intervenant[3] != -1; // Est ce que la filiere n'est pas celle de base

    return  nomCorrect && fonctionCorrect && entrepriseCorrect && filiereCorrect;
}

/* Affiche en rouge les champs de l'ajout manuel qui n'ont pas été rempli ou sont incorrect */
function afficherChampsIncorrect() {
    if (!nomCorrect) {
        zoneSaisieNom.classList.add("erreur");
    }
    if (!fonctionCorrect) {
        zoneSaisieFonction.classList.add("erreur");
    }
    if (!entrepriseCorrect) {
        zoneSaisieEntreprise.classList.add("erreur");
    }
    if (!filiereCorrect) {
        zoneSaisieFiliere.classList.add("erreur");
    }
}
