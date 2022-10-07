<?php
session_start();
include('../db/connexionDB.php');

if (!isset($_SESSION['id'])) {
    header('Location: index');
    exit;
}



// On récupère tous les utilisateurs sauf l'utilisateur en cours
$afficher_profil = $DB->query(
    "SELECT * 
    FROM utilisateur 
    WHERE id <> ?",
    array($_SESSION['id'])
);
$afficher_profil = $afficher_profil->fetchAll(); // fetchAll() permet de récupérer plusieurs enregistrements


?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/style.css">
    <link rel="icon" href="../assets/img/logo-blogybye.ico" type="image/x-icon" />
    <title>Utilisateurs du site</title>
</head>

<body>

    <?php
    require_once('navbar.php');
    ?>

    <div class="container ">
        <h1>Utilisateurs</h1>
        <table class="table table-striped">
            <thead>
                <tr class="button-custom">
                    <th>Nom</th>
                    <th>Prénom</th>
                    <th>Voir le profil</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Foreach agit comme une boucle mais celle-ci s'arrête de façon intelligente.
                // Elle s'arrête avec le nombre de lignes qu'il y a dans la variable $afficher_profil
                // La variable $afficher_profil est comme un tableau contenant plusieurs valeurs
                // pour lire chacune des valeurs distinctement on va mettre un pointeur que l'on appellera ici $ap
                foreach ($afficher_profil as $ap) {
                ?>
                <tr>
                    <td><?= $ap['nom'] ?></td>
                    <td><?= $ap['prenom'] ?></td>
                    <td><a class="btn btn-info text-white font-weight-bold"
                            href="./voir-profil?id=<?= $ap['id'] ?>">Aller au
                            profil</a></td>
                </tr>
                <?php
                }
                ?>
            </tbody>
        </table>
    </div>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>

</html>