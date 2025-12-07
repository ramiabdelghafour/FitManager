<?php
include 'config/config.php';
requireLogin();

$user_id = $_SESSION['user_id'];
$sql = "SELECT * FROM equipements WHERE user_id = '$user_id' ORDER BY nom ASC";
$result = $conn->query($sql);

include 'includes/header.php';
?>

<h1>Gestion des Equipements</h1>

<div class="card">
    <a href="equipements_add.php" class="btn btn-success">+ Ajouter un equipement</a>
</div>

<div class="card">
    <h2>Liste des Equipements</h2>
    <table>
        <thead>
            <tr>
                <th>Nom</th>
                <th>Type</th>
                <th>Quantite</th>
                <th>Etat</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo '<tr>';
                    echo '<td>' . $row['nom'] . '</td>';
                    echo '<td><span class="badge badge-success">' . $row['type'] . '</span></td>';
                    echo '<td>' . $row['quantite'] . '</td>';
                    
                    echo '<td>';
                    $badge_class = 'badge-success';
                    if ($row['etat'] == 'Moyen') {
                        $badge_class = 'badge-warning';
                    }
                    if ($row['etat'] == 'A remplacer') {
                        $badge_class = 'badge-danger';
                    }
                    echo '<span class="badge ' . $badge_class . '">' . $row['etat'] . '</span>';
                    echo '</td>';
                    
                    echo '<td>';
                    echo '<a href="equipements_edit.php?id=' . $row['id'] . '" class="btn btn-warning">Modifier</a> ';
                    echo '<a href="equipements_delete.php?id=' . $row['id'] . '" class="btn btn-danger" onclick="return confirm(\'Etes-vous sur de vouloir supprimer cet equipement ?\')">Supprimer</a>';
                    echo '</td>';
                    echo '</tr>';
                }
            } else {
                echo '<tr>';
                echo '<td colspan="5" style="text-align: center;">Aucun equipement disponible</td>';
                echo '</tr>';
            }
            ?>
        </tbody>
    </table>
</div>

<?php include 'includes/footer.php'; ?>