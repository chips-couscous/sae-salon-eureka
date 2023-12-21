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
            console.log(this.responseText);
            let jsonResponse = JSON.parse(this.responseText);
            afficherDonnees(jsonResponse);
        }
    }
     
    let requete = `http://localhost/WorkspaceWeb/sae-salon-eureka/api/rechercher-intervenant.php?nom=${filtreNom}&entreprise=${filtreEntreprise}`;
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

// Récupérer toutes les lignes de la table
var lignes = displayTable.getElementsByTagName("tr");

// Ajouter un gestionnaire d'événements à chaque ligne
for (var i = 0; i < lignes.length; i++) {
    console.log(1);
  lignes[i].addEventListener("click", function() {
    // Appeler la fonction lorsque la ligne est cliquée
    estCliquee(this);
  });
}

// Récupérer toutes les lignes de la table
var champsModifs = document.getElementById("modifCliquee");

// Fonction à appeler lorsqu'une ligne est cliquée
function estCliquee(ligne) {
    console.log(ligne);
    champsModifs.innerHTML = ``;
    champsModifs.innerHTML += `
        <span>Modifier l'intervenant :</span><br>
            <form action="post">
                <div class="form-item bm15 ">
                    <input type="text" name="nom" id="nom" autocomplete="off" required>
                    <label for="nom">Nom *</label>
                </div>
                <select>` 
                += `</select>
                <div class="form-item bm15">
                    <input type="text" name="fonction" id="fonction" autocomplete="off" required>
                    <label for="fonction">Fonction *</label>
                </div>
                <div class="form-item bm15">
                    <input type="text" name="entreprise" id="entreprise" autocomplete="off" required>
                    <label for="entreprise">Entreprise *</label>
                </div>
                <div class="form-item bm15">
                    <input type="text" name="filiere" id="filiere" autocomplete="off" required>
                    <label for="filiere">Filiere *</label>
                </div>
                <div class="form-item">
                    <input type="submit" value="Ajouter">
                </div>
            </form>`;
    return true;
}