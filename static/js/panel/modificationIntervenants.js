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