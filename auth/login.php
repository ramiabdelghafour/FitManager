<?php
include '../config/config.php';

if (isLoggedIn()) {
    header("Location: ../index.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    
    $errors = [];
    
    if (empty($email)) {
        $errors[] = "L'email est obligatoire";
    }
    
    if (empty($password)) {
        $errors[] = "Le mot de passe est obligatoire";
    }
    
    if (empty($errors)) {
        $sql = "SELECT * FROM utilisateurs WHERE email = '$email' AND password = '$password'";
        $result = $conn->query($sql);
        
        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_nom'] = $user['nom'];
            $_SESSION['user_email'] = $user['email'];
            
            header("Location: ../index.php");
            exit();
        } else {
            $errors[] = "Email ou mot de passe incorrect";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - FitManager</title>
    <link rel="stylesheet" href="../assets/style.css">
</head>
<body>

<div class="auth-container">
    <div class="auth-card">
        <h2>Connexion</h2>
        
        <?php 
        if (isset($_SESSION['success'])) {
            echo '<div class="alert alert-success">';
            echo '<p>' . $_SESSION['success'] . '</p>';
            echo '</div>';
            unset($_SESSION['success']);
        }
        
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
            
            <button type="submit" class="btn btn-primary">Se connecter</button>
        </form>
        
        <div class="auth-link">
            <p>Vous n'avez pas de compte ? <a href="register.php">S'inscrire</a></p>
        </div>
    </div>
</div>

</body>
</html>