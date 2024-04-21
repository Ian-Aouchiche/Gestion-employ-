<?php
session_start();
include_once "connexion.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Vérifier si les champs sont définis et non vides
    if (isset($_POST["username"]) && isset($_POST["password"]) && !empty($_POST["username"]) && !empty($_POST["password"])) {
        $username = mysqli_real_escape_string($con, $_POST['username']);

        // Préparer et exécuter la requête SQL en utilisant une requête préparée pour éviter les attaques par injection SQL
        $query = "SELECT * FROM admins WHERE username = ?";
        $stmt = mysqli_prepare($con, $query);

        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "s", $username);
            if (mysqli_stmt_execute($stmt)) {
                $result = mysqli_stmt_get_result($stmt);

                // Vérifiez si l'utilisateur existe dans la base de données
                if (mysqli_num_rows($result) == 1) {
                    $row = mysqli_fetch_assoc($result);
                    $password_attempt = $_POST['password'];

                    // Vérifiez si le mot de passe est correct en utilisant password_verify
                    if (password_verify($password_attempt, $row['password'])) {
                        // Authentification réussie, créez une session
                        $_SESSION['loggedin'] = true;
                        $_SESSION['username'] = $username;

                        // Redirigez l'utilisateur vers la page principale
                        header("Location: acceuil.php");
                        exit();
                    } else {
                        // Informez l'utilisateur que le mot de passe est incorrect
                        $_SESSION['error'] = "Mot de passe incorrect.";
                        header("Location: index.php");
                        exit();
                    }
                } else {
                    // Informez l'utilisateur que le nom d'utilisateur est incorrect
                    $_SESSION['error'] = "Nom d'utilisateur incorrect.";
                    header("Location: index.php");
                    exit();
                }
            } else {
                // Gérer les erreurs d'exécution de la requête
                $_SESSION['error'] = "Erreur lors de l'exécution de la requête SQL: " . mysqli_error($con);
                header("Location: index.php");
                exit();
            }
        } else {
            // Gérer les erreurs de préparation de la requête
            $_SESSION['error'] = "Erreur de préparation de la requête SQL: " . mysqli_error($con);
            header("Location: index.php");
            exit();
        }
    } else {
        // Informez l'utilisateur que les champs sont requis
        $_SESSION['error'] = "Veuillez fournir un nom d'utilisateur et un mot de passe.";
        header("Location: index.php");
        exit();
    }
}

// Si le code atteint ce point, il y a eu une erreur de traitement
$_SESSION['error'] = "Une erreur s'est produite lors de la connexion.";
header("Location: index.php");
exit();
?>
