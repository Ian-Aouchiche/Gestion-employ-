<?php
// inclure la page de connexion
include_once "connexion.php";

// vérifier si l'ID de l'employé est passé via la méthode GET
if(isset($_GET['id'])){
    // récupération des IDs dans le lien
    $ids = explode(",", $_GET['id']);
    
    // Préparer la requête pour supprimer chaque employé
    $stmt = mysqli_prepare($con, "DELETE FROM employe WHERE id = ?");
    mysqli_stmt_bind_param($stmt, "i", $id); // "i" indique que c'est un entier
    
    // Supprimer chaque employé
    foreach ($ids as $id) {
        $id = intval($id); // Assurez-vous que l'ID est un entier
        mysqli_stmt_execute($stmt);
    }
    
    // Fermer la déclaration préparée
    mysqli_stmt_close($stmt);

    // redirection vers la page index.php
    header("Location: selectionner.php");
    exit(); // assure que le script s'arrête après la redirection
} else {
    // Gérer le cas où l'ID n'est pas passé correctement
    echo "L'ID de l'employé n'est pas spécifié.";
}
?>
