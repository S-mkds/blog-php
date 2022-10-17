<?php
// Permet de savoir s'il y a une session.
// C'est à dire si un utilisateur s'est connecté au site.
session_start();

// Fichier PHP contenant la connexion à votre BDD
?>
<!DOCTYPE html>
<html lang="fr">

<head>
        <?php
        require_once('./components/header/head.php');
        ?>
    <title>Accueil</title>
</head>

<body>

        <?php
        require_once('./components/menu/navbar-home.php');
        ?>

    <div class="container d-flex justify-content-center ">
        <div class="bg-info p-2 mt-2 rounded">
        <?php
            if (isset($_SESSION['id'])) {
                echo ' Bonjour ' . $_SESSION['pseudo'] ;
            }
            ?>
            <br>
            <?php
            if (isset($_SESSION['id'])) {
                echo 'ID : ' . $_SESSION['id'] . ", Email : " . $_SESSION['mail'];
            }
            ?>
            <h1>Blog'y'bye</h1>
            <p>Bienvenue chez Blog'y'Bye le blog / forum 🚀 !</p>
        </div>
    </div>

</body>
        <?php
        require_once('./views/_footer/footer.php');
        ?>
</html>
