<?php
include '../config/config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nom = trim($_POST['nom']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    
    $errors = [];
    
    if (empty($nom)) {
        $errors[] = "Le nom est obligatoire";
    }
    
    if (empty($email)) {
        $errors[] = "L'email est obligatoire";
    }
    
    if (empty($password)) {
        $errors[] = "Le mot de passe est obligatoire";
    }
    
    if ($password !== $confirm_password) {
        $errors[] = "Les mots de passe ne correspondent pas";
    }
    
    if (empty($errors)) {
        $sql = "SELECT id FROM utilisateurs WHERE email = '$email'";
        $result = $conn->query($sql);
        
        if ($result->num_rows > 0) {
            $errors[] = "Cet email est deja utilise";
        }
    }
    
    if (empty($errors)) {
        $sql = "INSERT INTO utilisateurs (nom, email, password) VALUES ('$nom', '$email', '$password')";
        
        if ($conn->query($sql)) {
            $_SESSION['success'] = "Inscription reussie ! Vous pouvez maintenant vous connecter.";
            header("Location: login.php");
            exit();
        } else {
            $errors[] = "Erreur lors de l'inscription";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription - FitManager</title>
    <link rel="stylesheet" href="../assets/style.css">
</head>
<body>

<div class="auth-container">
    <div class="auth-card">
        <h2>Inscription</h2>
        
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
                <label for="nom">Nom complet</label>
                <?php 
                $nom_value = isset($_POST['nom']) ? $_POST['nom'] : '';
                echo '<input type="text" id="nom" name="nom" value="' . $nom_value . '" required>';
                ?>
            </div>
            
            <div class="form-group">
                <label for="email">Email</label>
                <?php 
                $email_value = isset($_POST['email']) ? $_POST['email'] : '';
                echo '<input type="email" id="email" name="email" value="' . $email_value . '" required>';
                ?>
            </div>
            
            <div class="form-group">
                <label for="password">Mot de passe</label>
                <input type="password" id="password" name="password" required>
            </div>
            
            <div class="form-group">
                <label for="confirm_password">Confirmer le mot de passe</label>
                <input type="password" id="confirm_password" name="confirm_password" required>
            </div>
            
            <button type="submit" class="btn btn-primary">S'inscrire</button>
        </form>
        
        <div class="auth-link">
            <p>Vous avez deja un compte ? <a href="login.php">Se connecter</a></p>
        </div>
    </div>
</div>

</body>
</html>