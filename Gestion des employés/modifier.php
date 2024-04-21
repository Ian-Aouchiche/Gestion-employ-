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
<?php

// Connexion à la base de données
include_once "connexion.php";

// On récupère l'ID dans le lien
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Vérifier si l'ID est valide
if ($id <= 0) {
    echo "ID invalide";
    exit;
}

// Requête pour afficher les informations de l'employé
$req = mysqli_prepare($con, "SELECT nom, prenom, age, metier FROM Employe WHERE id = ?");
mysqli_stmt_bind_param($req, "i", $id);
mysqli_stmt_execute($req);
mysqli_stmt_bind_result($req, $nom, $prenom, $age, $metier);
mysqli_stmt_fetch($req);
mysqli_stmt_close($req);

// Vérifier si le formulaire a été soumis
if (isset($_POST['button'])) {
    // Extraction des informations envoyées via POST
    $nom = isset($_POST['nom']) ? htmlspecialchars($_POST['nom']) : '';
    $prenom = isset($_POST['prenom']) ? htmlspecialchars($_POST['prenom']) : '';
    $age = isset($_POST['age']) ? intval($_POST['age']) : 0;
    $metier = isset($_POST['metier']) ? htmlspecialchars($_POST['metier']) : '';

    // Vérifier que tous les champs ont été remplis
    if (!empty($nom) && !empty($prenom) && $age > 0 && !empty($metier)) {
        // Requête de modification
        $req = mysqli_prepare($con, "UPDATE employe SET nom = ?, prenom = ?, age = ?, metier = ? WHERE id = ?");
        mysqli_stmt_bind_param($req, "ssisi", $nom, $prenom, $age, $metier, $id);

        if (mysqli_stmt_execute($req)) {
            // Redirection après la modification
            header("Location: acceuil.php");
            exit;
        } else {
            $message = "Erreur lors de la modification de l'employé.";
        }
    } else {
        $message = "Veuillez remplir tous les champs.";
    }
}
?>

<div class="form">
    <a href="acceuil.php" class="back_btn"><img src="images/back.png"> Retour</a>
    <h2>Modifier l'employé : <?= htmlspecialchars($nom) ?> </h2>
    <p class="erreur_message">
        <?php
        if (isset($message)) {
            echo htmlspecialchars($message);
        }
        ?>
    </p>
    <form action="" method="POST">
        <label>Nom</label>
        <input type="text" name="nom" value="<?= htmlspecialchars($nom) ?>">
        <label>Prénom</label>
        <input type="text" name="prenom" value="<?= htmlspecialchars($prenom) ?>">
        <label>Âge</label>
        <input type="number" name="age" value="<?= $age ?>">
        <label>Métier</label>
        <input type="text" name="metier" value="<?= htmlspecialchars($metier) ?>">

        <input type="submit" value="Modifier" name="button">
    </form>
</div>
</body>
</html>
