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
                                        <form method = "post" >
                                            <div class="form-item">
                                                <input type="text" name="idUtilisateur" id="idUtilisateur" readonly" value="${id}">
                                                    <label for="idUtilisateur">Id : ${id} </label>
                                            </div>
                                            <div class="form-item">
                                                <input type="text" name="prenomUtilisateur" id="prenomUtilisateur" readonly value="${prenom}">
                                                    <label for="prenomUtilisateur">Prenom : ${prenom}</label>
                                            </div>
                                            <div class="form-item">
                                                <input type="text" name="nomUtilisateur" id="nomUtilisateur" readonly value="${nom}">
                                                <label for="nomUtilisateur">Nom : ${nom}</label>
                                            </div>
                                            <div class="form-item">
                                                <input type="text" name="mailUtilisateur" id="mailUtilisateur" readonly value="${email}">
                                                <label for="mailUtilisateur">Email : ${email}</label>
                                            </div>
                                            <div class="form-item">
                                                <input type="text" name="mdpUtilisateur" id="mdpUtilisateur" readonly value="${mdp}">
                                                <label for="mdpUtilisateur">Mot de passe : ${mdp}</label>
                                            </div>
                                            <div class="form-item">
                                                <input type="text" name="filiereUtilisateur" id="filiereUtilisateur" readonly value="${filiere}">
                                                <label for="filiereUtilisateur">Filiere : ${filiere}</label>
                                            </div>
                                            <div class="form-item">
                                                <input type="text" name="statutUtilisateur" id="statutUtilisateur" readonly value="${statut}">
                                                <label for="statutUtilisateur">Statut : ${statut}</label>
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
            console.log("On est la avant");
        } 

        ecriture += `
                                            <div class="form-item">
                                                <input type="submit" value="Supprimer">
                                            </div>
                                        </form>`;
                                    
                                        console.log("Rip");
        
        donneesSelectionnees.innerHTML = ecriture;
    });
  }
});




