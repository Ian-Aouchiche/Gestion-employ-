<?php
//inclure la page de connexion
include_once "connexion.php";

//requête pour afficher la liste des employés
$req = mysqli_query($con , "SELECT * FROM Employe");
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
<script>
    function deleteSelectedEmployees() {
        var checkboxes = document.getElementsByName("selected_employees[]");
        var selectedIds = [];

        for (var i = 0; i < checkboxes.length; i++) {
            if (checkboxes[i].checked) {
                selectedIds.push(checkboxes[i].value);
            }
        }

        if (selectedIds.length > 0) {
            // Construire l'URL de suppression avec les IDs sélectionnés
            var url = "delete_employees.php?id=" + selectedIds.join(",");
            
            // Rediriger vers l'URL de suppression
            window.location.href = url;
        } else {
            alert("Veuillez sélectionner au moins un employé à supprimer.");
        }
    }
</script>

<div class="container">
    <h1>Liste des Employés</h1>

    <div class="button-container">
        <a href="acceuil.php" class="back_btn"><img src="images/back.png"> Retour</a>
    </div>
    
    <div class="button-container">
        <a href="ajouter.php" class="Btn_add"> <img src="images/plus.png"> Ajouter</a>
        <a href="selectionner.php" class="Btn_select"><img src="images/plus.png"> Sélectionner</a>
        <button onclick="deleteSelectedEmployees()" class="Btn_delete">Supprimer sélectionnés</button>
    </div>
        
    <table>
        <tr id="items">
            <th>Sélection</th>
            <th>Nom</th>
            <th>Prénom</th>
            <th>Age</th>
            <th>Metier</th>
            <th>Modifier</th>
            <th>Supprimer</th>
        </tr>
        <?php 
        // Vérifier s'il y a des employés dans la base de données
        if(mysqli_num_rows($req) == 0){
            echo "<tr><td colspan='7'>Il n'y a pas encore d'employé ajouté!</td></tr>";
        } else {
            // Afficher la liste de tous les employés
            while($row=mysqli_fetch_assoc($req)){
                ?>
                <tr>
                    <td><input type="checkbox" name="selected_employees[]" value="<?=$row['id']?>"></td>
                    <td><?=$row['nom']?></td>
                    <td><?=$row['prenom']?></td>
                    <td><?=$row['age']?></td>
                    <td><?=$row['metier']?></td>
                    <td><a href="modifier.php?id=<?=$row['id']?>"><img src="images/pen.png"></a></td>
                    <td><a href="supprimer.php?id=<?=$row['id']?>"><img src="images/trash.png"></a></td>
                </tr>
                <?php
            }
        }
        ?>
    </table>
</div>

</body>
</html>