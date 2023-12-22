<?php 
    include('base_de_donnees.php');
    $pdo = connexionBaseDeDonnees();

    /////////////////////////////////////////////////////////////////////////////////////////////
    function verifUtilisateur($login,$pwd) {
        // Vérifie si l'utilisateur existe
        // Les paramétres sont le login et le mot de passe envoyé par le formulaire de connexion
        // Renvoie vrai ou faux en fonction si l'utilisateur a été trouvé.
        // Si vrai, enregistrement dans les variables de session du nom du client, de son ID et d'une variable permettant de savoir que l'on est connecté.

        global $connexion; 
        try{ // Bloc try bd injoignable 
            $connecte=false;
            $maRequete = $connexion->prepare("SELECT IdClient, nom, login,pwd from clients where login = :leLogin and pwd = :lePWD");
            $maRequete->bindParam(':leLogin', $login);
            $maRequete->bindParam(':lePWD', $pwd);
            if ($maRequete->execute()) {
                $maRequete->setFetchMode(PDO::FETCH_OBJ);
                while ($ligne=$maRequete->fetch()) {			
                    $_SESSION['connecte']= true ; 			// Stockage dans les variables de session que l'on est connecté (sera utilisé sur les autres pages)
                    $_SESSION['nomClient']= $ligne->nom ;   // Stockage dans les variables de session du nom du client
                    $_SESSION['IdClient']= $ligne->IdClient ;// Stockage dans les variables de session de l'Id du client
                    $connecte=true;
                }
            }
            return $connecte;
        }
        catch ( Exception $e ) {
            echo "<h1>Erreur de connexion à la base de données ! </h1><br/>";
            return false;
        } 
    }
    /////////////////////////////////////////////////////////////////////////////////////////////

    /////////////////////////////////////////////////////////////////////////////////////////////
    function listeDesIntervenants() {
        // Retourne la liste des intervenants enregistrés sous forme de tableau
        // Fonction qui retourne la liste des intervenants enregistrés sous forme de tableau
        // avec pour chaque ligne une collection indicée sur les noms des colonnes de la BD
        // Parametre $IdClient=Identifiant du client dans la BD pour lequel on veut la liste des comptes
        global $pdo;  // Connexion à la BD

        $tableauIntervenants=array() ; // Tableau qui sera retourné contenant les intervenants enregistrés

        try {	
            // REquete avec agrégats pour calculer le solde
            $maRequete = $pdo->prepare("
            SELECT se_intervenant.nom_intervenant AS nom, 
            IFNULL(se_intervenant.fonction_intervenant, 'Aucune fonction renseignée') AS fonction,
            se_entreprise.nom_entreprise AS entreprise, 
            se_filiere.libelle_filiere AS filiere
            FROM se_intervenant 
            INNER JOIN se_entreprise
            ON se_intervenant.entreprise_intervenant = se_entreprise.id_entreprise
            INNER JOIN se_intervient
            ON se_intervenant.id_intervenant = se_intervient.intervenant_intervient
            INNER JOIN se_filiere
            ON se_intervient.filiere_intervient = se_filiere.id_filiere
            ORDER BY se_intervenant.nom_intervenant;");
            if ($maRequete->execute()) {
                $maRequete->setFetchMode(PDO::FETCH_OBJ);
                while ($ligne=$maRequete->fetch()) {
                    $tableauIntervenant['nom']=$ligne->nom;
                    $tableauIntervenant['fonction']=$ligne->fonction;
                    $tableauIntervenant['entreprise']=$ligne->entreprise;
                    $tableauIntervenant['filiere']=$ligne->filiere;

                    $tableauIntervenants[] = $tableauIntervenant;
                }
                return $tableauIntervenants;
            }
        }
        catch ( Exception $e ) {
            return $tableauIntervenants;
        }
    }	
    /////////////////////////////////////////////////////////////////////////////////////////////	

     /////////////////////////////////////////////////////////////////////////////////////////////
     function ajouterIntervenant($nom_intervenant, $fonction_intervenant, $entreprise_intervenant, $filiere_intervenant) {
        // Fonction renvoyant les informations d'un compte
        // Paramétre $IdCompte=Identifiant du compte dans la BD
        // Retourne les détails du sous forme de collection indicée sur les noms des colonnes de la table compte.

        global $pdo;  // Connexion à la BD

        try{ // Bloc try bd injoignable 

            $maRequete = $pdo->prepare("INSERT INTO 'se_intervenant' (nom_intervenant, fonction_intervenant, entreprise_intervenant)
                                        VALUES (:nomIntervenant, :fonctionIntervenant, :entrepriseIntervenant)");
            $maRequete->bindParam(':nomIntervenant', $nom_intervenant);
            $maRequete->bindParam(':fonctionIntervenant', $fonction_intervenant); 
            $maRequete->bindParam(':entrepriseIntervenant', $entreprise_intervenant);
            
            return true;
        }
        catch ( Exception $e ) {
            return false;
        } 	
    }
    /////////////////////////////////////////////////////////////////////////////////////////////

    /////////////////////////////////////////////////////////////////////////////////////////////
    function detailCompte($IdCompte) {
        // Fonction renvoyant les informations d'un compte
        // Paramétre $IdCompte=Identifiant du compte dans la BD
        // Retourne les détails du sous forme de collection indicée sur les noms des colonnes de la table compte.

        global $connexion;  // Connexion à la BD

        $tableauRetour=array() ; // Tableau qui sera retourné contenant les information du compte		

        try{ // Bloc try bd injoignable 

            $maRequete = $connexion->prepare("SELECT noCompte, libelle, image from comptes where idCompte = :lIDCompte and idClient = :lIDClient");
            $maRequete->bindParam(':lIDCompte', $IdCompte);
            $maRequete->bindParam(':lIDClient', $_SESSION['IdClient']); // Ajout pour eviter du piratage

            if ($maRequete->execute()) {
                $maRequete->setFetchMode(PDO::FETCH_OBJ);
                while ($ligne=$maRequete->fetch()) {	
                    $tableauRetour['noCompte']=$ligne->noCompte;
                    $tableauRetour['libelle']=$ligne->libelle;
                    $tableauRetour['image']=$ligne->image;
                }
            }
            return $tableauRetour;
        }
        catch ( Exception $e ) {
            return $tableauRetour;
        } 	
    }
    /////////////////////////////////////////////////////////////////////////////////////////////

    /////////////////////////////////////////////////////////////////////////////////////////////
    function typesDesEcritures() {
        // Fonction renvoyant le types d'écritures 
        // Retourne les libelles des types sous forme de collection indicée sur le type et en valeur le libellé

        global $connexion;  // Connexion à la BD

        $tableauRetour=array() ; // Tableau qui sera retourné 	

        try{ // Bloc try bd injoignable 
            $maRequete = $connexion->prepare("SELECT type, libelle from type_ecritures order by libelle");

            if ($maRequete->execute()) {
                $maRequete->setFetchMode(PDO::FETCH_OBJ);
                while ($ligne=$maRequete->fetch()) {	
                    $tableauRetour[$ligne->type]=$ligne->libelle;
                }
            }
            return $tableauRetour;
        }
        catch ( Exception $e ) {
            return $tableauRetour;
        } 
    }
    /////////////////////////////////////////////////////////////////////////////////////////////

    /////////////////////////////////////////////////////////////////////////////////////////////
    function listeDesEcrituresdUnCompte($idCompte, $leTypeAAfficher) {
        // Retourne la liste des ecritures d'un compte
        // Fonction qui retourne la liste des ecritures d'un compte sous forme de tableau d'écritures
        // En parametres, l'ID du compte à afficher, et le type d'écritures à afficher (TS si tous)
        // Avec pour chaque ligne une collection indicée sur les noms des colonnes de la BD

        global $connexion;  // Connexion à la BD	

        $tableauRetour=array() ; // Tableau qui sera retourné 	

        try{ // Bloc try bd injoignable 
            $laRequete="SELECT laDate, ecritures.type as typeECR, ecritures.libelle as libelleECR ,montantDebit, montantCredit, type_ecritures.libelle as libType from ecritures left join type_ecritures on ecritures.type = type_ecritures.type where idCompte = :lIDCompte ";

            if ($leTypeAAfficher!='TS') {
                $laRequete.=" and ecritures.type = :leType" ;
            }
            $laRequete.=" order by laDate DESC";
            $maRequete = $connexion->prepare($laRequete);
            $maRequete->bindParam(':lIDCompte', $idCompte);
            if ($leTypeAAfficher!='TS') {
                // Rajout du parametre pour le type
                $maRequete->bindParam(':leType', $leTypeAAfficher);
            }

            if ($maRequete->execute()) {
                $maRequete->setFetchMode(PDO::FETCH_OBJ);
                while ($ligne=$maRequete->fetch()) {
                    $tabEcriture['date']=date("d/m/Y", strtotime($ligne->laDate)) ; 
                    $tabEcriture['type']=$ligne->typeECR ; 
                    $tabEcriture['typeEnClair']=$ligne->libType ;
                    $tabEcriture['libelle']=$ligne->libelleECR ;
                    $tabEcriture['debit']=$ligne->montantDebit;
                    $tabEcriture['credit']=$ligne->montantCredit;

                    $tableauRetour[]=$tabEcriture; // Ajout d'une ligne dans le tableau qui sera retourné
                }
            }
            return $tableauRetour;
        }
        catch ( Exception $e ) {
            return $tableauRetour;
        } 	

    }
    /////////////////////////////////////////////////////////////////////////////////////////////
?>