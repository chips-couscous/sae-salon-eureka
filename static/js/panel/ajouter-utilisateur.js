/* Déclaration des variables */
var btnAjouterManuel = document.getElementById("ajouterUtilisateur");
var zoneSaisieNom = document.getElementById("nom");
var zoneSaisiePrenom = document.getElementById("prenom");
var zoneSaisieMail = document.getElementById("mail");
var zoneSaisieMdp = document.getElementById("mdp");
var zoneSaisieFiliere = document.getElementById("filiere");
var zoneSaisieStatus = document.getElementById("status");
var zonePrevisualisation = document.getElementById("tablePrevisualisation");
var btnImportFichier = document.getElementById("importerEtudiant");
var zoneImportFichier = document.getElementById("zoneImporterEtudiant");
var body = document.body;

var tableauUtilisateurs = [];

var nomCorrect;
var prenomCorrect;
var mailCorrect;
var mdpCorrect;
var filiereCorrect;
var statusCorrect;

/* Ajout d'eventListener */
btnAjouterManuel.addEventListener("click", ajouterUtilisateurManuel);
btnImportFichier.addEventListener("change", importerFichier);
zoneImportFichier.addEventListener('drop', importDragAndDrop);
body.addEventListener('dragover', dragOver);

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
    zonePrevisualisation.innerHTML = "";
    let indiceTableau = 0; // indice de l'utilisateur dans le tableau utilisé pour la suppression
    tableauUtilisateurs.forEach(utilisateur => {
        zonePrevisualisation.innerHTML +=
        `<div class="row">
            <div class="prenom"><span>${utilisateur["prenom"]}</span></div>
            <div class="nom"><span>${utilisateur["nom"]}</span></div>
            <div class="mail"><span>${utilisateur["mail"]}</span></div>
            <div class="mot-de-passe"><span>${utilisateur["mdp"]}</span></div>
            <div class="statut"><span>${utilisateur["filiere"]}</span></div>
            <div class="filiere"><span>${utilisateur["statut"]}</span></div>
            <div class="btnSup"><button class="supprimerUtilisateur" onclick="supprimerUtilisatuer(${indiceTableau});">&#x274C;</button></div>
        </div>`;
        indiceTableau += 1;
    });
}

/* Fait correspondre les données affichées et celles présentes dans le cookie*/
function ecritureCookie() {
    tableauUtilisateurJSON = JSON.stringify(tableauUtilisateurs);
    document.cookie = 'utilisateurs = ' + tableauUtilisateurJSON;
}

/* Ajoute un utilisateur dans le tableau */
function ajouterUtilisateur(donneesUtilisateur) {
    tableauUtilisateurs.unshift({"nom" : donneesUtilisateur[0],"prenom" : donneesUtilisateur[1],"mail" : donneesUtilisateur[2],
    "mdp" : donneesUtilisateur[3],"filiere" : donneesUtilisateur[4],"statut" : donneesUtilisateur[5]});

    /* Ecrit dans le cookie au fur et a mesure des ajouts pour que le cookie corresponde a ce qui est affiché */
    ecritureCookie();
}

/* Supprime l'utilisateur présent en paramètre */
function supprimerUtilisatuer(i) {
    tableauUtilisateurs.splice(i,1);
    
    /* Ecrit dans le cookie au fur et a mesure des ajouts pour que le cookie corresponde a ce qui est affiché */
    ecritureCookie();
    afficherUtilisateur();
}

/* Retourne true si l'utilisateur passé en paramètre a déjà été ajouté */
function estUtilisateurPresent(utilisateurATester) {
    let estPresent = false;
    tableauUtilisateurs.forEach(utilisateur => {
        estPresent |= utilisateur["mail"] == utilisateurATester[2];
    });
    return estPresent;
}

  ///////////////////////////////////////////////////////////////////////
 //                Ajout manuel d'un utilisateur                      //
///////////////////////////////////////////////////////////////////////

/* Ajoute un utilisateur au tableau de prévisualisation */
function ajouterUtilisateurManuel() {
    if (estChampsCorrects()) {
        let utilisateur = [zoneSaisieNom.value, zoneSaisiePrenom.value, zoneSaisieMail.value, zoneSaisieMdp.value, zoneSaisieFiliere.value, zoneSaisieStatus.value];
        if (!estUtilisateurPresent(utilisateur)) {
            ajouterUtilisateur(utilisateur);
            afficherUtilisateur();
            viderSaisie();
        } else {
            alert("Utilisateur déjà présent !");
        }
    } else {
        afficherChampsIncorrect();
    }
}

