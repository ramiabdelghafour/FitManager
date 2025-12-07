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

$sql = "SELECT * FROM equipements WHERE id = '$equipement_id' AND user_id = '$user_id'";
$result = $conn->query($sql);

if ($result->num_rows == 0) {
    $_SESSION['error'] = "Equipement non trouve";
    header("Location: equipements.php");
    exit();
}

$equipement = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nom = trim($_POST['nom']);
    $type = $_POST['type'];
    $quantite = intval($_POST['quantite']);
    $etat = $_POST['etat'];
    
    $errors = [];
    
    if (empty($nom)) {
        $errors[] = "Le nom de l'equipement est obligatoire";
    }
    
    if ($quantite <= 0) {
        $errors[] = "La quantite doit etre superieure a 0";
    }
    
    if (empty($errors)) {
        $sql = "UPDATE equipements SET nom = '$nom', type = '$type', quantite = '$quantite', etat = '$etat' WHERE id = '$equipement_id' AND user_id = '$user_id'";
        
        if ($conn->query($sql)) {
            $_SESSION['success'] = "Equipement modifie avec succes !";
            header("Location: equipements.php");
            exit();
        } else {
            $errors[] = "Erreur lors de la modification de l'equipement";
        }
    }
} else {
    $_POST = $equipement;
}

include 'includes/header.php';
?>

<h1>Modifier un Equipement</h1>

<div class="card">
    <?php 
    if (isset($errors) && !empty($errors)) {
        echo '<div class="alert alert-error">';
        foreach($errors as $error) {
            echo '<p>' . $error . '</p>';
        }
        echo '</div>';
    }
    ?>
    
    <form method="POST" action="">
        <div class="form-group">
            <label for="nom">Nom de l'equipement *</label>
            <?php 
            echo '<input type="text" id="nom" name="nom" value="' . $_POST['nom'] . '" required>';
            ?>
        </div>
        
        <div class="form-group">
            <label for="type">Type *</label>
            <select id="type" name="type" required>
                <option value="">-- Selectionner --</option>
                <?php
                $types = ['Tapis de course', 'Halteres', 'Ballons', 'Velo', 'Banc'];
                foreach($types as $t) {
                    $selected = ($_POST['type'] == $t) ? 'selected' : '';
                    echo '<option value="' . $t . '" ' . $selected . '>' . $t . '</option>';
                }
                ?>
            </select>
        </div>
        
        <div class="form-group">
            <label for="quantite">Quantite disponible *</label>
            <?php 
            echo '<input type="number" id="quantite" name="quantite" value="' . $_POST['quantite'] . '" min="1" required>';
            ?>
        </div>
        
        <div class="form-group">
            <label for="etat">Etat *</label>
            <select id="etat" name="etat" required>
                <?php
                $etats = ['Bon', 'Moyen', 'A remplacer'];
                foreach($etats as $e) {
                    $selected = ($_POST['etat'] == $e) ? 'selected' : '';
                    echo '<option value="' . $e . '" ' . $selected . '>' . $e . '</option>';
                }
                ?>
            </select>
        </div>
        
        <button type="submit" class="btn btn-success">Modifier</button>
        <a href="equipements.php" class="btn btn-primary">Annuler</a>
    </form>
</div>

<?php include 'includes/footer.php'; ?>