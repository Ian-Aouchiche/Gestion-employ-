<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription</title>
    <link rel="stylesheet" href="stylesignup.css">
</head>
<body>

<div class="container">
    <div class="signup-container">
        <h2>Inscription Compte Admin</h2>
        <?php
            session_start();
            if(isset($_SESSION['error'])) {
                echo '<div class="error-message">' . htmlspecialchars($_SESSION['error']) . '</div>';
                unset($_SESSION['error']); // Efface le message d'erreur pour qu'il ne s'affiche plus après le rafraîchissement
            }
        ?>
        <form action="process_signup.php" method="post" class="two-column-form">
            <div class="input-group">
                <label for="username">Nom d'utilisateur</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="input-group">
                <label for="password">Mot de passe</label>
                <input type="password" id="password" name="password" required>
            </div>
            <div class="input-group">
                <label for="prenom">Prénom</label>
                <input type="text" id="prenom" name="prenom" required>
            </div>
            <div class="input-group">
                <label for="nom">Nom</label>
                <input type="text" id="nom" name="nom" required>
            </div>
            <div class="input-group">
                <label for="date_naissance">Date de naissance</label>
                <input type="date" id="date_naissance" name="date_naissance" required>
            </div>
            <div class="input-group">
                <label for="mail">Email</label>
                <input type="email" id="mail" name="mail" required>
            </div>
            <div class="input-group">
                <label for="telephone">Téléphone</label>
                <input type="text" id="telephone" name="telephone" required>
            </div>
            <div class="input-group">
                <label for="adresse">Adresse</label>
                <input type="text" id="adresse" name="adresse" required>
            </div>
            <div class="input-group">
                <label for="numero_admin">Numéro Admin</label>
                <input type="text" id="numero_admin" name="numero_admin" required>
            </div>
            <button type="submit" class="btn-signup">S'inscrire</button>
        </form>
    </div>
</div>
</body>
</html>
