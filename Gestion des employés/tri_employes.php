<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Votre titre</title>
    <!-- Ajouter le lien vers votre fichier CSS -->
    <link rel="stylesheet" href="style5.css">

</head>
<body>
    <?php

// inclure la page de connexion
include_once "connexion.php";

// Vérifier si le métier est passé via la méthode GET
if(isset($_GET['metier'])){
    // Récupérer le métier sélectionné dans le formulaire
    $metier = $_GET['metier'];
    
    // Requête SQL pour obtenir la liste filtrée des employés par métier
    $sql = "SELECT * FROM employe WHERE metier = ?";
    
    // Préparer la requête
    $stmt = mysqli_prepare($con, $sql);
    
    // Liaison des paramètres
    mysqli_stmt_bind_param($stmt, "s", $metier);
    
    // Exécution de la requête
    mysqli_stmt_execute($stmt);
    
    // Récupérer les résultats
    $result = mysqli_stmt_get_result($stmt);
    
    // Afficher la liste des employés
    while($row = mysqli_fetch_assoc($result)) {
        // Afficher le nom, le prénom, l'âge et le métier de l'employé
        echo "Nom: " . $row['nom'] . ", Prénom: " . $row['prenom'] . ", Âge: " . $row['age'] . ", Métier: " . $row['metier'] . "<br>";
        // Affichez d'autres détails de l'employé selon votre besoin
    }
    
    // Fermer la déclaration préparée
    mysqli_stmt_close($stmt);
} else {
    // Gérer le cas où le métier n'est pas spécifié
    echo "Le métier n'est pas spécifié.";
}
?>
</body>
</html>