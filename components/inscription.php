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

    // On se place sur le bon formulaire grâce au "name" de la balise "input"
    if (isset($_POST['inscription'])) {
        $nom = htmlentities(trim($nom)); // On récupère le nom
        $prenom = htmlentities(trim($prenom)); // on récupère le prénom
        $mail = htmlentities(strtolower(trim($mail))); // On récupère le mail
        $mdp = trim($mdp); // On récupère le mot de passe 
        $confmdp = trim($confmdp); //  On récupère la confirmation du mot de passe

        //  Vérification du nom
        if (empty($nom)) {
            $valid = false;
            $er_nom = ("❌ Le nom d' utilisateur ne peut pas être vide");
        }

        //  Vérification du prénom
        if (empty($prenom)) {
            $valid = false;
            $er_prenom = ("❌ Le prenom d' utilisateur ne peut pas être vide");
        }

        // Vérification du mail
        if (empty($mail)) {
            $valid = false;
            $er_mail = "Le mail ne peut pas être vide";

            // On vérifit que le mail est dans le bon format
        } elseif (!preg_match("/^[a-z0-9\-_.]+@[a-z]+\.[a-z]{2,3}$/i", $mail)) {
            $valid = false;
            $er_mail = "❌ Le mail n'est pas valide";
        } else {
            // On vérifit que le mail est disponible
            $req_mail = $DB->query(
                "SELECT mail FROM utilisateur WHERE mail = ?",
                array($mail)
            );

            $req_mail = $req_mail->fetch();

            if ($req_mail['mail'] <> "") {
                $valid = false;
                $er_mail = "❌ Ce mail existe déjà";
            }
        }

        // Vérification du mot de passe
        if (empty($mdp)) {
            $valid = false;
            $er_mdp = "❌ Le mot de passe ne peut pas être vide";
        } elseif ($mdp != $confmdp) {
            $valid = false;
            $er_mdp = "❌ La confirmation du mot de passe ne correspond pas";
        }

        // Si toutes les conditions sont remplies alors on fait le traitement
        if ($valid) {
            $mdp = crypt($mdp, '$6$rounds=5000$irkgbjdidjzdzdzararidsam$'); // php crypt manuel 
            $date_creation_compte = date('Y-m-d H:i:s');
            $token = bin2hex(random_bytes(12)); // bin2hex(random_bytes($length))

            // On insert nos données dans la table utilisateur
            $DB->insert(
                "INSERT INTO utilisateur (nom, prenom, mail, mdp, date_creation_compte, token) 
                    VALUES 
                    (?, ?, ?, ?, ?, ?)",
                array($nom, $prenom, $mail, $mdp, $date_creation_compte, $token)
            );

            $req = $DB->query(
                "SELECT *
                FROM utilisateur
                WHERE mail = ?",
                array($mail)
            );

            $req = $req->fetch();
            // $mail_to = $req['mail'];

            //=====Création du header de l'e-mail.
            // $header = "From: no-reply <no-reply@gmail.com>\n";
            // $header .= "MIME-version: 1.0\n";
            // $header .= "Content-type: text/html; charset=utf-8\n";
            // $header .= "Content-Transfer-ncoding: 8bit";

            //=====Ajout du message au format HTML
            // $contenu = '<p>Bonjour ' . $req['nom'] . ',</p><br>
            //     <p>Veuillez confirmer votre compte <a href="http://www.domaine.com/conf?id=' . $req['id'] . '&token=' . $token . '">Valider</a><p>';
            // mail($mail_to, 'Confirmation de votre compte', $contenu, $header);

            header('Location: ../index');
            exit;
        }
    }
}
// Fonction pour récupérer Favicon
function getFavicon($url)
{
    # make the URL simpler
    $elems = parse_url($url);
    $url = $elems['scheme'] . '://' . $elems['host'];

    # load site
    $output = file_get_contents($url);

    # look for the shortcut icon inside the loaded page
    $regex_pattern = "/rel=\"shortcut icon\" (?:href=[\'\"]([^\'\"]+)[\'\"])?/";
    preg_match_all($regex_pattern, $output, $matches);

    if (isset($matches[1][0])) {
        $favicon = $matches[1][0];

        # check if absolute url or relative path
        $favicon_elems = parse_url($favicon);

        # if relative
        if (!isset($favicon_elems['host'])) {
            $favicon = $url . '/' . $favicon;
        }

        return $favicon;
    }

    return false;
}
//End php
?>


<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/style.css">
    <link rel="icon" href="../assets/img/logo-blogybye.ico" type="image/x-icon" />
    <title>Inscription</title>
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

                                    <h2 class="fw-bold mb-2 text-uppercase">Inscription</h2>
                                    <p class="text-white-50 mb-5">Veuillez remplir le formulaire d'inscription pour vous
                                        inscrire</p>

                                    <div class="form-outline form-white mb-4">
                                        <?php
                                        // S'il y a une erreur sur le nom alors on affiche
                                        if (isset($er_nom)) {
                                        ?>
                                        <div><?= $er_nom ?></div>
                                        <?php
                                        }
                                        ?>
                                        <input type="text" value="<?php if (isset($nom)) {
                                                                        echo $nom;
                                                                    } ?>" class="form-control form-control-lg"
                                            placeholder="Votre nom" name="nom" required>
                                        <label class="form-label">Entrez votre nom</label>
                                    </div>

                                    <div class="form-outline form-white mb-4">
                                        <?php
                                        if (isset($er_prenom)) {
                                        ?>
                                        <div><?= $er_prenom ?></div>
                                        <?php
                                        }
                                        ?>
                                        <input type="text" value="<?php if (isset($prenom)) {
                                                                        echo $prenom;
                                                                    } ?>" class="form-control form-control-lg"
                                            placeholder="Votre prénom" name="prenom" required>
                                        <label class="form-label">Entrez votre prénom</label>
                                    </div>

                                    <div class="form-outline form-white mb-4">
                                        <?php
                                        if (isset($er_mail)) {
                                        ?>
                                        <div><?= $er_mail ?></div>
                                        <?php
                                        }
                                        ?>
                                        <input type="email" value="<?php if (isset($mail)) {
                                                                        echo $mail;
                                                                    } ?>" class="form-control form-control-lg"
                                            placeholder="Adresse mail" name="mail" required>
                                        <label class="form-label">Entrez votre adresse Email</label>
                                    </div>

                                    <div class="form-outline form-white mb-4">
                                        <?php
                                        if (isset($er_mdp)) {
                                        ?>
                                        <div><?= $er_mdp ?></div>
                                        <?php
                                        }
                                        ?>
                                        <input type="password" value="<?php if (isset($mdp)) {
                                                                            echo $mdp;
                                                                        } ?>" class="form-control form-control-lg"
                                            placeholder="Mot de passe" name="mdp" required>
                                        <label class="form-label">Entrez votre mot de passe</label>

                                        <div class="form-outline form-white mt-4">
                                            <input type="password" class="form-control form-control-lg"
                                                placeholder="Confirmer le mot de passe" name="confmdp" required>
                                            <label class="form-label">Confirmez votre mot de passe</label>
                                        </div>
                                    </div>


                                    <button type="submit" class="btn btn-outline-light btn-lg px-5" href="connexion"
                                        name="inscription">Envoyer</button>

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
                                    <p class="mb-0">Vous avez un compte ? <a href="connexion"
                                            class="text-white-50 fw-bold">Se connecter</a>
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