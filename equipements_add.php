<?php
include 'config/config.php';
requireLogin();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nom = trim($_POST['nom']);
    $type = $_POST['type'];
    $quantite = intval($_POST['quantite']);
    $etat = $_POST['etat'];
    $user_id = $_SESSION['user_id'];
    
    $errors = [];
    
    if (empty($nom)) {
        $errors[] = "Le nom de l'equipement est obligatoire";
    }
    
    if ($quantite <= 0) {
        $errors[] = "La quantite doit etre superieure a 0";
    }
    
    if (empty($errors)) {
        $sql = "INSERT INTO equipements (nom, type, quantite, etat, user_id) VALUES ('$nom', '$type', '$quantite', '$etat', '$user_id')";
        
        if ($conn->query($sql)) {
            $_SESSION['success'] = "Equipement ajoute avec succes !";
            header("Location: equipements.php");
            exit();
        } else {
            $errors[] = "Erreur lors de l'ajout de l'equipement";
        }
    }
}

include 'includes/header.php';
?>

<h1>Ajouter un Equipement</h1>

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
            $nom_value = isset($_POST['nom']) ? $_POST['nom'] : '';
            echo '<input type="text" id="nom" name="nom" value="' . $nom_value . '" required>';
            ?>
        </div>
        
        <div class="form-group">
            <label for="type">Type *</label>
            <select id="type" name="type" required>
                <option value="">-- Selectionner --</option>
                <?php
                $types = ['Tapis de course', 'Halteres', 'Ballons', 'Velo', 'Banc'];
                foreach($types as $t) {
                    $selected = (isset($_POST['type']) && $_POST['type'] == $t) ? 'selected' : '';
                    echo '<option value="' . $t . '" ' . $selected . '>' . $t . '</option>';
                }
                ?>
            </select>
        </div>
        
        <div class="form-group">
            <label for="quantite">Quantite disponible *</label>
            <?php 
            $quantite_value = isset($_POST['quantite']) ? $_POST['quantite'] : '1';
            echo '<input type="number" id="quantite" name="quantite" value="' . $quantite_value . '" min="1" required>';
            ?>
        </div>
        
        <div class="form-group">
            <label for="etat">Etat *</label>
            <select id="etat" name="etat" required>
                <?php
                $etats = ['Bon', 'Moyen', 'A remplacer'];
                foreach($etats as $e) {
                    $selected = (isset($_POST['etat']) && $_POST['etat'] == $e) ? 'selected' : ($e == 'Bon' ? 'selected' : '');
                    echo '<option value="' . $e . '" ' . $selected . '>' . $e . '</option>';
                }
                ?>
            </select>
        </div>
        
        <button type="submit" class="btn btn-success">Ajouter</button>
        <a href="equipements.php" class="btn btn-primary">Annuler</a>
    </form>
</div>

<?php include 'includes/footer.php'; ?>