<?php
include 'config/config.php';
requireLogin();

$equipement_id = intval($_GET['id']);
$user_id = $_SESSION['user_id'];

$sql = "DELETE FROM equipements WHERE id = '$equipement_id' AND user_id = '$user_id'";

header("Location: equipements.php");
exit();
?>