/* Vide les zones de saisie manuelles*/
function viderSaisie() {
    zoneSaisieNom.value = "";
    zoneSaisiePrenom.value = "";
    zoneSaisieMail.value = "";
    zoneSaisieMdp.value = "";
    zoneSaisieFiliere.value = "";
    zoneSaisieStatus.value = "";
}

/* Vérifie que tous les champs d'ajout manuel ont été rempli et respectent le bon format */
function estChampsCorrects() {
    /* Enlève le bord rouge indiquant une erreur */
    zoneSaisieNom.classList.remove("erreur");
    zoneSaisiePrenom.classList.remove("erreur");
    zoneSaisieMail.classList.remove("erreur");
    zoneSaisieMdp.classList.remove("erreur");
    zoneSaisieFiliere.classList.remove("erreur");
    zoneSaisieStatus.classList.remove("erreur");

    nomCorrect = zoneSaisieNom.value.length > 0;
    prenomCorrect = zoneSaisiePrenom.value.length > 0;
    mailCorrect = zoneSaisieMail.value.toLowerCase().match(/^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|.(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/);
    mdpCorrect = zoneSaisieMdp.value.length > 0;
    filiereCorrect = zoneSaisieFiliere.value.length > 0;
    statusCorrect = zoneSaisieStatus.value.length > 0;

    return  nomCorrect && prenomCorrect && mailCorrect && mdpCorrect && filiereCorrect && statusCorrect;
}

/* Affiche en rouge les champs de l'ajout manuel qui n'ont pas été rempli ou sont incorrect */
function afficherChampsIncorrect() {
    if (!nomCorrect) {
        zoneSaisieNom.classList.add("erreur");
    }
    if (!prenomCorrect) {
        zoneSaisiePrenom.classList.add("erreur");
    }
    if (!mailCorrect) {
        zoneSaisieMail.classList.add("erreur");
    }
    if (!mdpCorrect) {
        zoneSaisieMdp.classList.add("erreur");
    }
    if (!filiereCorrect) {
        zoneSaisieFiliere.classList.add("erreur");
    }
    if (!statusCorrect) {
        zoneSaisieStatus.classList.add("erreur");
    }
}

  ///////////////////////////////////////////////////////////////////////
 //              Importation d'un fichier d'utilisateurs              //
///////////////////////////////////////////////////////////////////////

/* Import un fichier contenant des utilisateurs */
function importerFichier() {
    lireFichier(this.files[0]);
    btnImportFichier.value="";
}

/* Lis le fichier passé en paramètre */
function lireFichier(fichier) {
    let fileReader = new FileReader();
    fileReader.onload = function() {
        let contenuFichier = fileReader.result; // Récupère le contenu du fichier
        traiterFichier(contenuFichier);
    }
    fileReader.readAsText(fichier);  // Lit le fichier
}

/* Lis le contenu du fichier et l'ajoute dans un tableau et l'affiche */
function traiterFichier(contenuFichier) {
    let nbUtilisateurNonAjoute = 0;
    let utilisateurs = contenuFichier.split("\r\n"); // Découpe le fichier pour obtenir un tableau d'utilisateur
    for (i = 1; i < utilisateurs.length; i++) {
        donneesUtilisateur = utilisateurs[i].split(";"); // Découpage des différentes données d'un utilisateur
        if (!estUtilisateurPresent(donneesUtilisateur)) {
            ajouterUtilisateur(donneesUtilisateur);
        } else {
            nbUtilisateurNonAjoute += 1;
        }
    }
    if (nbUtilisateurNonAjoute > 0) {
        alert(nbUtilisateurNonAjoute + " utilisateurs sont déjà présent et n'ont pas été ajoutés\n");
    }
    afficherUtilisateur(); 
}

/* Evite le fonctionnement de base du navigateur concernant le drag and drop de fichier */
function dragOver(event) {
    event.preventDefault();
}

/* Récupère le chemin du fichier déposé */
function importDragAndDrop(event) {
    event.preventDefault();
    event.stopPropagation();
    let fichier = event.dataTransfer.files[0];
    lireFichier(fichier);
}