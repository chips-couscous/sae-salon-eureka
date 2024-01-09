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
                <a href="entreprises.php"><li class="hover-underline-active">liste des entreprises</li></a>
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
        <!-- liste des entreprises -->
        
      </div>
    </div>

    <script src="static/js/header.js"></script>
    <script src="static/js/entreprise.js"></script>
  </body>
</html>