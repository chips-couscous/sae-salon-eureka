<?php
include('../static/module_php/panel/g_utilisateurs.php');

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['entreprise'])) {
    $selectedEntreprise = $_POST['entreprise'];
    $nombreIntervenants = getNombreIntervenants($selectedEntreprise);
    echo $nombreIntervenants;
}
?>