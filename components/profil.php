<?php
session_start();
include('../db/connexionDB.php');

// S'il n'y a pas de session alors on ne va pas sur cette page.
if (!isset($_SESSION['id'])) {
    header('Location: index');
    exit;
}

//On récupère ici les informations de l'utilisateur connecté
$afficher_profil = $DB->query("SELECT * FROM utilisateur WHERE id = ?", array($_SESSION['id']));
$afficher_profil = $afficher_profil->fetch();
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/style.css">
    <link rel="icon" href="../assets/img/logo-blogybye.png" type="image/x-icon" />
    <title>Mon profil</title>

</head>

<body>
    <?php
    require_once('navbar.php');
    ?>

    <div class="mt-2 container ">
        <div class="row">
            <div class="col-0 col-sm-0 col-md-2 col-lg-3"></div>
            <div class="col-12 col-sm-12 col-md-8 col-lg-6 p-2 bg-success bg-gradient rounded-bottom">
                <h2>Vos informations : <br><?= $afficher_profil['nom'] ?> <?= $afficher_profil['prenom']; ?></h2>
                <div> Quelques informations en plus sur vous : </div>
                <ul>
                    <li>Votre ID est : <strong><?= $afficher_profil['id'] ?></strong></li>
                    <li>Votre nom est : <strong><?= $afficher_profil['nom'] ?></strong></li>
                    <li>Votre prenom est : <strong><?= $afficher_profil['prenom'] ?></strong></li>
                    <li>Votre Email est : <strong><?= $afficher_profil['mail'] ?></strong></li>
                    <li>Votre compte a été crée le : <strong><?= $afficher_profil['date_creation_compte'] ?></strong>
                    </li>
                </ul>
                <div>
                </div>
                <div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>

</html>