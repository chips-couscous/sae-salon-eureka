const inputPrenom = document.getElementById('nomUtilisateur');
const displayTable = document.getElementById('TablePrevisualisation');
const selectStatut = document.getElementById('typeUtilisateur');

inputPrenom.addEventListener('keyup', () => {
    chargerDonnees(inputPrenom.value, selectStatut.value);
})

selectStatut.addEventListener('change', () => {
    chargerDonnees(inputPrenom.value, selectStatut.value);
})

function chargerDonnees(filtrePrenom, filtreStatut) {
    let xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function () {
        if(this.readyState == 4 && this.status == 200) {
            let jsonResponse = JSON.parse(this.responseText);
            afficherDonnees(jsonResponse);
        }
    }

    let requete = `http://localhost/WorkspaceWeb/sae-salon-eureka/api/m_utilisateur.php?prenom=${filtrePrenom}&statut=${filtreStatut}`;
    xmlhttp.open("GET", requete, true);
    xmlhttp.send();
}

function afficherDonnees(donnees) {
    displayTable.innerHTML = '';
    for (let i = 0; i < donnees.length; i++) {
        let utilisateur = donnees[i];
        displayTable.innerHTML += `
        </tr>
            <td>${utilisateur['id_utilisateur']}</td>
            <td>${utilisateur['prenom_utilisateur']}</td>
            <td>${utilisateur['nom_utilisateur']}</td>
            <td>${utilisateur['mail_utilisateur']}</td>
            <td>${utilisateur['mdp_utilisateur']}</td>
            <td>${utilisateur['libelle_statut']}</td>
        </tr>
        `;
    }
}