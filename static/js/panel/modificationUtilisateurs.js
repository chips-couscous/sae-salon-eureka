const inputPrenom = document.getElementById('triUtilisateur');
const displayTable = document.getElementById('tableListeUtilisateur');
const selectStatut = document.getElementById('typeUtilisateur');
const selectFiliere = document.getElementById('filiere');
const boutonAjouterFiliere = document.getElementById('boutonAjouterFiliere');
const itemFiliere = document.getElementById('listeDesFiliere');
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
        compteur++;

        // Récupération de la liste des filières depuis le cookie
        const listeFiliereJSON = document.cookie
            .split('; ')
            .map(cookie => cookie.split('='))
            .find(([name]) => name === 'liste_filiere_cookie');

        // Vérification si le cookie existe
        if (listeFiliereJSON) {
            // Extraction de la valeur du cookie
            const listeFiliere = JSON.parse(decodeURIComponent(listeFiliereJSON[1]));

            // Construction de la structure HTML avec les filières
            let optionsHTML = listeFiliere.map(filiere => `<option value="${filiere.idFiliere}">${filiere.libelleFiliere}</option>`).join('');

            // Création du div pour la nouvelle filière
            let divFiliere = document.createElement('div');
            divFiliere.classList.add('filiereAjoutee');

            // Création du select
            let selectFiliere = document.createElement('select');
            selectFiliere.name = `filiere${compteur}`;  // Ajout du numéro du compteur au name
            selectFiliere.id = `filiere${compteur}`;    // Ajout du numéro du compteur à l'id
            selectFiliere.innerHTML = optionsHTML;

            // Création du bouton de suppression
            let boutonSupprimer = document.createElement('button');
            boutonSupprimer.innerText = 'X';
            boutonSupprimer.addEventListener('click', () => {
                // Supprimer le divFiliere parent lorsque le bouton de suppression est cliqué
                divFiliere.remove();
                compteur--;
            });

            // Ajout du select et du bouton de suppression au divFiliere
            divFiliere.appendChild(selectFiliere);
            divFiliere.appendChild(boutonSupprimer);

            // Ajout du divFiliere à l'élément parent
            itemFiliere.appendChild(divFiliere);
        }
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
    console.log(requete);
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
            <td>${utilisateur['filieres']}</td>
            <td>${utilisateur['libelle_statut']}</td>
        </tr>
        `;
    }
    affichageModif()
}

function affichageModif() {
    let lignesTable = document.getElementsByClassName('item-utilisateur');

    for (let index = 0; index < lignesTable.length; index++) {
        lignesTable[index].addEventListener('click', () => {
            let filieresAjoutees = itemFiliere.querySelectorAll('.filiereAjoutee');
            filieresAjoutees.forEach(element => {
                element.remove();
            });
            compteur = 0;

            // Récupération des données de la ligne cliquée
            const colonnes = lignesTable[index].getElementsByTagName('td');
            const id = colonnes[0].innerText;
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
            const idUtilisateur = document.getElementById('idUtilisateur');
            const prenomUtilisateur = document.getElementById('prenomUtilisateur');
            const nomUtilisateur = document.getElementById('nomUtilisateur');
            const emailUtilisateur = document.getElementById('mailUtilisateur');
            const mdpUtilisateur = document.getElementById('mdpUtilisateur');
            const listeDesFiliere = document.getElementById('filiereUtilisateur');
            const statutUtilisateur = document.getElementById('statutUtilisateur');

            idUtilisateur.value = id;
            prenomUtilisateur.value = prenom;
            nomUtilisateur.value = nom;
            emailUtilisateur.value = email;
            mdpUtilisateur.value = mdp;

            for (let i = 0; i < statutUtilisateur.options.length; i++) {
                if (statutUtilisateur.options[i].innerText === statut) {
                    statutUtilisateur.options[i].selected = true;
                    break;
                }
            }

            const filieresUtilisateur = filiere.split(', ');

            for (let i = 0; i < filieresUtilisateur.length; i++) {
                if (i == 0) {
                    for (let k = 0; k < listeDesFiliere.options.length; k++) {
                        if (listeDesFiliere.options[k].innerText.trim() === filieresUtilisateur[i].trim()) {
                            console.log("Je suis la");
                            listeDesFiliere.options[k].selected = true;
                        }
                    }
                } else {
                    boutonAjouterFiliere.click();
                }
            }

            
            
 
            for (let k = 1; k < filieresUtilisateur.length; k++) {
                
            }


            // Gestion de l'affichage en fonction du statut
            if (statut === 'Gestionnaire') {
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





affichageModif();
