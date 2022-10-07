<?php
session_start();

include('../db/connexionDB.php'); // Fichier PHP contenant la connexion à votre BDD

// S'il y a une session alors on ne retourne plus sur cette page  
if (isset($_SESSION['id'])) {
    header('Location: index');
    exit;
}

// Si la variable "$_Post" contient des informations alors on les traitres
if (!empty($_POST)) {
    extract($_POST);
    $valid = true;

    if (isset($_POST['connexion'])) {

        $mail = htmlentities(strtolower(trim($mail)));
        $mdp = trim($mdp);

        if (empty($mail)) { // Vérification qu'il y est bien un mail de renseigné
            $valid = false;
            $er_mail = "❌ Il faut mettre un mail";
        }

        if (empty($mdp)) { // Vérification qu'il y est bien un mot de passe de renseigné
            $valid = false;
            $er_mdp = "❌ Il faut mettre un mot de passe";
        }

        // On fait une requète pour savoir si le couple mail / mot de passe existe bien car le mail est unique !
        $req = $DB->query(
            "SELECT * FROM utilisateur WHERE mail = ? AND mdp = ?",
            array($mail, crypt($mdp, '$6$rounds=5000$irkgbjdidjzdzdzararidsam$'))
        );
        // array($mail, crypt($mdp, "VOTRE CLÉ UNIQUE DE CRYPTAGE DU MOT DE PASSE")));
        $req = $req->fetch();

        // Si on a pas de résultat alors c'est qu'il n'y a pas d'utilisateur correspondant au couple mail / mot de passe
        if (!isset($req['id'])) {
            $valid = false;
            $er_mail = "❌ Le mail ou le mot de passe est incorrecte";
        } elseif ($req['n_mdp'] == 1) { // On remet à zéro la demande de nouveau mot de passe s'il y a bien un couple mail / mot de passe
            $DB->insert(
                "UPDATE utilisateur SET n_mdp = 0 WHERE id = ?",
                array($req['id'])
            );
        }

        //==========
        // Si le token est != de null alors le compte n'est pas encore validé par mail
        // elseif ($req['token'] <> NULL) {
        //     $valid = false;
        //     $er_mail = "Veuillez confirmer votre compte";
        // }


        // S'il y a un résultat alors on va charger la SESSION de l'utilisateur en utilisateur les variables $_SESSION
        if ($valid) {

            $_SESSION['id'] = $req['id']; // id de l'utilisateur unique pour les requètes futures
            $_SESSION['nom'] = $req['nom'];
            $_SESSION['prenom'] = $req['prenom'];
            $_SESSION['mail'] = $req['mail'];

            header('Location:  ../index');
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
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon" />
    <link rel="icon" href="../assets/img/logo-blogybye.ico" type="image/x-icon" />
    <title>Connexion</title>
</head>

<body>
    <?php
    require_once('navbar.php');
    ?>
    <section class="vh-80 gradient-custom">
        <form method="post">
            <div class="container py-5 h-100">
                <div class="row d-flex justify-content-center align-items-center h-100">
                    <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                        <div class="card bg-dark text-white" style="border-radius: 1rem;">
                            <div class="card-body p-5 text-center">

                                <div class="mb-md-2 mt-md-4 pb-5">
                                    <h2 class="fw-bold mb-2 text-uppercase">Se connecter</h2>
                                    <p class="text-white-50 mb-5">Veuillez entrez votre Email et mot de passe</p>

                                    <div class="form-outline form-white mb-4">
                                        <?php
                                        if (isset($er_mail)) {
                                        ?>
                                        <div><?= $er_mail ?></div>
                                        <?php
                                        }
                                        ?>

                                        <input type="email" class="form-control form-control-lg"
                                            placeholder="Adresse mail" name="mail"
                                            value="<?php if (isset($mail)) {
                                                                                                                                                    echo $mail;
                                                                                                                                                } ?>"
                                            required>
                                        <label class="form-label">Email</label>
                                    </div>

                                    <div class="form-outline form-white mb-4">
                                        <?php
                                        if (isset($er_mdp)) {
                                        ?>
                                        <div><?= $er_mdp ?></div>
                                        <?php
                                        }
                                        ?>
                                        <input type="password" class="form-control form-control-lg"
                                            placeholder="Mot de passe" name="mdp"
                                            value="<?php if (isset($mdp)) {
                                                                                                                                                        echo $mdp;
                                                                                                                                                    } ?>"
                                            required>
                                        <label class="form-label">Mot de passe</label>
                                    </div>
                                    <?php
                                    if (!isset($_SESSION['id'])) {
                                    ?>
                                    <p class="small mb-2 pb-lg-2"><a class="text-white-50" href="motdepasse">Mot de
                                            passe oublié</a>
                                    </p>
                                    <?php
                                    }
                                    ?>

                                    <button class="btn btn-outline-light btn-lg px-5" type="submit" name="connexion">Se
                                        connecter</button>

                                    <?php /*
                                <div class="d-flex justify-content-center text-center mt-4 pt-1">
                                    <a href="#!" class="text-white"><i class="fab fa-facebook-f fa-lg"></i></a>
                                    <a href="#!" class="text-white"><i class="fab fa-twitter fa-lg mx-4 px-2"></i></a>
                                    <a href="#!" class="text-white"><i class="fab fa-google fa-lg"></i></a>
                                </div>
                                */
                                    ?>
                                </div>
                                <div>
                                    <p class="mb-0">Vous n'avez pas de compte ? <a href="inscription"
                                            class="text-white-50 fw-bold">S'inscrire</a>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </section>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>

</html>