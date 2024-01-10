/* Déclaration des variables */
var btnAjouterManuel = document.getElementById("ajouterUtilisateur");
var zoneSaisieNom = document.getElementById("nom");
var zoneSaisieFonction = document.getElementById("fonction");
var zoneSaisieEntreprise = document.getElementById("entreprise");
var zoneSaisieFiliere = document.getElementById("filiere");
var zonePrevisualisation = document.getElementById("TablePrevisualisation");
var body = document.body;

var tableauUtilisateurs = [];

var nomCorrect;
var fonctionCorrect;
var entrepriseCorrect;
var filiereCorrect;

/* Ajout d'eventListener */
btnAjouterManuel.addEventListener("click", ajouterUtilisateurManuel);

/* Affiche dans la zone de prévisualisation les différents utilisateurs importés ou ajoutés */
function afficherUtilisateur() {
    let indiceTableau = 0; // indice de l'utilisateur dans le tableau utilisé pour la suppression
    console.log("on est la");
    tableauUtilisateurs.forEach(utilisateur => {
        zonePrevisualisation.innerHTML +=
        `<tr>
            <td class="nom"><span>${utilisateur["nom"]}</span></td>
            <td class="fonction"><span>${utilisateur["fonction"]}</span></td>
            <td class="entreprise"><span>${utilisateur["entreprise"]}</span></td>
            <td class="filiere"><span>${utilisateur["filiere"]}</span></td>
            <td class="btnSup"><button class="supprimerUtilisateur" onclick="supprimerUtilisatuer(${indiceTableau});">&#x274C;</button></td>
        </tr>`;
        console.log(zonePrevisualisation.innerHTML);
        indiceTableau += 1;
    });
}

  ///////////////////////////////////////////////////////////////////////
 //                Ajout manuel d'un utilisateur                      //
///////////////////////////////////////////////////////////////////////

/* Ajoute un utilisateur au tableau de prévisualisation */
function ajouterUtilisateurManuel() {
    let utilisateur = [zoneSaisieNom.value, zoneSaisieFonction.value, zoneSaisieEntreprise.value, zoneSaisieFiliere.value];
    console.log(utilisateur);
    if (estChampsCorrects(utilisateur)) {
        ajouterUtilisateur(utilisateur);
        afficherUtilisateur();
        viderSaisie();
    } else {
        afficherChampsIncorrect();
    }
}

function ajouterUtilisateur(donneesUtilisateur) {
    tableauUtilisateurs.unshift({"nom" : donneesUtilisateur[0],"fonction" : donneesUtilisateur[1],"entreprise" : donneesUtilisateur[2],
    "filiere" : donneesUtilisateur[3]});

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
