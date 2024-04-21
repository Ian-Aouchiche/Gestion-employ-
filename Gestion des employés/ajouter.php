<?php
// Vérifier si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Vérifier si les champs requis sont définis et non vides
    if (isset($_POST["nom"]) && isset($_POST["prenom"]) && isset($_POST["age"]) && isset($_POST["metier"]) &&
        !empty($_POST["nom"]) && !empty($_POST["prenom"]) && !empty($_POST["age"]) && !empty($_POST["metier"])) {
        
        // Inclure le fichier de connexion à la base de données
        include_once "connexion.php";

        // Nettoyer et récupérer les données du formulaire
        $nom = mysqli_real_escape_string($con, $_POST["nom"]);
        $prenom = mysqli_real_escape_string($con, $_POST["prenom"]);
        $age = mysqli_real_escape_string($con, $_POST["age"]);
        $metier = mysqli_real_escape_string($con, $_POST["metier"]);

        // Préparer la requête SQL avec une requête préparée
        $query = "INSERT INTO employe (nom, prenom, age, metier) VALUES (?, ?, ?, ?)";
        $stmt = mysqli_prepare($con, $query);

        // Vérifier si la préparation de la requête a réussi
        if ($stmt) {
            // Liaison des paramètres et exécution de la requête
            mysqli_stmt_bind_param($stmt, "ssis", $nom, $prenom, $age, $metier);
            if (mysqli_stmt_execute($stmt)) {
                // Redirection vers la page d'accueil si l'ajout est réussi
                header("location: acceuil.php");
                exit();
            } else {
                $message = "Erreur lors de l'ajout de l'employé.";
            }
            // Fermer la requête préparée
            mysqli_stmt_close($stmt);
        } else {
            $message = "Erreur de préparation de la requête SQL.";
        }
    } else {
        $message = "Veuillez remplir tous les champs du formulaire.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="form">
        <a href="acceuil.php" class="back_btn"><img src="images/back.png"> Retour</a>
        <h2>Ajouter un employé</h2>
        <p class="erreur_message">
            <?php 
            // si la variable message existe , affichons son contenu
            if(isset($message)){
                
                echo $message;
            }
            ?>
        </p>
        <form action="" method="POST">
            <label>Nom</label>
            <input type="text" name="nom">
            <label>Prénom</label>
            <input type="text" name="prenom">
            <label>Âge</label>
            <input type="number" name="age">
            <label>Métier</label>
            <input type="text" name="metier">
            <input type="submit" value="Ajouter" name="button">
        </form>
    </div>
</body>
</html>
