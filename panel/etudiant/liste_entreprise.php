<?php
session_start();
if (!isset($_SESSION['idUtilisateur'])) {
  header('Location: ../../utilisateur/connexion.php');
}

require "../../static/module_php/utilisateur/utilisateur.php";
require "../../static/module_php/utilisateur/connexion_utilisateur.php";
require "../../static/module_php/base_de_donnees.php";
require "../../static/module_php/panel/entreprise.php";

$pdo = connexionBaseDeDonnees();
$idUtilisateur = $_SESSION['idUtilisateur'];
$informationsUtilisateur = informationsPrimairesUtilisateurById($pdo, $idUtilisateur);

if (isset($_POST["ajouterSouhait"])) {
  ajouterAuxSouhaits($pdo, $_POST["ajouterSouhait"], $_SESSION['idUtilisateur']);
}

if (isset($_POST["retirerSouhait"])) {
  retirerDesSouhaits($pdo, $_POST["retirerSouhait"], $_SESSION['idUtilisateur']);
}

?>
<!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Salon Eureka</title>

    <!-- css -->
    <link rel="stylesheet" href="../../static/css/main.css">
    <link rel="stylesheet" href="../../static/css/header.css">
    <link rel="stylesheet" href="../../static/css/connexion.css">
    <link rel="stylesheet" href="../../static/css/entreprise.css">

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
                        <li class="hover-underline-active"><a href="../../index.php">informations du forum</a></li>
                        <li class="hover-underline-active"><a href="">liste des entreprises</a></li>
                    </ul>
                </nav>
            </div>
            <div class="navigation-compte">
                <nav>
                    <ul>
                        <li>
                            <i class="fa-regular fa-circle-user ic-wm-el-header"></i>
                            <div class="header-compte">
                                <a class="hover-underline-active" href=<?php echo validerUneSessionUtilisateur($idUtilisateur) ? "\"#\">" . $informationsUtilisateur['prenom_utilisateur'] . " " . $informationsUtilisateur['nom_utilisateur'] : "\"./utilisateur/connexion.php\">" . "Se connecter" ?></a>
                                <?php echo validerUneSessionUtilisateur($idUtilisateur) ? "<span class='badge-status'>" . $informationsUtilisateur['libelle_statut'] . "</span>" : "" ?>
                            </div>
                        </li>
                        <?php echo validerUneSessionUtilisateur($idUtilisateur) ? "<li><i class='fa-regular fa-bell'></i></li>" : "" ?>
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
            $filiereUtilisateur = getFiliereUtilisateur($pdo, $idUtilisateur);
            $listeEntreprise = getListeEntreprise($pdo, $filiereUtilisateur);
            foreach($listeEntreprise as $entreprise) {
              echo '<form action="" method="post" class="entreprise-souhait">';
              echo '<div class="carte">';
              echo '<div class="entreprise-container"><div class="carte-entreprise';
              if (estSouhait($pdo, $entreprise["id_entreprise"], $_SESSION['idUtilisateur'])) {
                echo ' est-souhait"';
              } else {
                echo '"'; 
              }
              echo '>';
              echo '<div class="recto"><div class="identite">';
              echo '<img src="../../static/img/logo_entreprise/'.$entreprise["logo_entreprise"].'" alt="Logo '.$entreprise["nom_entreprise"].'" draggable="false">';
              echo '<span>'.$entreprise["nom_entreprise"].'</span></div>';
              echo '<div class="tags">';
              echo '<span><i class="fa-solid fa-location-dot"></i>'.$entreprise["nom_entreprise"].'</span>';
              echo '<span><i class="fa-solid fa-tag"></i>'.$entreprise['nom_secteur'].'</span>';
              echo '<span><i class="fa-solid fa-users"></i>'.$entreprise['libelle_categorie'].'</span></div></div>';
              echo '<div class="verso"><div class="description-container"><div class="description-content">'.$entreprise["description_entreprise"].'</div></div>';
              echo '<div class="fin-verso"><div class="lien-site"><a target="blank" href="https://'.$entreprise["site_entreprise"].'" class="hover-underline-active">'.$entreprise["site_entreprise"].'</a></div>';    
              if (estSouhait($pdo, $entreprise["id_entreprise"], $_SESSION['idUtilisateur'])) {
                echo '<div class="btn-souhait"><input type="hidden" name="retirerSouhait" value="'.$entreprise["id_entreprise"].'"><input type="submit" value="Retirer des souhaits"></div>';
              } else {
                echo '<div class="btn-souhait"><input type="hidden" name="ajouterSouhait" value="'.$entreprise["id_entreprise"].'"><input type="submit" value="Ajouter aux souhaits"></div>';
              }
              echo '</div></div></div></div></div></form>';
            }
          ?>
        </div>  
      </div>
    </div>

    <script src="static/js/header.js"></script>
    <script src="static/js/entreprise.js"></script>
  </body>
</html>