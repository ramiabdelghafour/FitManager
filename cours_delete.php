<?php
include 'config/config.php';
requireLogin();

if (!isset($_GET['id']) || empty($_GET['id'])) {
    $_SESSION['error'] = "ID du cours invalide";
    header("Location: cours.php");
    exit();
}

$cours_id = intval($_GET['id']);
$user_id = $_SESSION['user_id'];

$sql = "DELETE FROM cours WHERE id = '$cours_id' AND user_id = '$user_id'";

if ($conn->query($sql)) {
    $_SESSION['success'] = "Cours supprime avec succes !";
} else {
    $_SESSION['error'] = "Erreur lors de la suppression du cours";
}

header("Location: cours.php");
exit();
?>