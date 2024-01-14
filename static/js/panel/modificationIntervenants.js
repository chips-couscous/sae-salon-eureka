// Récupération des différents éléments du formulaire et de la table
const inputNom = document.getElementById('nom');
const inputEntreprise = document.getElementById('entreprise');
const displayTable = document.getElementById('TablePrevisualisation');

// Ajout d'un écouteur d'évènements sur la zone de saisie du nom
inputNom.addEventListener('keyup', () => {
    chargerDonnees(inputNom.value, inputEntreprise.value);
})

// Ajout d'un écouteur d'évènements sur la zone de saisie de l'entreprise
inputEntreprise.addEventListener('keyup', () => {
    chargerDonnees(inputNom.value, inputEntreprise.value);
})

/* Fonction pour charger les données avec requete AJAX
 * Prend en paramètre le nom et l'entreprise renseignée
 * pour afficher seulement les résultats dont le nom commence
 * par ce qui a été saisie et avec l'entreprise sélectionnée
 */
function chargerDonnees(filtreNom, filtreEntreprise) {
    let xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function () {
        if(this.readyState == 4 && this.status == 200) {
            if (this.responseText.trim() !== "") {
                let jsonResponse = JSON.parse(this.responseText);
                afficherDonnees(jsonResponse);
            } else {
                console.error("Réponse JSON vide.");
            }
        }
    }
    // Interrogation de l'api avec les parametres saisis 
    let requete = `http://localhost/WorkspaceWeb/sae-salon-eureka/api/rechercher-intervenant.php?nom=${filtreNom}&entreprise=${filtreEntreprise}`;
    console.log(requete);
    xmlhttp.open("GET", requete, true);
    xmlhttp.send();
}

/* Fonction pour afficher les données dans la table
 * Prend en paramètre les données renvoyées par le serveur
 * via la requête AJAX
 */
function afficherDonnees(donnees) {
    // Reinitialisation de la table avec les champs des colonnes
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
    // Parcours des données par ligne pour les afficher dans la table
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

// Fonction pour attacher les gestionnaires d'événements
function attacherGestionnaires() {
    var lignes = displayTable.getElementsByTagName("tr");

    for (var i = 0; i < lignes.length; i++) {
        lignes[i].addEventListener("click", function() {
            // Appeler la fonction lorsque la ligne est cliquée
            estCliquee(this);
        });
    }
}

// Appeler la fonction lors du chargement initial
attacherGestionnaires();

displayTable.addEventListener("click", function(event) {
    var target = event.target;

    // Remonter jusqu'à l'élément <tr> en utilisant parentNode
    while (target.tagName !== "TR") {
        target = target.parentNode;
        // Vérifier si on atteint l'élément racine
        if (!target) {
            return;
        }
    }

    // Appeler la fonction lorsque la ligne est cliquée
    estCliquee(target);
});

// Fonction récupérant la liste des fonctions présentes dans la BD
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
        // Interrogation de l'api pour récupérer la liste des fonctions présentes
        let requete = `http://localhost/WorkspaceWeb/sae-salon-eureka/api/liste-fonctions.php`;
        xmlhttp.open("GET", requete, true);
        xmlhttp.send();
    });
}

// Variable contenant la liste des fonctions de la BD
let tableauFonction; 

// Récupération de la réponse de l'api en stockant le résultat dans un tableau
chargerFonctions().then((tableauFonctions) => {
    tableauFonction = tableauFonctions;
}).catch((error) => {
    console.error(error);
});

// Fonction récupérant la liste des entreprises présentes dans la BD
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
        // Interrogation de l'api pour récupérer la liste des entreprises présentes
        let requete = `http://localhost/WorkspaceWeb/sae-salon-eureka/api/liste-entreprises.php`;
        xmlhttp.open("GET", requete, true);
        xmlhttp.send();
    });
}

// Variable contenant la liste des entreprises de la BD
let tableauEntreprise; 

// Récupération de la réponse de l'api en stockant le résultat dans un tableau
chargerEntreprises().then((tableauEntreprises) => {
    tableauEntreprise = tableauEntreprises;
}).catch((error) => {
    console.error(error);
});

// Fonction récupérant la liste des filieres présentes dans la BD
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
        // Interrogation de l'api pour récupérer la liste des filieres présentes
        let requete = `http://localhost/WorkspaceWeb/sae-salon-eureka/api/liste-filieres.php`;
        xmlhttp.open("GET", requete, true);
        xmlhttp.send();
    });
}

// Variable contenant la liste des filieres de la BD
let tableauFiliere; 

// Récupération de la réponse de l'api en stockant le résultat dans un tableau
chargerFilieres().then((tableauFilieres) => {
    tableauFiliere = tableauFilieres;
}).catch((error) => {
    console.error(error);
});

// Récupérer toutes les lignes de la table
let champsModifs = document.getElementById("modifCliquee");

