<?php
include 'config/config.php';
requireLogin();

if (!isset($_GET['id']) || empty($_GET['id'])) {
    $_SESSION['error'] = "ID de l'equipement invalide";
    header("Location: equipements.php");
    exit();
}

$equipement_id = intval($_GET['id']);
$user_id = $_SESSION['user_id'];

$sql = "DELETE FROM equipements WHERE id = '$equipement_id' AND user_id = '$user_id'";

if ($conn->query($sql)) {
    $_SESSION['success'] = "Equipement supprime avec succes !";
} else {
    $_SESSION['error'] = "Erreur lors de la suppression de l'equipement";
}

header("Location: equipements.php");
exit();
?>