<?php
session_start();
$_SESSION['estConnecte'] = False;
$_SESSION['idUtilisateur'] = null;
session_destroy();