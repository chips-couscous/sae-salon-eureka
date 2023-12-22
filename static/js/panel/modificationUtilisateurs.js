const inputPrenom = document.getElementById('triUtilisateur');
const displayTable = document.getElementById('tableListeUtilisateur');
const selectStatut = document.getElementById('typeUtilisateur');
const selectFiliere = document.getElementById('filiere');
const boutonAjouterFiliere = document.getElementById('boutonAjouterFiliere');

const itemFiliere = document.getElementById('ItemSelecteFiliere');
compteur = 0;

inputPrenom.addEventListener('keyup', () => {
    chargerDonnees(inputPrenom.value, selectStatut.value, selectFiliere.value);
});

selectStatut.addEventListener('change', () => {
    chargerDonnees(inputPrenom.value, selectStatut.value, selectFiliere.value);
});

selectFiliere.addEventListener('change', () => {
    chargerDonnees(inputPrenom.value, selectStatut.value, selectFiliere.value);
})

boutonAjouterFiliere.addEventListener('click', () => {
    if (compteur <= 3) {
        compteur ++;
        let lesFilieres = document.getElementById('toutesLesFilieres').innerHTML;
        itemFiliere.innerHTML += lesFilieres;
    }
});

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
    displayTable.innerHTML = `<tr>
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
        displayTable.innerHTML += `
        <tr class='cliquable item-utilisateur'>
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
    
    affichageModif()
}

function ajoutFiliere() {
    boutonAjouterFiliere.innerHTML += ``;
}

function affichageModif() {
    let lignesTable = document.getElementsByClassName('item-utilisateur');

    for (let index = 0; index < lignesTable.length; index++) {
        lignesTable[index].addEventListener('click', () => {
            // Récupération des données de la ligne cliquée
            const colonnes = lignesTable[index].getElementsByTagName('td');
            
            const prenom = colonnes[1].innerText;
            const nom = colonnes[2].innerText;
            const email = colonnes[3].innerText;
            const mdp = colonnes[4].innerText;
            const filiere = colonnes[5].innerText;
            const statut = colonnes[6].innerText;
            
    
            // Changement du CSS
            const donneesSelectionnees = document.getElementById('affichageModification');
            donneesSelectionnees.classList.remove('affichageModificationCache');
            donneesSelectionnees.classList.add('affichageModification');
    
            
            const prenomUtilisateur = document.getElementById('prenomUtilisateur');
            const nomUtilisateur = document.getElementById('nomUtilisateur');
            const emailUtilisateur = document.getElementById('mailUtilisateur');
            const mdpUtilisateur = document.getElementById('mdpUtilisateur');
            const filiereUtilisateur = document.getElementById('filiereUtilisateur');
            const statutUtilisateur = document.getElementById('statutUtilisateur');
    
            prenomUtilisateur.value = prenom;
            nomUtilisateur.value = nom;
            emailUtilisateur.value = email;
            mdpUtilisateur.value = mdp;

            for (var i = 0; i < statutUtilisateur.options.length; i++) {
                if (statutUtilisateur.options[i].innerText === statut) {
                    statutUtilisateur.options[i].selected = true;
                    break;
                }
            }
            for (var i = 0; i < filiereUtilisateur.options.length; i++) {
                if (filiereUtilisateur.options[i].innerText === filiere) {
                    filiereUtilisateur.options[i].selected = true;
                    break;
                }
            }
            
    
            if (statut == 'Gestionnaire') {
                boutonAjouterFiliere.classList.remove('affichageModificationCache');
                boutonAjouterFiliere.classList.add('afficherAjout');
            } else {
                boutonAjouterFiliere.classList.remove('afficherAjout');
                boutonAjouterFiliere.classList.add('affichageModificationCache');
                
            }

        });
        
    }

    return lignesTable;
}

affichageModif()