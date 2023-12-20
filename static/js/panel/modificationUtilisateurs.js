const inputPrenom = document.getElementById('nomUtilisateur');
const displayTable = document.getElementById('tableListeUtilisateur');
const selectStatut = document.getElementById('typeUtilisateur');
const selectFiliere = document.getElementById('filiere');
const lignesTable = document.querySelectorAll('#tableListeUtilisateur tr');

inputPrenom.addEventListener('keyup', () => {
    chargerDonnees(inputPrenom.value, selectStatut.value, selectFiliere.value);
});

selectStatut.addEventListener('change', () => {
    chargerDonnees(inputPrenom.value, selectStatut.value, selectFiliere.value);
});

selectFiliere.addEventListener('change', () => {
    chargerDonnees(inputPrenom.value, selectStatut.value, selectFiliere.value);
})

function chargerDonnees(filtrePrenom, filtreStatut, filtreFiliere) {
    let xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function () {
        if(this.readyState == 4 && this.status == 200) {
            let jsonResponse = JSON.parse(this.responseText);
            afficherDonnees(jsonResponse);
        }
    }

    let requete = `http://localhost/WorkspaceWeb/sae-salon-eureka/api/rechercher-utilisateur.php?prenom=${filtrePrenom}&statut=${filtreStatut}&filiere=${filtreFiliere}`;
    xmlhttp.open("GET", requete, true);
    xmlhttp.send();
}

function afficherDonnees(donnees) {
    displayTable.innerHTML = '';
    for (let i = 0; i < donnees.length; i++) {
        let utilisateur = donnees[i];
        displayTable.innerHTML += `
        <tr class='cliquable'>
            <td>${utilisateur['id_utilisateur']}</td>
            <td>${utilisateur['prenom_utilisateur']}</td>
            <td>${utilisateur['nom_utilisateur']}</td>
            <td>${utilisateur['mail_utilisateur']}</td>
            <td>${utilisateur['mdp_utilisateur']}</td>
            <td>${utilisateur['libelle_filiere']}</td>
            <td>${utilisateur['libelle_statut']}</td>
        </tr>
        `;
    }
}


function afficherDonnees() {
    lignesTable.forEach((ligne, index) => {
    if (index !== 0) { // Évite l'en-tête de la table
        ligne.addEventListener('click', () => {
           return true;
        });
    }
    });
}