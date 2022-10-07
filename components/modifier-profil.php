<?php
session_start();
include('../db/connexionDB.php');

if (!isset($_SESSION['id'])) {
    header('Location: index');
    exit;
}

// On récupère les informations de l'utilisateur connecté
$afficher_profil = $DB->query(
    "SELECT * FROM utilisateur WHERE id = ?",
    array($_SESSION['id'])
);
$afficher_profil = $afficher_profil->fetch();

if (!empty($_POST)) {
    extract($_POST);
    $valid = true;

    if (isset($_POST['modification'])) {
        $nom = htmlentities(trim($nom));
        $prenom = htmlentities(trim($prenom));
        $mail = htmlentities(strtolower(trim($mail)));

        if (empty($nom)) {
            $valid = false;
            $er_nom = "Il faut mettre un nom";
        }

        if (empty($prenom)) {
            $valid = false;
            $er_prenom = "Il faut mettre un prénom";
        }

        if (empty($mail)) {
            $valid = false;
            $er_mail = "Il faut mettre un mail";
        } elseif (!preg_match("/^[a-z0-9\-_.]+@[a-z]+\.[a-z]{2,3}$/i", $mail)) {
            $valid = false;
            $er_mail = "Le mail n'est pas valide";
        } else {
            $req_mail = $DB->query(
                "SELECT mail FROM utilisateur WHERE mail = ?",
                array($mail)
            );
            $req_mail = $req_mail->fetch();

            if ($req_mail['mail'] <> "" && $_SESSION['mail'] != $req_mail['mail']) {
                $valid = false;
                $er_mail = "Ce mail existe déjà";
            }
        }

        if ($valid) {
            $DB->insert(
                "UPDATE utilisateur SET prenom = ?, nom = ?, mail = ? WHERE id = ?",
                array($prenom, $nom, $mail, $_SESSION['id'])
            );

            $_SESSION['nom'] = $nom;
            $_SESSION['prenom'] = $prenom;
            $_SESSION['mail'] = $mail;

            header('Location: profil');
            exit;
        }
    }
}
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
    <title>Modifier votre profil</title>

</head>

<body>
    <?php
    require_once('navbar.php');
    ?>

    <section class="container">
        <h4 class="button-custom">Modifier le profil</h4>
        <form method="post">

            <!-- Nom input -->
            <?php
            if (isset($er_nom)) {
            ?>
            <div><?= $er_nom ?></div>
            <?php
            }
            ?>
            <input class="form-control" type="text" placeholder="Votre nom" name="nom" value="<?php if (isset($nom)) {
                                                                                                    echo $nom;
                                                                                                } else {
                                                                                                    echo $afficher_profil['nom'];
                                                                                                } ?>" required>
            <label class="form-label button-custom">Nom</label>

            <!-- Prénom input -->
            <?php
            if (isset($er_prenom)) {
            ?>
            <div><?= $er_prenom ?></div>
            <?php
            }
            ?> <input class="form-control" type="text" placeholder="Votre prénom" name="prenom" value="<?php if (isset($prenom)) {
                                                                                                            echo $prenom;
                                                                                                        } else {
                                                                                                            echo $afficher_profil['prenom'];
                                                                                                        } ?>" required>
            <label class="form-label button-custom">Prénom</label>

            <!-- Email input -->
            <?php
            if (isset($er_mail)) {
            ?>
            <div><?= $er_mail ?></div>
            <?php
            }
            ?>
            <input class="form-control" type="email" placeholder="Adresse mail" name="mail" value="<?php if (isset($mail)) {
                                                                                                        echo $mail;
                                                                                                    } else {
                                                                                                        echo $afficher_profil['mail'];
                                                                                                    } ?>" required>
            <label class="form-label button-custom">Email</label>

            <!-- Send input -->
            <br>
            <button type="submit" name="modification" class="btn btn-outline-light btn-lg px-5">Modifier</button>

        </form>
    </section>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>

</html>