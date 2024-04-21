<?php
session_start();
include_once "connexion.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Vérifier si les champs sont définis et non vides
    if (isset($_POST["username"], $_POST["password"], $_POST["prenom"], $_POST["nom"], $_POST["date_naissance"], $_POST["mail"], $_POST["telephone"], $_POST["adresse"], $_POST["numero_admin"]) && !empty($_POST["username"]) && !empty($_POST["password"]) && !empty($_POST["prenom"]) && !empty($_POST["nom"]) && !empty($_POST["date_naissance"]) && !empty($_POST["mail"]) && !empty($_POST["telephone"]) && !empty($_POST["adresse"]) && !empty($_POST["numero_admin"])) {

        // Utilisation de mysqli_real_escape_string pour échapper les données
        $username = mysqli_real_escape_string($con, $_POST["username"]);
        $password = mysqli_real_escape_string($con, $_POST["password"]);
        $prenom = mysqli_real_escape_string($con, $_POST["prenom"]);
        $nom = mysqli_real_escape_string($con, $_POST["nom"]);
        $date_naissance = mysqli_real_escape_string($con, $_POST["date_naissance"]);
        $mail = mysqli_real_escape_string($con, $_POST["mail"]);
        $telephone = mysqli_real_escape_string($con, $_POST["telephone"]);
        $adresse = mysqli_real_escape_string($con, $_POST["adresse"]);
        $numero_admin = mysqli_real_escape_string($con, $_POST["numero_admin"]);

        // Utilisation de requêtes préparées pour éviter les injections SQL
        $check_username_query = "SELECT * FROM admins WHERE username = ?";
        $stmt = mysqli_prepare($con, $check_username_query);
        mysqli_stmt_bind_param($stmt, "s", $username);
        mysqli_stmt_execute($stmt);
        $check_username_result = mysqli_stmt_get_result($stmt);

        if (mysqli_num_rows($check_username_result) > 0) {
            $_SESSION['error'] = "Cet identifiant admin est déjà utilisé.";
            header("Location: signup.php");
            exit();
        }

        // Vérifier si le numéro d'administrateur existe dans la base de données
        $check_admin_query = "SELECT * FROM admins WHERE numero_admin = ?";
        $stmt = mysqli_prepare($con, $check_admin_query);
        mysqli_stmt_bind_param($stmt, "s", $numero_admin);
        mysqli_stmt_execute($stmt);
        $check_admin_result = mysqli_stmt_get_result($stmt);

        if (mysqli_num_rows($check_admin_result) == 0) {
            $_SESSION['error'] = "Le numéro d'administrateur n'existe pas.";
            header("Location: signup.php");
            exit();
        }

        // Hacher le mot de passe avant de l'insérer dans la base de données
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Utilisation de requêtes préparées pour l'insertion des données
        $insert_query = "INSERT INTO admins (username, password, prenom, nom, date_naissance, mail, telephone, adresse, numero_admin) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($con, $insert_query);

        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "sssssssss", $username, $hashed_password, $prenom, $nom, $date_naissance, $mail, $telephone, $adresse, $numero_admin);
            if (mysqli_stmt_execute($stmt)) {
                $_SESSION['success'] = "Nouvel administrateur ajouté avec succès.";
                header("Location: index.php");
                exit();
            } else {
                $_SESSION['error'] = "Une erreur s'est produite lors de l'inscription.";
                header("Location: signup.php");
                exit();
            }
        } else {
            $_SESSION['error'] = "Erreur de préparation de la requête SQL.";
            header("Location: signup.php");
            exit();
        }
    } else {
        $_SESSION['error'] = "Veuillez remplir tous les champs du formulaire.";
        header("Location: signup.php");
        exit();
    }
} else {
    header("Location: signup.php");
    exit();
}
?>
