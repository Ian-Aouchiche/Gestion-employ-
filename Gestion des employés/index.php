<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
    <link rel="stylesheet" href="style2.css">
</head>
<body>

<div class="login-container">
    <h2>Connexion</h2>
    
    <form action="process_login.php" method="post">
        <div class="input-group">
            <label for="username">Nom d'utilisateur</label>
            <input type="text" id="username" name="username" required>
        </div>
        <div class="input-group">
            <label for="password">Mot de passe</label>
            <input type="password" id="password" name="password" required>
        </div>
        <button type="submit" class="btn-login">Se connecter</button>
    </form>
    <br>

    <!-- Bouton pour créer un compte admin -->
    <a href="signup.php" class="btn-login">Créer un compte admin</a>
    <br>

</div>

</body>
</html>
