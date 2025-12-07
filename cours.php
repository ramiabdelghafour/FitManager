<?php
include 'config/config.php';
requireLogin();

$user_id = $_SESSION['user_id'];
$sql = "SELECT * FROM cours WHERE user_id = '$user_id' ORDER BY date_cours DESC, heure DESC";
$result = $conn->query($sql);

include 'includes/header.php';
?>

<h1>Gestion des Cours</h1>

<div class="card">
    <a href="cours_add.php" class="btn btn-success">+ Ajouter un cours</a>
</div>

<div class="card">
    <h2>Liste des Cours</h2>
    <table>
        <thead>
            <tr>
                <th>Nom</th>
                <th>Categorie</th>
                <th>Date</th>
                <th>Heure</th>
                <th>Duree (min)</th>
                <th>Max participants</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo '<tr>';
                    echo '<td>' . $row['nom'] . '</td>';
                    echo '<td><span class="badge badge-success">' . $row['categorie'] . '</span></td>';
                    echo '<td>' . date('d/m/Y', strtotime($row['date_cours'])) . '</td>';
                    echo '<td>' . date('H:i', strtotime($row['heure'])) . '</td>';
                    echo '<td>' . $row['duree_minutes'] . '</td>';
                    echo '<td>' . $row['max_participants'] . '</td>';
                    echo '<td>';
                    echo '<a href="cours_edit.php?id=' . $row['id'] . '" class="btn btn-warning">Modifier</a> ';
                    echo '<a href="cours_delete.php?id=' . $row['id'] . '" class="btn btn-danger" onclick="return confirm(\'Etes-vous sur de vouloir supprimer ce cours ?\')">Supprimer</a>';
                    echo '</td>';
                    echo '</tr>';
                }
            } else {
                echo '<tr>';
                echo '<td colspan="7" style="text-align: center;">Aucun cours disponible</td>';
                echo '</tr>';
            }
            ?>
        </tbody>
    </table>
</div>

<?php include 'includes/footer.php'; ?>