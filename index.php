<?php
// Permet de savoir s'il y a une session.
// C'est à dire si un utilisateur s'est connecté au site.
session_start();

// Fichier PHP contenant la connexion à votre BDD
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="./assets/style.css">
    <link rel="icon" href="./assets/img/logo-blogybye.ico" type="image/x-icon" />
    <title>Accueil</title>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-info">
        <a class="navbar-brand button-custom" href="index"><img src="./assets/img/logo-blogybye.png" width="60" />
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <?php
        require_once('./components/navbar-home.php');
        ?>
        </div>
    </nav>


    <div class="container d-flex justify-content-center ">
        <div class="bg-success p-2 mt-2 rounded">
            <?php
            if (isset($_SESSION['id'])) {
                echo 'ID : ' . $_SESSION['id'] . ', Nom : ' . $_SESSION['nom'] . ", prénom : " .
                    $_SESSION['prenom'] . ", mail : " . $_SESSION['mail'];
            }
            ?>
            <h1>Blog'y'bye</h1>
            <p>Bienvenue sur le blog crée en PHP & MySQL !</p>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>

</html>