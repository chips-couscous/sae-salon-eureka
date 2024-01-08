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
        <div class="liste-entreprise">

          <div class="carte">
            <div class="entreprise-container">
              <div class="carte-entreprise">
                <div class="recto">
                  <div class="identite">
                    <img src="static/img/logo_entreprise/sopra.png" alt="Logo sopra" draggable="false">
                    <span>Sopra</span>
                  </div>
                  <div class="tags">
                    <span><i class="fa-solid fa-location-dot"></i>Rodez</span>
                    <span><i class="fa-solid fa-tag"></i>Informatique</span>
                    <span><i class="fa-solid fa-users"></i>10-100</span>
                  </div>
                </div>
                <div class="verso">
                  <div class="description-container">
                    <div class="description-content">
                      Lorem, ipsum dolor sit amet consectetur adipisicing elit. Debitis, enim consequuntur! Ad vero exercitationem quidem, nesciunt deleniti fugit odio magni. Qui officiis consequatur, explicabo autem eaque ducimus beatae earum dignissimos ?
                      Lorem ipsum, dolor sit amet consectetur adipisicing elit. Ducimus officiis tenetur saepe recusandae quia delectus eaque aliquid doloribus repudiandae minus. Libero assumenda dolore nostrum quam officiis quibusdam itaque nisi corporis.
                      Lorem ipsum dolor sit amet consectetur adipisicing elit. Architecto maxime quisquam facere. Rerum modi quam aut ducimus laborum, velit unde autem! Voluptate ducimus reiciendis est. Quasi autem facere ad doloribus?
                    </div>
                  </div>
                  <div class="fin-verso">
                    <div class="lien-site">
                      <a href="#" class="hover-underline-active">Sopra.com</a>
                    </div>
                    <div class="btn-souhait">
                      <span>Ajouter aux souhaits</span>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="carte">
            <div class="entreprise-container">
              <div class="carte-entreprise">
                <div class="recto">
                  <div class="identite">
                    <img src="static/img/logo_entreprise/carre_boir.png" alt="Logo sopra" draggable="false">
                    <span>Carré noir</span>
                  </div>
                  <div class="tags">
                    <span><i class="fa-solid fa-location-dot"></i>Paris</span>
                    <span><i class="fa-solid fa-tag"></i>Informatique</span>
                    <span><i class="fa-solid fa-users"></i>1-10</span>
                  </div>
                </div>
                <div class="verso">
                  <div class="description-container">
                    <div class="description-content">
                      Lorem ipsum, dolor sit amet consectetur adipisicing elit. Ducimus officiis tenetur saepe recusandae quia delectus eaque aliquid doloribus repudiandae minus. Libero assumenda dolore nostrum quam officiis quibusdam itaque nisi corporis.
                    </div>
                  </div>
                  <div class="fin-verso">
                    <div class="lien-site">
                      <a href="#" class="hover-underline-active">Sopra.com</a>
                    </div>
                    <div class="btn-informations">
                      <span>Plus d'informations</span>
                    </div>
                    <div class="btn-souhait">
                      <span>Ajouter aux souhaits</span>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="carte">
            <div class="entreprise-container">
              <div class="carte-entreprise">
                <div class="recto">
                  <div class="identite">
                    <img src="static/img/logo_entreprise/dragon_rouge.png" alt="Logo sopra" draggable="false">
                    <span>Dragon Rouge</span>
                  </div>
                  <div class="tags">
                    <span><i class="fa-solid fa-location-dot"></i>Paris</span>
                    <span><i class="fa-solid fa-tag"></i>Informatique</span>
                    <span><i class="fa-solid fa-users"></i>1-10</span>
                  </div>
                </div>
                <div class="verso">
                  <div class="description-container">
                    <div class="description-content">
                      Lorem, ipsum dolor sit amet consectetur adipisicing elit. Debitis, enim consequuntur! Ad vero exercitationem quidem, nesciunt deleniti fugit odio magni. Qui officiis consequatur, explicabo autem eaque ducimus beatae earum dignissimos ?
                      Lorem, ipsum dolor sit amet consectetur adipisicing elit. Debitis, enim consequuntur! Ad vero exercitationem quidem, nesciunt deleniti fugit odio magni.
                    </div>
                  </div>
                  <div class="fin-verso">
                    <div class="lien-site">
                      <a href="#" class="hover-underline-active">Sopra.com</a>
                    </div>
                    <div class="btn-informations">
                      <span>Plus d'informations</span>
                    </div>
                    <div class="btn-souhait">
                      <span>Ajouter aux souhaits</span>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="carte">
            <div class="entreprise-container">
              <div class="carte-entreprise">
                <div class="recto">
                  <div class="identite">
                    <img src="static/img/logo_entreprise/credit_agricole.png" alt="Logo sopra" draggable="false">
                    <span>Crédit Agricole</span>
                  </div>
                  <div class="tags">
                    <span><i class="fa-solid fa-location-dot"></i>Paris</span>
                    <span><i class="fa-solid fa-tag"></i>Infocom</span>
                    <span><i class="fa-solid fa-users"></i>100-500</span>
                  </div>
                </div>
                <div class="verso">
                  <div class="description-container">
                    <div class="description-content">
                      Lorem, ipsum dolor sit amet consectetur adipisicing elit. Debitis, enim consequuntur! Ad vero exercitationem quidem, nesciunt deleniti fugit odio magni. Qui officiis consequatur, explicabo autem eaque ducimus beatae earum dignissimos ?
                      Lorem ipsum, dolor sit amet consectetur adipisicing elit. Ducimus officiis tenetur saepe recusandae quia delectus eaque aliquid doloribus repudiandae minus. Libero assumenda dolore nostrum quam officiis quibusdam itaque nisi corporis.
                    </div>
                  </div>
                  <div class="fin-verso">
                    <div class="lien-site">
                      <a href="#" class="hover-underline-active">Sopra.com</a>
                    </div>
                    <div class="btn-informations">
                      <span>Plus d'informations</span>
                    </div>
                    <div class="btn-souhait">
                      <span>Ajouter aux souhaits</span>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="carte">
            <div class="entreprise-container">
              <div class="carte-entreprise">
                <div class="recto">
                  <div class="identite">
                    <img src="static/img/logo_entreprise/bosch.jpg" alt="Logo sopra" draggable="false">
                    <span>Bosch</span>
                  </div>
                  <div class="tags">
                    <span><i class="fa-solid fa-location-dot"></i>Paris</span>
                    <span><i class="fa-solid fa-tag"></i>Informatique</span>
                    <span><i class="fa-solid fa-users"></i>500-1000</span>
                  </div>
                </div>
                <div class="verso">
                  <div class="description-container">
                    <div class="description-content">
                      Lorem, ipsum dolor sit amet consectetur adipisicing elit. Debitis, enim consequuntur!
                    </div>
                  </div>
                  <div class="fin-verso">
                    <div class="lien-site">
                      <a href="#" class="hover-underline-active">Sopra.com</a>
                    </div>
                    <div class="btn-informations">
                      <span>Plus d'informations</span>
                    </div>
                    <div class="btn-souhait">
                      <span>Ajouter aux souhaits</span>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="carte">
            <div class="entreprise-container">
              <div class="carte-entreprise">
                <div class="recto">
                  <div class="identite">
                    <img src="static/img/logo_entreprise/ragt.png" alt="Logo sopra" draggable="false">
                    <span>RAGT</span>
                  </div>
                  <div class="tags">
                    <span><i class="fa-solid fa-location-dot"></i>Paris</span>
                    <span><i class="fa-solid fa-tag"></i>QLIO</span>
                    <span><i class="fa-solid fa-users"></i>100-500</span>
                  </div>
                </div>
                <div class="verso">
                  <div class="description-container">
                    <div class="description-content">
                      Lorem, ipsum dolor sit amet consectetur adipisicing elit. Debitis, enim consequuntur! Ad vero exercitationem quidem, nesciunt deleniti fugit odio magni. Qui officiis consequatur, explicabo autem eaque ducimus beatae earum dignissimos ?
                    </div>
                  </div>
                  <div class="fin-verso">
                    <div class="lien-site">
                      <a href="#" class="hover-underline-active">Sopra.com</a>
                    </div>
                    <div class="btn-informations">
                      <span>Plus d'informations</span>
                    </div>
                    <div class="btn-souhait">
                      <span>Ajouter aux souhaits</span>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="carte">
            <div class="entreprise-container">
              <div class="carte-entreprise">
                <div class="recto">
                  <div class="identite">
                    <img src="static/img/logo_entreprise/linov.webp" alt="Logo sopra" draggable="false">
                    <span>Linov</span>
                  </div>
                  <div class="tags">
                    <span><i class="fa-solid fa-location-dot"></i>Paris</span>
                    <span><i class="fa-solid fa-tag"></i>Informatique</span>
                    <span><i class="fa-solid fa-users"></i>1-10</span>
                  </div>
                </div>
                <div class="verso">
                  <div class="description-container">
                    <div class="description-content">
                      Lorem, ipsum dolor sit amet consectetur adipisicing elit. Debitis, enim consequuntur! Ad vero exercitationem quidem, nesciunt deleniti fugit odio magni. Qui officiis consequatur, explicabo autem eaque ducimus beatae earum dignissimos ?
                    </div>
                  </div>
                  <div class="fin-verso">
                    <div class="lien-site">
                      <a href="#" class="hover-underline-active">Sopra.com</a>
                    </div>
                    <div class="btn-informations">
                      <span>Plus d'informations</span>
                    </div>
                    <div class="btn-souhait">
                      <span>Ajouter aux souhaits</span>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

        </div>  
      </div>
    </div>

    <script src="static/js/header.js"></script>
    <script src="static/js/entreprise.js"></script>
  </body>
</html>