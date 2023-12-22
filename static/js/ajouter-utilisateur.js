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

var tableauUtilisateurs = [];

var nomCorrect;
var prenomCorrect;
var mailCorrect;
var mdpCorrect;
var filiereCorrect;
var statusCorrect;

/* Ajout d'eventListener */
btnAjouterManuel.addEventListener("click", ajouterUtilisateur);
btnImportFichier.addEventListener("change", importerFichier);
zoneImportFichier.addEventListener('drop', importDragAndDrop);
zoneImportFichier.addEventListener('dragover', handleDragOver);


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

/* Ajoute un utilisateur dans le tableau */
function ajouterUtilisateur(donneesUtilisateur) {
    tableauUtilisateurs.unshift({"nom" : donneesUtilisateur[0],"prenom" : donneesUtilisateur[1],"mail" : donneesUtilisateur[2],
    "mdp" : donneesUtilisateur[3],"filiere" : donneesUtilisateur[4],"status" : donneesUtilisateur[5]});
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
    let utilisateurs = contenuFichier.split("\r\n"); // Découpe le fichier pour obtenir un tableau d'utilisateur
    for (i = 1; i < utilisateurs.length; i++) {
        donneesUtilisateur = utilisateurs[i].split(";"); // Découpage des différentes données d'un utilisateur
        if (!estUtilisateurPresent(donneesUtilisateur)) {
            ajouterUtilisateur(donneesUtilisateur);
        }
    }
    afficherUtilisateur(); 
}

/* Evite le fonctionnement de base du navigateur concernant le drag and drop de fichier */
function handleDragOver(event) {
    event.preventDefault();
}

/* Récupère le chemin du fichier déposé */
function importDragAndDrop(event) {
    event.preventDefault();
    let fichier = event.dataTransfer.files[0];
    lireFichier(fichier);
}
