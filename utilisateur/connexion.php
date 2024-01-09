<?php
session_start();

$idUtilisateur = null;

if (isset($_POST['identifiant']) && isset($_POST['motDePasse'])) {
    require "./../static/module_php/panel/base_de_donnees.php";
    require "./../static/module_php/utilisateur/connexion_utilisateur.php";
    require "./../static/module_php/utilisateur/utilisateur.php";

    $pdo = connexionBaseDeDonnees();
    $idUtilisateur = verifierUneConnexionUtilisateur($pdo);
    validerUneSessionUtilisateur($idUtilisateur);
    $informationsUtilisateur = informationsPrimairesUtilisateurById($pdo, $idUtilisateur);

    if(validerUneSessionUtilisateur($idUtilisateur)) {
        header('Location: ./../index.php');
    }
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Salon Eureka | Connexion</title>

    <!-- css -->
    <link rel="stylesheet" href="./../static/css/main.css">
    <link rel="stylesheet" href="./../static/css/header.css">
    <link rel="stylesheet" href="./../static/css/utilisateur/connexion.css">

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
                    <i class="fa-solid fa-graduation-cap ic-wm-el-header"></i>SALON</span><span
                    class="bold">EUREKA</span>
            </div>

            <!-- header responsive -->
            <div id="HeaderResponsive"></div>

            <!-- header taille initiale -->
            <div class="header-navigation" id="HeaderInitial">
                <div class="navigation-onglets">
                    <nav>
                        <ul>
                            <li class="hover-underline-active">informations du forum</li>
                            <li class="hover-underline-active"><a href="./../index.html">liste des entreprises</a></li>
                        </ul>
                    </nav>
                </div>
                <div class="navigation-compte">
                    <nav>
                        <ul>
                            <li>
                                <i class="fa-regular fa-circle-user ic-wm-el-header"></i>
                                <div class="header-compte">
                                    <span class="hover-underline-active"><?php echo $idUtilisateur != null ? $informationsUtilisateur['prenom_utilisateur'] . " " . $informationsUtilisateur['nom_utilisateur'] : "Se connecter" ?></span>
                                    <?php echo $idUtilisateur != null ? "<span class='badge-status'>" . $informationsUtilisateur['libelle_statut'] . "</span>" : "" ?>
                                </div>
                            </li>
                            <?php echo $idUtilisateur != null ? "<li><i class='fa-regular fa-bell'></i></li>" : "" ?>
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
            <span class="titre"><!--Se connecter--></span>
            <form action="./connexion.php" method="post">
                <?php if ($idUtilisateur == null && isset($_POST['identifiant']) && isset($_POST['motDePasse'])) { echo "<span class='bm15'>Identifiant ou mot de passe incorrect</span>"; } ?>

                <div class="form-item bm15">
                    <input type="text" name="identifiant" id="Identifiant" autocomplete="off" required>
                    <label for="Identifiant">Identifiant</label>
                  </div>
                  
                  <div class="form-item bm15">
                    <input type="password" name="motDePasse" id="MotDePasse" autocomplete="off" required>
                    <label for="MotDePasse">Mot de passe</label>
                  </div>

                  <div class="form-item">
                    <input type="submit" value="Se connecter">
                  </div>
            </form>
        </div>
    </div>

    <?php echo $idUtilisateur; ?>

    <script src="./../static/js/header.js"></script>
</body>

</html>