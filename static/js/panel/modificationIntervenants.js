const inputNom = document.getElementById('nom');
const inputEntreprise = document.getElementById('entreprise');
const displayTable = document.getElementById('TablePrevisualisation');

inputNom.addEventListener('keyup', () => {
    chargerDonnees(inputNom.value, inputEntreprise.value);
})

inputEntreprise.addEventListener('keyup', () => {
    chargerDonnees(inputNom.value, inputEntreprise.value);
})

function chargerDonnees(filtreNom, filtreEntreprise) {
    let xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function () {
        if(this.readyState == 4 && this.status == 200) {
            console.log(this.responseText);
            let jsonResponse = JSON.parse(this.responseText);
            afficherDonnees(jsonResponse);
        }
    }
     
    let requete = `http://localhost/WorkspaceWeb/sae-salon-eureka/api/rechercher-intervenant.php?nom=${filtreNom}&entreprise=${filtreEntreprise}`;
    xmlhttp.open("GET", requete, true);
    xmlhttp.send();
}

function afficherDonnees(donnees) {
    displayTable.innerHTML = `
    <tr>
		<th>
			Nom
		</th>
		<th>
			Fonction    
		</th>
		<th>
			Entreprise
		</th>
		<th>
			Filiere
		</th>							
	</tr>`;
    for (let i = 0; i < donnees.length; i++) {
        let intervenant = donnees[i];
        displayTable.innerHTML += `
        </tr>
            <td>${intervenant['nom']}</td>
            <td>${intervenant['fonction']}</td>
            <td>${intervenant['entreprise']}</td>
            <td>${intervenant['filiere']}</td>
        </tr>
        `;
    }
}

// Récupérer toutes les lignes de la table
var lignes = displayTable.getElementsByTagName("tr");

// Ajouter un gestionnaire d'événements à chaque ligne
for (var i = 0; i < lignes.length; i++) {
    console.log(1);
  lignes[i].addEventListener("click", function() {
    // Appeler la fonction lorsque la ligne est cliquée
    estCliquee(this);
  });
}

// script.js

function chargerFonctions() {
    return new Promise((resolve, reject) => {
        let xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function () {
            if (this.readyState == 4) {
                if (this.status == 200) {
                    let jsonResponse = JSON.parse(this.responseText);
                    resolve(jsonResponse);
                } else {
                    reject(new Error('Erreur lors de la requête AJAX'));
                }
            }
        }

        let requete = `http://localhost/WorkspaceWeb/sae-salon-eureka/api/liste-fonctions.php`;
        xmlhttp.open("GET", requete, true);
        xmlhttp.send();
    });
}

let tableauFonction 

chargerFonctions().then((tableauFonctions) => {
    tableauFonction = tableauFonctions;
}).catch((error) => {
    console.error(error);
});

function chargerEntreprises() {
    return new Promise((resolve, reject) => {
        let xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function () {
            if (this.readyState == 4) {
                if (this.status == 200) {
                    let jsonResponse = JSON.parse(this.responseText);
                    resolve(jsonResponse);
                } else {
                    reject(new Error('Erreur lors de la requête AJAX'));
                }
            }
        }

        let requete = `http://localhost/WorkspaceWeb/sae-salon-eureka/api/liste-entreprises.php`;
        xmlhttp.open("GET", requete, true);
        xmlhttp.send();
    });
}

let tableauEntreprise 

chargerEntreprises().then((tableauEntreprises) => {
    tableauEntreprise = tableauEntreprises;
}).catch((error) => {
    console.error(error);
});

function chargerFilieres() {
    return new Promise((resolve, reject) => {
        let xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function () {
            if (this.readyState == 4) {
                if (this.status == 200) {
                    let jsonResponse = JSON.parse(this.responseText);
                    resolve(jsonResponse);
                } else {
                    reject(new Error('Erreur lors de la requête AJAX'));
                }
            }
        }

        let requete = `http://localhost/WorkspaceWeb/sae-salon-eureka/api/liste-filieres.php`;
        xmlhttp.open("GET", requete, true);
        xmlhttp.send();
    });
}

let tableauFiliere 

chargerFilieres().then((tableauFilieres) => {
    tableauFiliere = tableauFilieres;
}).catch((error) => {
    console.error(error);
});

// Récupérer toutes les lignes de la table
let champsModifs = document.getElementById("modifCliquee");

// Fonction à appeler lorsqu'une ligne est cliquée
function estCliquee(ligne) {
    let listeChamps = ligne.getElementsByTagName("td");
    let tableauFonctions = tableauFonction;
    let tableauEntreprises = tableauEntreprise;
    let tableauFilieres = tableauFiliere;

    // Construire la chaîne HTML dans une variable
    let htmlContent = `
        <span>Modifier l'intervenant :</span><br>
        <form action="post">
            <div class="form-item bm15 ">
                <input type="text" name="nom" id="nom" value="${listeChamps[0].innerText}" autocomplete="off" required>
                <label for="nom">Nom *</label>
            </div>
            <select name="fonction" id="fonction">`;

    for (var i = 0; i < tableauFonctions.length; i++) {
        htmlContent += `<option value="${tableauFonctions[i].fonction}"`;
        if (listeChamps[1].innerText == tableauFonctions[i].fonction) {
            htmlContent += `selected`;
        };
        htmlContent += `>${tableauFonctions[i].fonction}</option>`;
    }

    htmlContent += `</select>
                    <label for="fonction">Fonction *</label>
                    <select name="entreprise" id="enterprise">`;
    for (var i = 0; i < tableauFonctions.length; i++) {
        htmlContent += `<option value="${tableauEntreprises[i].entreprise}"`;
        if (listeChamps[2].innerText == tableauEntreprises[i].entreprise) {
            htmlContent += `selected`;
        };
        htmlContent += `>${tableauEntreprises[i].entreprise}</option>`;
    }

    htmlContent += `</select>
                    <label for="entreprise">Entreprise *</label>
                    <select name="filiere" id="filiere">`;
    for (var i = 0; i < tableauFilieres.length; i++) {
        htmlContent += `<option value="${tableauFilieres[i].filiere}"`;
        if (listeChamps[3].innerText == tableauFilieres[i].filiere) {
            htmlContent += `selected`;
        };
        htmlContent += `>${tableauFilieres[i].filiere}</option>`;
    }
    htmlContent += `</select>
                    <label for="filiere">Filiere *</label>`;

    // Remplacez le contenu de champsModifs par la nouvelle chaîne HTML
    champsModifs.innerHTML = htmlContent;

    champsModifs.innerHTML +=`<div class="form-item">
                                  <input type="submit" value="Modifier">
                              </div>
                              </form>`;
    return true;
}