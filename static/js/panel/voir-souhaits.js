/* Déclaration de variable */
let zoneSaisieRechercheEtudiant = document.getElementById("RechercheEtudiant");
let zoneAfficherEtudiant = document.getElementById("listeEtudiant");
let zoneSouhaits = document.getElementById("listeSouhaits");
let zoneEtudiantSelectionne = document.getElementById("etudiantSelectionne");

/* Ajout eventListener */
zoneSaisieRechercheEtudiant.addEventListener("input", () => {
    chargerDonnees(zoneSaisieRechercheEtudiant.value)
});

/** AJAX récupérant les données de la requete */
function chargerDonnees(filtrePrenom) {
    let rechercheEtudiant = new XMLHttpRequest();
    rechercheEtudiant.onreadystatechange = function () {
        if(this.readyState == 4 && this.status == 200) {
            let jsonResponse = JSON.parse(this.responseText);
            afficherDonnees(jsonResponse);
        }
    }

    let requete = `http://localhost/SAE/sae-salon-eureka/api/rechercher-etudiant.php?prenom=${filtrePrenom}`;
    rechercheEtudiant.open("GET", requete, true);
    rechercheEtudiant.send();
}

/** Affiche les données dans un tableau */
function afficherDonnees(donnees) {
    zoneAfficherEtudiant.innerHTML = "";
    donnees.forEach(etudiant => {
        zoneAfficherEtudiant.innerHTML += 
        `<div class="row">
            <div class="id"><span>${etudiant["id_utilisateur"]}</span></div>
            <div class="prenom"><span>${etudiant["prenom_utilisateur"]}</span></div>
            <div class="nom"><span>${etudiant["nom_utilisateur"]}</span></div>
            <div class="mail"><span>${etudiant["mail_utilisateur"]}</span></div>
            <div class="filiere"><span>${etudiant['libelle_filiere']}</span></div>
        </div>`;
    });
    rendreClickable();
}

/** Ajoute un eventListener à toutes les lignes du tableau */
function rendreClickable() {
    const lignesTable = document.querySelectorAll('#listeEtudiant div.row');
    lignesTable.forEach(ligne => {
        ligne.classList.add("clickable");
        ligne.addEventListener("click", () => {
            rechercherSouhaits(ligne.getElementsByClassName('id')[0].innerText)
            zoneAfficherEtudiant.innerHTML = '';
            zoneEtudiantSelectionne.innerHTML = `Souhaits de : <span class="prenom">${ligne.getElementsByClassName('prenom')[0].innerText}</span> <span class="nom">${ligne.getElementsByClassName('nom')[0].innerText}</span>`;
        });
    });
}

/** Recherche les souhaits de l'utilisateur avec un appel AJAX */
function rechercherSouhaits(idUtilisateur) {
    let rechercheSouhaits = new XMLHttpRequest();
    rechercheSouhaits.onreadystatechange = function () {
        if(this.readyState == 4 && this.status == 200) {
            let listeSouhaits = JSON.parse(this.responseText);
            afficherSouhaits(listeSouhaits);
        }
    }

    let requete = `http://localhost/SAE/sae-salon-eureka/api/rechercher-souhaits.php?idUtilisateur=${idUtilisateur}`;
    rechercheSouhaits.open("GET", requete, true);
    rechercheSouhaits.send();
}

/** Affiche les résultats obtenu lors de la recherche de souhaits */
function afficherSouhaits(listeSouhaits) {
    let cartesSouhait = ""
    zoneSouhaits.innerHTML = "";
    listeSouhaits.forEach(souhait => {
        cartesSouhait += '<div class="entreprise-souhait">';
        cartesSouhait += '<div class="carte"><div class="entreprise-container"><div class="carte-entreprise"><div class="recto"><div class="identite">';
        cartesSouhait += '<img src="../static/img/logo_entreprise/'+souhait["logo_entreprise"]+'" alt="Logo '+souhait["nom_entreprise"]+'" draggable="false">';
        cartesSouhait += '<span>'+souhait["nom_entreprise"]+'</span></div>';
        cartesSouhait += '<div class="tags">';
        cartesSouhait += '<span><i class="fa-solid fa-location-dot"></i>'+souhait["nom_entreprise"]+'</span>';
        cartesSouhait += '<span><i class="fa-solid fa-tag"></i>'+souhait['nom_secteur']+'</span>';
        cartesSouhait += '<span><i class="fa-solid fa-users"></i>'+souhait['libelle_categorie']+'</span></div></div>';
        cartesSouhait += '<div class="verso"><div class="description-container"><div class="description-content">'+souhait["description_entreprise"]+'</div></div>';
        cartesSouhait += '<div class="fin-verso"><div class="lien-site"><a target="blank" href="https://'+souhait["site_entreprise"]+'" class="hover-underline-active">'+souhait["site_entreprise"]+'</a></div>';
        cartesSouhait += '</div></div></div></div></div></div>';
    });
    zoneSouhaits.innerHTML = cartesSouhait;
}