<?php
include 'config/config.php';
requireLogin();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nom = trim($_POST['nom']);
    $categorie = $_POST['categorie'];
    $date_cours = $_POST['date_cours'];
    $heure = $_POST['heure'];
    $duree_minutes = intval($_POST['duree_minutes']);
    $max_participants = intval($_POST['max_participants']);
    $user_id = $_SESSION['user_id'];
    
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
        $sql = "INSERT INTO cours (nom, categorie, date_cours, heure, duree_minutes, max_participants, user_id) VALUES ('$nom', '$categorie', '$date_cours', '$heure', '$duree_minutes', '$max_participants', '$user_id')";
        
        if ($conn->query($sql)) {
            $_SESSION['success'] = "Cours ajoute avec succes !";
            header("Location: cours.php");
            exit();
        } else {
            $errors[] = "Erreur lors de l'ajout du cours";
        }
    }
}

include 'includes/header.php';
?>

<h1>Ajouter un Cours</h1>

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
            $nom_value = isset($_POST['nom']) ? $_POST['nom'] : '';
            echo '<input type="text" id="nom" name="nom" value="' . $nom_value . '" required>';
            ?>
        </div>
        
        <div class="form-group">
            <label for="categorie">Categorie *</label>
            <select id="categorie" name="categorie" required>
                <option value="">-- Selectionner --</option>
                <?php
                $categories = ['Yoga', 'Musculation', 'Cardio', 'Pilates'];
                foreach($categories as $cat) {
                    $selected = (isset($_POST['categorie']) && $_POST['categorie'] == $cat) ? 'selected' : '';
                    echo '<option value="' . $cat . '" ' . $selected . '>' . $cat . '</option>';
                }
                ?>
            </select>
        </div>
        
        <div class="form-group">
            <label for="date_cours">Date *</label>
            <?php 
            $date_value = isset($_POST['date_cours']) ? $_POST['date_cours'] : '';
            echo '<input type="date" id="date_cours" name="date_cours" value="' . $date_value . '" required>';
            ?>
        </div>
        
        <div class="form-group">
            <label for="heure">Heure *</label>
            <?php 
            $heure_value = isset($_POST['heure']) ? $_POST['heure'] : '';
            echo '<input type="time" id="heure" name="heure" value="' . $heure_value . '" required>';
            ?>
        </div>
        
        <div class="form-group">
            <label for="duree_minutes">Duree (minutes) *</label>
            <?php 
            $duree_value = isset($_POST['duree_minutes']) ? $_POST['duree_minutes'] : '60';
            echo '<input type="number" id="duree_minutes" name="duree_minutes" value="' . $duree_value . '" min="1" required>';
            ?>
        </div>
        
        <div class="form-group">
            <label for="max_participants">Nombre maximum de participants *</label>
            <?php 
            $max_value = isset($_POST['max_participants']) ? $_POST['max_participants'] : '10';
            echo '<input type="number" id="max_participants" name="max_participants" value="' . $max_value . '" min="1" required>';
            ?>
        </div>
        
        <button type="submit" class="btn btn-success">Ajouter</button>
        <a href="cours.php" class="btn btn-primary">Annuler</a>
    </form>
</div>

<?php include 'includes/footer.php'; ?>