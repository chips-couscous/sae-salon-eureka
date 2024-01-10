// Récupération de toutes les lignes de la table
const listeUtilisateur = document.getElementById('tableListeUtilisateur');
const inputPrenom = document.getElementById('triUtilisateur');
const selectStatut = document.getElementById('typeUtilisateur');
const selectFiliere = document.getElementById('filiere');
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
    console.log(requete);
    xmlhttp.open("GET", requete, true);
    xmlhttp.send();
}

function afficherDonnees(donnees) {
    listeUtilisateur.innerHTML = `<tr>
                                <th>Identifiant</th>
                                <th>Prenom</th>
                                <th>Nom</th>
                                <th>Email</th>
                                <th>Mot de passe</th>
                                <th>Filiere</th>
                                <th>Statut</th>
                            </tr>`;
    for (let i = 0; i < donnees.length; i++) {
        let utilisateur = donnees[i];
        listeUtilisateur.innerHTML += `
        <tr class='cliquable item-utilisateur'>
            <td>${utilisateur['id_utilisateur']}</td>
            <td>${utilisateur['prenom_utilisateur']}</td>
            <td>${utilisateur['nom_utilisateur']}</td>
            <td>${utilisateur['mail_utilisateur']}</td>
            <td>${utilisateur['mdp_utilisateur']}</td>
            <td>${utilisateur['filieres']}</td>
            <td>${utilisateur['libelle_statut']}</td>
        </tr>
        `;
    }
    ligneCliquable();
}

// Ajout d'un écouteur d'événements 'click' à chaque ligne, sauf à l'en-tête
function ligneCliquable() {
    const lignesTable = document.querySelectorAll('#tableListeUtilisateur tr');
    lignesTable.forEach((ligne, index) => {
        if (index !== 0) { // Évite l'en-tête de la table
            ligne.addEventListener('click', () => {
              // Récupération des données de la ligne cliquée
              const colonnes = lignesTable[index].getElementsByTagName('td');
              const id = colonnes[0].innerText;
              const prenom = colonnes[1].innerText;
              const nom = colonnes[2].innerText;
              const email = colonnes[3].innerText;
              const mdp = colonnes[4].innerText;
              const filiere = colonnes[5].innerText;
              const statut = colonnes[6].innerText;
      
              // Affichage des données sélectionnées sous la table
              const donneesSelectionnees = document.getElementById('affichageUtilisateur');
              
              ecriture =  `
                                              <div>
                                              <form method = "post">
                                              <div class="form-donnees-supprimer">
      
                                                  <div class="form-item">
                                                      <span class="readonly">${prenom}</span>
                                                  </div>
                                                  <div class="form-item">
                                                      <span class="readonly">${nom}</span>
                                                  </div>
                                                  <div class="form-item">
                                                      <span class="readonly">${email}</span>
                                                  </div>
                                                  <div class="form-item">
                                                      <span class="readonly">${mdp}</span>
                                                  </div>
                                                  <div class="form-item">
                                                      <span class="readonly">${filiere}</span>
                                                  </div>
                                                  <div class="form-item">
                                                      <input type="text" name="statutUtilisateur" id="statutUtilisateur" readonly value="${statut}">
                                                      <label for="statutUtilisateur">Statut : ${statut}</label>
                                                  </div>
                                              </div>
                                              `;
              // Gestion de l'affichage en fonction du statut
              if (statut === 'Gestionnaire' || statut === 'Administrateur') {
                  ecriture +=  ` 
                                              <div class="form-item">
                                                  <input type="text" name="motDePasseAdmin" id="motDePasseAdmin" autocomplete="off" value="" required>
                                                  <label for="motDePasseAdmin"> Veuillez rentrer un mot de passe : </label>
                                              </div>
                                              `;
              } 
      
              ecriture += `
                                                  
                                                  <div class="form-item">
                                                      <input type="hidden" name="idUtilisateur" id="idUtilisateur" value="${id}">
                                                  </div>
                                                  <div class="form-item">
                                                      <input type="submit" value="Supprimer" id="boutonSupprimer">
                                                  </div>
                                              </form>`;
              
              donneesSelectionnees.innerHTML = ecriture;
          });
        }
    });

}

ligneCliquable();
