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
            if (this.responseText.trim() !== "") {
                let jsonResponse = JSON.parse(this.responseText);
                afficherDonnees(jsonResponse);
            } else {
                console.error("Réponse JSON vide.");
            }
        }
    }
     
    let requete = `http://localhost/WorkspaceWeb/sae-salon-eureka/api/rechercher-intervenant.php?nom=${filtreNom}&entreprise=${filtreEntreprise}`;
    console.log(requete);
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

let nomASupprimer = "";
let fonctionASupprimer = "";
let entrepriseASupprimer = "";
let filiereASupprimer = "";

function estCliquee(ligne) {
    // Retirer la classe "ligneSelectionnee" de toutes les autres lignes
    var lignes = displayTable.getElementsByTagName("tr");
    for (var i = 0; i < lignes.length; i++) {
        lignes[i].classList.remove("ligneSelectionnee");
    }
    // Mettre en évidence la ligne
    ligne.classList.add("ligneSelectionnee");

    // Stocker les données de la ligne
    let nom = ligne.children[0].innerText;
    let fonction = ligne.children[1].innerText;
    let entreprise = ligne.children[2].innerText;
    let filiere = ligne.children[3].innerText;

    nomASupprimer = nom;
    fonctionASupprimer = fonction;
    entrepriseASupprimer = entreprise;
    filiereASupprimer = filiere;

    console.log(ligne.classList);
}

let boutonSuppression = document.getElementById("boutonSupprimer");

boutonSuppression.addEventListener('click', () => confirmerSuppression(nomASupprimer, fonctionASupprimer, entrepriseASupprimer, filiereASupprimer));

function confirmerSuppression(nom, fonction, entreprise, filiere) {
    if (window.confirm(`Voulez-vous vraiment supprimer l'intervenant : ${nom} de l'entreprise ${entreprise} ?`)) {
        supprimerIntervenant(nom, fonction, entreprise, filiere);
    } else {
        // Si l'utilisateur annule, retirer le style de sélection
        ligne.classList.remove("ligneSelectionnee");
    }
}

function supprimerIntervenant(nom, fonction, entreprise, filiere) {
    // Effectuer la requête AJAX pour la suppression
    let xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function () {
        if (this.readyState == 4) {
            if (this.status == 200) {
                // Traitement après la suppression réussie
                console.log("Suppression réussie !");
                // Actualiser l'affichage ou prendre d'autres mesures si nécessaire
            } else {
                // Gestion des erreurs
                console.error("Erreur lors de la suppression : " + this.status);
            }
        }
    }

    let requete = `http://localhost/WorkspaceWeb/sae-salon-eureka/api/supprimer-intervenant.php`;
    requete += `?nom=${nom}&fonction=${fonction}&entreprise=${entreprise}&filiere=${filiere}`;

    console.log(requete);
    xmlhttp.open("GET", requete, true);
    xmlhttp.send();
}