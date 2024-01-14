/* Déclaration des variables */
var btnAjouterManuel = document.getElementById("ajouterUtilisateur");
var zoneSaisieNom = document.getElementById("nom");
var zoneSaisieFonction = document.getElementById("fonction");
var zoneSaisieEntreprise = document.getElementById("selectionEntreprise");
var zoneSaisieFiliere = document.getElementById("filiere");
var zonePrevisualisation = document.getElementById("TablePrevisualisation");
var body = document.body;

var tableauUtilisateurs = [];

var nomCorrect;
var fonctionCorrect;
var entrepriseCorrect;
var filiereCorrect;

var entrepriseSelectionnee;

var selectionEntreprise = document.getElementById("selectionEntreprise");

selectionEntreprise.addEventListener("change", afficherChamps);

/* Ajout d'eventListener */
btnAjouterManuel.addEventListener("click", ajouterUtilisateurManuel);

/* Si données déjà présentes dans cookie -> récupération */
if (document.cookie != null) {
    let contenuCookie = readCookie("utilisateurs");
    if (contenuCookie != null) {
        tableauUtilisateurs = JSON.parse(contenuCookie);
        if (typeof tableauUtilisateurs != 'object') {
            tableauUtilisateurs = [];
        }
        afficherUtilisateur();
    }
}

var nomInput = document.getElementById('nom');
selectionEntreprise.addEventListener('change', function() {
    entrepriseSelectionnee = this.value;

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

/* Affiche dans la zone de prévisualisation les différents utilisateurs importés ou ajoutés */
function afficherUtilisateur() {
    let indiceTableau = 0; // indice de l'utilisateur dans le tableau utilisé pour la suppression
    zonePrevisualisation.innerHTML = "";
    tableauUtilisateurs.forEach(utilisateur => {
        zonePrevisualisation.innerHTML +=
        `<tr>
            <td class="nom"><span>${utilisateur["nom"]}</span></td>
            <td class="fonction"><span>${utilisateur["fonction"]}</span></td>
            <td class="entreprise"><span>${utilisateur["entreprise"]}</span></td>
            <td class="filiere"><span>${utilisateur["filiere"]}</span></td>
            <td class="btnSup"><button class="supprimerUtilisateur" onclick="supprimerUtilisatuer(${indiceTableau});">&#x274C;</button></td>
        </tr>`;
        indiceTableau += 1;
    });
    masquerChamps();
}

/* Fait correspondre les données affichées et celles présentes dans le cookie*/
function ecritureCookie() {
    let tableauUtilisateurJSON = JSON.stringify(tableauUtilisateurs);
    document.cookie = 'utilisateurs = ' + tableauUtilisateurJSON;
}

/* Ajoute un utilisateur dans le tableau */
function ajouterUtilisateur(donneesUtilisateur) {
    tableauUtilisateurs.unshift({"nom" : donneesUtilisateur[0],"fonction" : donneesUtilisateur[1],"entreprise" : donneesUtilisateur[2],
    "filiere" : donneesUtilisateur[3]});

    /* Ecrit dans le cookie au fur et a mesure des ajouts pour que le cookie corresponde a ce qui est affiché */
    ecritureCookie();
}

/* Supprime l'utilisateur présent en paramètre */
function supprimerUtilisatuer(i) {
    tableauUtilisateurs.splice(i, 1);
    
    /* Ecrit dans le cookie au fur et à mesure des ajouts pour que le cookie corresponde à ce qui est affiché */
    ecritureCookie();
    // Ne pas appeler afficherUtilisateur() ici pour éviter l'affichage multiple
}

/* Retourne true si l'utilisateur passé en paramètre a déjà été ajouté */
function estUtilisateurPresent(utilisateurATester) {
    let estPresent = false;
    tableauUtilisateurs.forEach(utilisateur => {
        if (utilisateur["nom"] == utilisateurATester[0] && utilisateur["fonction"] == utilisateurATester[1] && utilisateur["entreprise"] == utilisateurATester[2] && utilisateur["filiere"] == utilisateurATester[3]){
            estPresent = true;
        };
    });
    return estPresent;
}

  ///////////////////////////////////////////////////////////////////////
 //                Ajout manuel d'un utilisateur                      //
///////////////////////////////////////////////////////////////////////



/* Ajoute un utilisateur au tableau de prévisualisation */
function ajouterUtilisateurManuel() {
    let utilisateur = [zoneSaisieNom.value, zoneSaisieFonction.value, zoneSaisieEntreprise.value, zoneSaisieFiliere.value];
    if (estChampsCorrects(utilisateur)) {
        if (!estUtilisateurPresent(utilisateur)) {
            console.log("Debut ajout intervenant : " + utilisateur);
            ajouterUtilisateur(utilisateur);
            viderSaisie();
            afficherUtilisateur();
        } else {
            alert("Utilisateur déjà présent !");
        }
    } else {
        afficherChampsIncorrect();
    }
}

function ajouterUtilisateur(donneesUtilisateur) {
    tableauUtilisateurs.unshift({"nom" : donneesUtilisateur[0],"fonction" : donneesUtilisateur[1],"entreprise" : donneesUtilisateur[2],
    "filiere" : donneesUtilisateur[3]});

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
function estChampsCorrects(utilisateur) {
    /* Enlève le bord rouge indiquant une erreur */
    zoneSaisieNom.classList.remove("erreur");
    zoneSaisieFonction.classList.remove("erreur");
    zoneSaisieEntreprise.classList.remove("erreur");
    zoneSaisieFiliere.classList.remove("erreur");

    return estUtilisateurCorrect(utilisateur);
}

/* Vérifie que l'utilisateur rentré en paramètre est correct */
function estUtilisateurCorrect(utilisateur) {

    if (typeof utilisateur != 'object' || utilisateur.length != 4) {
        return false;
    }

    nomCorrect = utilisateur[0].length > 0;
    fonctionCorrect = utilisateur[1] != -1;
    entrepriseCorrect = utilisateur[2].length > 0;
    filiereCorrect = utilisateur[3] != -1;

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
