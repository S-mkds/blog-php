<?php
  session_start();
  include('../db/connexionDB.php'); // Fichier PHP contenant la connexion à votre BDD
  
  $req = $DB->query("SELECT * 
    FROM forum
    ORDER BY ordre");
    
    $req = $req->fetchAll();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/style.css">
    <link rel="icon" href="../assets/img/logo-blogybye.ico" type="image/x-icon" />
    <title>Forum</title>
</head>
<body>
    <?php
    require_once('navbar.php');
    ?>
    <table class="table table-striped text-white">
    <tr>
    <th>ID</th>
    <th>Titre</th>
    </tr>
    <?php
    foreach($req as $r){
    ?>
    <tr>
    <td><?= $r['id'] ?></td>
    <td><a href="forum/<?= $r['id'] ?>"><?= $r['titre'] ?></a></td>
    </tr> 
    <?php
    }
    ?>
</table>
</body>
</html>