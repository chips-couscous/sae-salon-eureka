// Récupération de toutes les lignes de la table
const lignesTable = document.querySelectorAll('#tableListeUtilisateur tr');

// Ajout d'un écouteur d'événements 'click' à chaque ligne, sauf à l'en-tête
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






















