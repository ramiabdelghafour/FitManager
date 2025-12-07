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

$sql = "SELECT * FROM cours WHERE id = '$cours_id' AND user_id = '$user_id'";
$result = $conn->query($sql);

if ($result->num_rows == 0) {
    $_SESSION['error'] = "Cours non trouve";
    header("Location: cours.php");
    exit();
}

$cours = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nom = trim($_POST['nom']);
    $categorie = $_POST['categorie'];
    $date_cours = $_POST['date_cours'];
    $heure = $_POST['heure'];
    $duree_minutes = intval($_POST['duree_minutes']);
    $max_participants = intval($_POST['max_participants']);
    
    $errors = [];
    
    if (empty($nom)) {
        $errors[] = "Le nom du cours est obligatoire";
    }
    
    if (empty($date_cours)) {
        $errors[] = "La date est obligatoire";
    }
    
    if (empty($heure)) {
        $errors[] = "L'heure est obligatoire";
    }
    
    if ($duree_minutes <= 0) {
        $errors[] = "La duree doit etre superieure a 0";
    }
    
    if ($max_participants <= 0) {
        $errors[] = "Le nombre maximum de participants doit etre superieur a 0";
    }
    
    if (empty($errors)) {
        $sql = "UPDATE cours SET nom = '$nom', categorie = '$categorie', date_cours = '$date_cours', heure = '$heure', duree_minutes = '$duree_minutes', max_participants = '$max_participants' WHERE id = '$cours_id' AND user_id = '$user_id'";
        
        if ($conn->query($sql)) {
            $_SESSION['success'] = "Cours modifie avec succes !";
            header("Location: cours.php");
            exit();
        } else {
            $errors[] = "Erreur lors de la modification du cours";
        }
    }
} else {
    $_POST = $cours;
}

include 'includes/header.php';
?>

<h1>Modifier un Cours</h1>

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
            <label for="nom">Nom du cours *</label>
            <?php 
            echo '<input type="text" id="nom" name="nom" value="' . $_POST['nom'] . '" required>';
            ?>
        </div>
        
        <div class="form-group">
            <label for="categorie">Categorie *</label>
            <select id="categorie" name="categorie" required>
                <option value="">-- Selectionner --</option>
                <?php
                $categories = ['Yoga', 'Musculation', 'Cardio', 'Pilates'];
                foreach($categories as $cat) {
                    $selected = ($_POST['categorie'] == $cat) ? 'selected' : '';
                    echo '<option value="' . $cat . '" ' . $selected . '>' . $cat . '</option>';
                }
                ?>
            </select>
        </div>
        
        <div class="form-group">
            <label for="date_cours">Date *</label>
            <?php 
            echo '<input type="date" id="date_cours" name="date_cours" value="' . $_POST['date_cours'] . '" required>';
            ?>
        </div>
        
        <div class="form-group">
            <label for="heure">Heure *</label>
            <?php 
            echo '<input type="time" id="heure" name="heure" value="' . $_POST['heure'] . '" required>';
            ?>
        </div>
        
        <div class="form-group">
            <label for="duree_minutes">Duree (minutes) *</label>
            <?php 
            echo '<input type="number" id="duree_minutes" name="duree_minutes" value="' . $_POST['duree_minutes'] . '" min="1" required>';
            ?>
        </div>
        
        <div class="form-group">
            <label for="max_participants">Nombre maximum de participants *</label>
            <?php 
            echo '<input type="number" id="max_participants" name="max_participants" value="' . $_POST['max_participants'] . '" min="1" required>';
            ?>
        </div>
        
        <button type="submit" class="btn btn-success">Modifier</button>
        <a href="cours.php" class="btn btn-primary">Annuler</a>
    </form>
</div>

<?php include 'includes/footer.php'; ?>