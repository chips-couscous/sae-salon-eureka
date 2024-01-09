<!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Salon Eureka</title>

    <!-- css -->
    <link rel="stylesheet" href="static/css/main.css">
    <link rel="stylesheet" href="static/css/header.css">
    <link rel="stylesheet" href="static/css/entreprise.css">
    <link rel="stylesheet" href="static/css/connexion.css">

    <!-- fontawesome link -->
    <script src="https://kit.fontawesome.com/4d6659720c.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js" crossorigin="anonymous"></script>
  </head>
  <body>
    <header>
      <div class="menu-header">
        <!-- header logo -->
        <div class="header-brand">
          <span class="light">
            <i class="fa-solid fa-graduation-cap ic-wm-el-header"></i>SALON</span><span class="bold">EUREKA</span>
        </div>

        <!-- header responsive -->
        <div id="HeaderResponsive"></div>

        <!-- header taille initiale -->
        <div class="header-navigation" id="HeaderInitial">
          <div class="navigation-onglets">
            <nav>
              <ul>
                <li class="hover-underline-active">informations du forum</li>
                <li class="hover-underline-active">liste des entreprises</li>
              </ul>
            </nav>
          </div>
          <div class="navigation-compte">
            <nav>
              <ul>
                <li>
                  <i class="fa-regular fa-circle-user ic-wm-el-header"></i>
                  <div class="header-compte">
                    <span class="hover-underline-active"><a href="./panel/compte.html">Thomas Lemaire</a></span>
                    <!-- VIDE SI PAS CO -->
                    <span class="badge-status">étudiant</span>
                  </div>
                </li>
                <!-- VIDE SI PAS CO -->
                <li><i class="fa-regular fa-bell"></i></li>
              </ul>
            </nav>
          </div>
        </div>

        <!-- hambuger header responsive -->
        <div id="Biggachou"><span></span><span></span><span></span><span></span></div>
      </div>
    </header>

    <div class="container">
      <div class="container-content">
        <div class="rechercher-entreprise">
          <div class="form-item">
            <input type="text" name="rechercheEntreprise" id="RechercheEntreprise" autocomplete="off" required>
            <label for="RechercheEntreprise">Rechercher une entreprise</label>
          </div>
          <div class="btn-filtrer" id="AjouterFiltres">
            <span>Ajouter des filtres</span>
          </div>
        </div>

        <div class="liste-filtres">
          <div class="choix-filtres" id="ChoixFiltres">
            <input type="text" name="villeFiltre" id="VilleFiltre" placeholder="Choisir une ville">
            <select name="categorieFiltre" id="CategorieFiltre">
              <option value="">Nombre d'employé</option>
              <option value="1-9">1-9</option>
              <option value="10-99">10-99</option>
              <option value="100-499">100-499</option>
              <option value="500-999">500-999</option>
              <option value="1000 +">1000 +</option>
            </select>
          </div>
          <div class="filtres-actifs" id="FiltresActifs">

          </div>
        </div>
        <!-- liste des entreprises -->
        <div class="liste-entreprise" id="ListeE">
          <?php
            require ('static/module_php/panel/base_de_donnees.php');
            $pdo = connexionBaseDeDonnees();
            $requete = "SELECT *
                        FROM se_entreprise";
            $resultat = $pdo->prepare($requete);
            $resultat->execute();

            foreach($resultat as $row) {
              $requete = "SELECT libelle_categorie
                          FROM se_categorie
                          WHERE id_categorie = :idC";
              $stmt = $pdo->prepare($requete);
              $stmt->bindParam("idC", $row["categorie_entreprise"]);
              $stmt->execute();
              $categorieEntreprise = $stmt->fetch();
      
              $requete = "SELECT nom_secteur
                          FROM se_secteur
                          WHERE id_secteur = :idS";
              $stmt = $pdo->prepare($requete);
              $stmt->bindParam("idS", $row["secteur_entreprise"]);
              $stmt->execute();
              $secteurEntreprise = $stmt->fetch();

              echo '<div class="carte">';
              echo '<div class="entreprise-container"><div class="carte-entreprise">';
              echo '<div class="recto"><div class="identite">';
              echo '<img src="static/img/logo_entreprise/'.$row["logo_entreprise"].'" alt="Logo '.$row["nom_entreprise"].'" draggable="false">';
              echo '<span>'.$row["nom_entreprise"].'</span></div>';
              echo '<div class="tags">';
              echo '<span><i class="fa-solid fa-location-dot"></i>'.$row["nom_entreprise"].'</span>';
              echo '<span><i class="fa-solid fa-tag"></i>'.$secteurEntreprise['nom_secteur'].'</span>';
              echo '<span><i class="fa-solid fa-users"></i>'.$categorieEntreprise['libelle_categorie'].'</span></div></div>';
              echo '<div class="verso"><div class="description-container"><div class="description-content">'.$row["description_entreprise"].'</div></div>';
              echo '<div class="fin-verso"><div class="lien-site"><a href="#" class="hover-underline-active">'.$row["site_entreprise"].'</a></div>';    
              echo '<div class="btn-souhait"><span>Ajouter aux souhaits</span></div></div></div></div></div></div>';   
            }
            
          ?>
        </div>  
      </div>
    </div>

    <script src="static/js/header.js"></script>
    <script src="static/js/entreprise.js"></script>
  </body>
</html>