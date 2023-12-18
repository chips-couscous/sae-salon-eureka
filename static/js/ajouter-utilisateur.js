/* Déclaration des variables */
var btnAjouterManuel = document.getElementById("ajouterUtilisateur");
var zoneSaisieNom = document.getElementById("nom");
var zoneSaisiePrenom = document.getElementById("prenom");
var zoneSaisieMail = document.getElementById("mail");
var zoneSaisieMdp = document.getElementById("mdp");
var zoneSaisieFiliere = document.getElementById("filiere");
var zoneSaisieStatus = document.getElementById("status");
var zonePrevisualisation = document.getElementById("tablePrevisualisation");

var tableauUtilisateurs = [];

/* Ajout d'eventListener */
btnAjouterManuel.addEventListener("click", ajouterUtilisateur);

function ajouterUtilisateur() {
    ajouterUtilisateurDansTableau();
    afficherUtilisateur();
}

function afficherUtilisateur() {

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

function ajouterUtilisateurDansTableau() {
    //TODO écrire le code de la méthode
}