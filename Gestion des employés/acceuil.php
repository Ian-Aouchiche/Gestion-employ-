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
        echo "Nom: " . htmlspecialchars($row['nom']) . ", Métier: " . htmlspecialchars($row['metier']) . "<br>";
        // Affichez d'autres détails de l'employé selon votre besoin
    }
    
    // Fermer la déclaration préparée
    mysqli_stmt_close($stmt);
} 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion Employés</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <h1>Gestion des Employés</h1>
    <div class="button-container">
        <a href="ajouter.php" class="Btn_add"> <img src="images/plus.png"> Ajouter</a>
        <a href="selectionner.php" class="Btn_select"><img src="images/plus.png"> Sélectionner</a>
        <!-- Ajout du bouton de déconnexion -->
        <a href="logout.php" class="Btn_logout"><img src="images/plus.png"> Déconnexion</a>
    </div>
    <form action="tri_employes.php" method="GET">
        <label for="metier">Choisir un métier :</label>
        <select name="metier" id="metier">
            <option value="developpeur">Développeur</option>
            <option value="designer">Designer</option>
            <option value="comptable">Comptable</option>
            <!-- Ajoutez d'autres options pour les métiers disponibles -->
        </select>
        <button type="submit">Trier par métier</button>
    </form>
    <table>
        <tr id="items">
            <th>Nom</th>
            <th>Prénom</th>
            <th>Age</th>
            <th>Métier</th>
            <th>Modifier</th>
            <th>Supprimer</th>
        </tr>
        <?php
        // Préparer la requête SQL avec une requête préparée
        $query = "SELECT * FROM Employe";
        $stmt = mysqli_prepare($con, $query);
        // Vérifier si la préparation de la requête a réussi
        if ($stmt) {
            // Exécuter la requête
            mysqli_stmt_execute($stmt);
            // Récupérer le résultat de la requête
            $result = mysqli_stmt_get_result($stmt);
            // Vérifier s'il y a des employés dans la base de données
            if(mysqli_num_rows($result) == 0){
                // S'il n'existe pas d'employé dans la base de données, afficher ce message :
                echo "<tr><td colspan='6'>Il n'y a pas encore d'employé ajouté !</td></tr>";
            } else {
                // Sinon, afficher la liste de tous les employés
                while($row=mysqli_fetch_assoc($result)){
                    ?>
                    <tr>
                        <td><?=htmlspecialchars($row['nom'])?></td>
                        <td><?=htmlspecialchars($row['prenom'])?></td>
                        <td><?=htmlspecialchars($row['age'])?></td>
                        <td><?=htmlspecialchars($row['metier'])?></td>
                        <!-- Mettre l'id de chaque employé dans ce lien -->
                        <td><a href="modifier.php?id=<?=intval($row['id'])?>"><img src="images/pen.png"></a></td>
                        <td><a href="supprimer.php?id=<?=intval($row['id'])?>"><img src="images/trash.png"></a></td>
                    </tr>
                    <?php
                }
            }
            // Fermer la requête préparée
            mysqli_stmt_close($stmt);
        } else {
            // En cas d'erreur lors de la préparation de la requête
            echo "Erreur de préparation de la requête SQL.";
        }
        ?>
    </table>
</div>
</body>
</html>
