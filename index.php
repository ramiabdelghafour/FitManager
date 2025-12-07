<?php
include 'config/config.php';
requireLogin();

$user_id = $_SESSION['user_id'];
$user_nom = $_SESSION['user_nom'];

$sql_cours = "SELECT COUNT(*) as total FROM cours WHERE user_id = '$user_id'";
$result_cours = $conn->query($sql_cours);
$total_cours = $result_cours->fetch_assoc()['total'];

$sql_equipements = "SELECT COUNT(*) as total FROM equipements WHERE user_id = '$user_id'";
$result_equipements = $conn->query($sql_equipements);
$total_equipements = $result_equipements->fetch_assoc()['total'];

$sql_cours_categorie = "SELECT categorie, COUNT(*) as total FROM cours WHERE user_id = '$user_id' GROUP BY categorie";
$result_cours_categorie = $conn->query($sql_cours_categorie);

$sql_equipements_type = "SELECT type, COUNT(*) as total FROM equipements WHERE user_id = '$user_id' GROUP BY type";
$result_equipements_type = $conn->query($sql_equipements_type);

include 'includes/header.php';
?>

<h1>Bienvenue, <?php echo $user_nom; ?> !</h1>

<div class="dashboard-stats">
    <div class="stat-card">
        <h3>Cours</h3>
        <p class="stat-number"><?php echo $total_cours; ?></p>
        <a href="cours.php" class="btn btn-primary">Voir les cours</a>
    </div>
    
    <div class="stat-card">
        <h3>Equipements</h3>
        <p class="stat-number"><?php echo $total_equipements; ?></p>
        <a href="equipements.php" class="btn btn-primary">Voir les equipements</a>
    </div>
</div>

<div class="dashboard-stats">
    <div class="card">
        <h2>Repartition des Cours par Categorie</h2>
        <?php 
        if ($result_cours_categorie->num_rows > 0) {
            echo '<table>';
            echo '<thead>';
            echo '<tr>';
            echo '<th>Categorie</th>';
            echo '<th>Nombre</th>';
            echo '</tr>';
            echo '</thead>';
            echo '<tbody>';
            
            while ($row = $result_cours_categorie->fetch_assoc()) {
                echo '<tr>';
                echo '<td><span class="badge badge-success">' . $row['categorie'] . '</span></td>';
                echo '<td>' . $row['total'] . '</td>';
                echo '</tr>';
            }
            
            echo '</tbody>';
            echo '</table>';
        } else {
            echo '<p>Aucune donnee disponible.</p>';
        }
        ?>
    </div>
    
    <div class="card">
        <h2>Repartition des Equipements par Type</h2>
        <?php 
        if ($result_equipements_type->num_rows > 0) {
            echo '<table>';
            echo '<thead>';
            echo '<tr>';
            echo '<th>Type</th>';
            echo '<th>Nombre</th>';
            echo '</tr>';
            echo '</thead>';
            echo '<tbody>';
            
            while ($row = $result_equipements_type->fetch_assoc()) {
                echo '<tr>';
                echo '<td><span class="badge badge-warning">' . $row['type'] . '</span></td>';
                echo '<td>' . $row['total'] . '</td>';
                echo '</tr>';
            }
            
            echo '</tbody>';
            echo '</table>';
        } else {
            echo '<p>Aucune donnee disponible.</p>';
        }
        ?>
    </div>
</div>

<?php include 'includes/footer.php'; ?>