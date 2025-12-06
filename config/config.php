<?php
session_start();

$servername = 'localhost';
$user = 'root';
$pass = '';
$dbname = 'fitmanager';

try {
    $conn = new mysqli($servername, $user, $pass, $dbname);
    
    if($conn->connect_error){
        die("Erreur de connexion : " . $conn->connect_error);
    }
    
    $conn->set_charset("utf8mb4");
    
} catch (Exception $e) {
    die("Erreur : " . $e->getMessage());
}

?>