// Fonction à appeler lorsqu'une ligne est cliquée
function estCliquee(ligne) {
    // Récupération des champs et listes
    let listeChamps = ligne.getElementsByTagName("td");
    let tableauFonctions = tableauFonction;
    let tableauEntreprises = tableauEntreprise;
    let tableauFilieres = tableauFiliere;

    // Récupérez l'ID de la ligne cliquée
    let ligneID = ligne.getAttribute("id");

    // Construire la chaîne HTML dans une variable
    let htmlContent = `
        <span>Modifier l'intervenant :</span><br>
        <form id="formulaireModification" method="post" action="#">
            <div class="form-item bm15 ">
                <input type="text" name="nom" id="nomModif" value="${listeChamps[0].innerText}" autocomplete="off" required>
                <label for="nomModif">Nom *</label>
            </div>
            <div class="form-item bm15 ">
                <select name="fonction" id="fonctionModif">`;

    // Affichage des différentes fonctions dans le select       
    for (var i = 0; i < tableauFonctions.length; i++) {
        htmlContent += `<option value="${tableauFonctions[i].fonction}"`;
        if (listeChamps[1].innerText == tableauFonctions[i].fonction) {
            htmlContent += ` selected`;
        }
        htmlContent += `>${tableauFonctions[i].fonction}</option>`;
    }

    htmlContent += `</select>
                    <label for="fonctionModif">Fonction *</label>
                </div>
                <div class="form-item bm15 ">
                    <select name="entreprise" id="entrepriseModif">`;
    // Affichage des différentes entreprises dans le select     
    for (var i = 0; i < tableauEntreprises.length; i++) {
        htmlContent += `<option value="${tableauEntreprises[i].entreprise}"`;
        if (listeChamps[2].innerText == tableauEntreprises[i].entreprise) {
            htmlContent += ` selected`;
        }
        htmlContent += `>${tableauEntreprises[i].entreprise}</option>`;
    }

    htmlContent += `</select>
                    <label for="entrepriseModif">Entreprise *</label>
                </div>
                <div class="form-item bm15 ">
                    <select name="filiere" id="filiereModif">`;
    // Affichage des différentes filieres dans le select     
    for (var i = 0; i < tableauFilieres.length; i++) {
        htmlContent += `<option value="${tableauFilieres[i].filiere}"`;
        if (listeChamps[3].innerText == tableauFilieres[i].filiere) {
            htmlContent += ` selected`;
        }
        htmlContent += `>${tableauFilieres[i].filiere}</option>`;
    }
    htmlContent += `</select>
                    <label for="filiereModif">Filiere *</label>
                </div>
                <div class="form-item">
                    <input type="submit" value="Modifier">
                </div>
            </form>`;

    // Remplacez le contenu de champsModifs par la nouvelle chaîne HTML
    champsModifs.innerHTML = htmlContent;

    // Appel de fonction mettant en place un écouteur d'évènements sur le formulaire
    ajouterEcouteurFormulaire();
    
    return true;
}

// Fonction pour ajouter l'écouteur d'événements au formulaire
function ajouterEcouteurFormulaire() {
    let formulaireModification = document.getElementById("formulaireModification");

    if (formulaireModification) {
        formulaireModification.addEventListener("submit", function (event) {
            event.preventDefault(); // Empêche le rechargement de la page

            console.log("Formulaire soumis!"); // Ajoutez cette ligne pour vérifier

            // Collectez les valeurs du formulaire
            let nouveauNom = document.getElementById("nomModif").value;
            let nouvelleFonction = document.getElementById("fonctionModif").value;
            let nouvelleEntreprise = document.getElementById("entrepriseModif").value;
            let nouvelleFiliere = document.getElementById("filiereModif").value;

            // Appel de fonction intérrogant l'api pour mettre à jour la BD
            mettreAJourBaseDeDonnees(nouveauNom, nouvelleFonction, nouvelleEntreprise, nouvelleFiliere);
        });
    }
}

// Fonction intérrogant l'api afin de mettre à jour la BD
function mettreAJourBaseDeDonnees(nouveauNom, nouvelleFonction, nouvelleEntreprise, nouvelleFiliere) {

    let xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function () {
        if (this.readyState == 4) {
            if (this.status == 200) {
                // Traitement après la mise à jour réussie
                console.log("Mise à jour réussie !");
            } else {
                // Gestion des erreurs
                console.error("Erreur lors de la mise à jour : " + this.status);
            }
        }
    }
    // Interrogation de l'api pour mettre à jour les informations de l'intervenant
    let requete = `http://localhost/WorkspaceWeb/sae-salon-eureka/api/mettre-a-jour-intervenant.php`;
    requete += `?nom=${nouveauNom}&fonction=${nouvelleFonction}&entreprise=${nouvelleEntreprise}&filiere=${nouvelleFiliere}`;

    console.log(requete);
    xmlhttp.open("GET", requete, true);
    xmlhttp.send();
}
