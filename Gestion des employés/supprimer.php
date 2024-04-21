<?php
// Connexion à la base de données
include_once "connexion.php";

// Vérifier si l'ID est défini dans l'URL
if(isset($_GET['id']) && !empty($_GET['id'])) {
    // Récupération de l'ID depuis l'URL
    $id = $_GET['id'];

    // Préparation de la requête de suppression en utilisant une requête préparée pour éviter les injections SQL
    $stmt = mysqli_prepare($con, "DELETE FROM employe WHERE id = ?");

    // Liaison des paramètres
    mysqli_stmt_bind_param($stmt, "i", $id);

    // Exécution de la requête
    if(mysqli_stmt_execute($stmt)) {
        // Redirection vers la page d'accueil après la suppression
        header("Location: acceuil.php");
        exit();
    } else {
        // En cas d'erreur lors de l'exécution de la requête de suppression
        echo "Erreur lors de la suppression de l'employé.";
    }
} else {
    // Si l'ID n'est pas défini dans l'URL ou est vide, afficher un message d'erreur
    echo "ID de l'employé non spécifié.";
}
?>
