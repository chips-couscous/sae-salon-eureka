<?php
function connexionBaseDeDonnees() {
    $host = "localhost";
    $name = "salon_eureka_cps";
    $user = "root";
    $pass = "root";
    $charset = "utf8mb4";

    $dsn = "mysql:host=$host;dbname=$name;charset=$charset";

    $options = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false
    ];

    try {
        $pdo = new PDO($dsn, $user, $pass, $options);
        return $pdo;
    } catch (PDOException $e) {
        return null;
    }
}

