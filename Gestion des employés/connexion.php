<?php
  //connexion à la base de données
  $con = mysqli_connect("localhost","root","","entreprise");
  if(!$con){
     echo "Vous n'êtes pas connecté à la base de donnée";
  }
?>
<?php
// Définir les constantes de connexion
define("DB_HOST", "localhost");
define("DB_USER", "root");
define("DB_PASSWORD", "");
define("DB_NAME", "entreprise");

// Connexion à la base de données
$con = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

// Vérifier la connexion
if (!$con) {
    die("Erreur de connexion à la base de données : " . mysqli_connect_error());
} else {
    // La connexion à la base de données est établie avec succès
    // Vous pouvez placer ici d'autres instructions à exécuter une fois la connexion réussie
}
?>
