<?php
session_start();
include('../../db/connexionDB.php');

if (!isset($_SESSION['id'])) {
    header('Location: index');
    exit;
}

// Récupèration de l'id passer en argument dans l'URL
$id = (int) $_GET['id'];
// On récupère les informations de l'utilisateur grâce à son ID
$afficher_profil = $DB->query("SELECT * 
    FROM utilisateur 
    WHERE id = ?", array($id));
$afficher_profil = $afficher_profil->fetch();

if (!isset($afficher_profil['id'])) {
    header('Location: index');
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../assets/style.css">
    <link rel="icon" href="../../assets/img/logo-blogybye.ico" type="image/x-icon" />

    <title>Profil-membre</title>
</head>

<body>

    <?php
    require_once('../../components/navbar.php');
    ?>

    <div class="d-flex justify-content-center mt-5">
        <div class="bg-info rounded p-4">
            <h2>Voici le profil de <?= $afficher_profil['nom'] . " " . $afficher_profil['prenom']; ?></h2>
            <div>Quelques informations sur lui : </div>
            <ul>
                <li><strong>L'ID : </strong><em><?= $afficher_profil['id'] ?></em></li>
                <li><strong>L'email :</strong><em> <?= $afficher_profil['mail'] ?></em></li>
                <li><strong>Le compte a été crée le : </strong><em><?= $afficher_profil['date_creation_compte'] ?></em>
                </li>
            </ul>

            <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
            <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
        </div>
    </div>
</body>

</html>