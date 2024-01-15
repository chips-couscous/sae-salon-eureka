<?php
    require('../static/module_php/panel/g_intervenants.php');
    require ('../static/module_php/base_de_donnees.php');
    
    $pdo = connexionBaseDeDonnees();
    
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['entreprise'])) {
        $selectedEntreprise = $_POST['entreprise'];
        $nombreIntervenants = getNombreIntervenants($pdo, $selectedEntreprise);
        echo $nombreIntervenants;
    }
?>