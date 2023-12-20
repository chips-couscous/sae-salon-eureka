/* Déclaration des variables */
var btnAjouterManuel = document.getElementById("ajouterUtilisateur");
var zoneSaisieNom = document.getElementById("nom");
var zoneSaisiePrenom = document.getElementById("prenom");
var zoneSaisieMail = document.getElementById("mail");
var zoneSaisieMdp = document.getElementById("mdp");
var zoneSaisieFiliere = document.getElementById("filiere");
var zoneSaisieStatus = document.getElementById("status");
var zonePrevisualisation = document.getElementById("tablePrevisualisation");
var zoneImportFichier = document.getElementById("importerEtudiant");

var tableauUtilisateurs = [];

var nomCorrect;
var prenomCorrect;
var mailCorrect;
var mdpCorrect;
var filiereCorrect;
var statusCorrect;

/* Ajout d'eventListener */
btnAjouterManuel.addEventListener("click", ajouterUtilisateur);
zoneImportFichier.addEventListener("change", importerFichier);

/* Ajoute un utilisateur au tableau de prévisualisation */
function ajouterUtilisateur() {
    if (estChampsCorrects()) {
        ajouterUtilisateurDansTableau();
        afficherUtilisateur();
        viderSaisie();
    } else {
        afficherChampsIncorrect();
    }
}

/* Affiche dans la zone de prévisualisation les différents utilisateurs importés ou ajoutés */
function afficherUtilisateur() {
    zonePrevisualisation.innerHTML = "<tr><td>Prénom</td><td>Nom</td><td>Mail</td><td>Mot de passe</td><td>Status</td><td>Filiere</td></tr>";
    tableauUtilisateurs.forEach(utilisateur => {
        zonePrevisualisation.innerHTML += `<tr>
        <td>${utilisateur["prenom"]}</td>
        <td>${utilisateur["nom"]}</td>
        <td>${utilisateur["mail"]}</td>
        <td>${utilisateur["mdp"]}</td>
        <td>${utilisateur["filiere"]}</td>
        <td>${utilisateur["status"]}</td>
        </tr>`;
    });
}

/* Ajoute dans le tableau d'utilisateur, l'utilisateur saisi manuellement */
function ajouterUtilisateurDansTableau() {
    tableauUtilisateurs.unshift({"nom" : zoneSaisieNom.value,"prenom" : zoneSaisiePrenom.value,"mail" : zoneSaisieMail.value,
                            "mdp" : zoneSaisieMdp.value,"filiere" : zoneSaisieFiliere.value,"status" : zoneSaisieStatus.value});
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

/* Import un fichier contenant des utilisateurs */
function importerFichier() {
    let fileReader = new FileReader();
    var contenuFichier = "test";
    fileReader.onload = function() {
        console.log("1");
        contenuFichier = fileReader.result;
        traiterFichier(contenuFichier);
    }
    fileReader.readAsText(this.files[0]);
        
    zoneImportFichier.value="";
}

/* Lis le contenu du fichier et l'ajoute dans un tableau */
function traiterFichier() {

}