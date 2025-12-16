<?php
include 'config/config.php';
requireLogin();

$cours_id = intval($_GET['id']);
$user_id = $_SESSION['user_id'];

$sql = "DELETE FROM cours WHERE id = '$cours_id' AND user_id = '$user_id'";

header("Location: cours.php");
exit();
?>