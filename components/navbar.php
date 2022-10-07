<nav class="navbar navbar-expand-lg navbar-light bg-info">
    <a class="navbar-brand button-custom" href="../index"><img src="../assets/img/logo-blogybye.png" width="60" /></a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
        <?php
            if (!isset($_SESSION['id'])) {
                // ...
            } else {
            ?>
            
            <li class="nav-item">
                <a class="button-custom nav-link nav-link bg-success bg-gradient p-2 m-1 rounded-bottom"
                    href="forum">Forum</a>
            </li>
            <?php
            }
            ?>
                        <?php
            if (!isset($_SESSION['id'])) {
                // ...
            } else {
            ?>
            
            <li class="nav-item">
                <a class="button-custom nav-link nav-link bg-success bg-gradient p-2 m-1 rounded-bottom"
                    href="blog">Blog</a>
            </li>
            <?php
            }
            ?>
            <?php
            if (!isset($_SESSION['id'])) {
                // ...
            } else {
            ?>
            <li class="nav-item">
                <a class="button-custom nav-link nav-link bg-success bg-gradient p-2 m-1 rounded-bottom"
                    href="profil">Mon profil</a>
            </li>
            <?php
            }
            ?>
            <?php
            if (!isset($_SESSION['id'])) {
                // ...
            } else {
            ?>
            
            <li class="nav-item">
                <a class="button-custom nav-link nav-link bg-success bg-gradient p-2 m-1 rounded-bottom"
                    href="modifier-profil">Modifier Profil</a>
            </li>
            <?php
            }
            ?>
            <?php
            if (!isset($_SESSION['id'])) {
                // ...
            } else {
            ?>
            <li class="nav-item">
                <a class="button-custom nav-link nav-link bg-success bg-gradient p-2 m-1 rounded-bottom"
                    href="utilisateur">Membres</a>
            </li>
            <?php
            }
            ?>
        </ul>
        <ul class="navbar-nav ml-md-auto">
            <?php
            if (!isset($_SESSION['id'])) {
            ?>
            <li class="nav-item">
                <a class="button-custom nav-link bg-success bg-gradient p-2 m-1 rounded-bottom"
                    href="inscription">Inscription</a>
            </li>
            <li class="nav-item">
                <a class="button-custom nav-link bg-success bg-gradient p-2 m-1 rounded-bottom"
                    href="connexion">Connexion</a>
            </li>
            <?php
            } else {
            ?>
            <li class="nav-item">
                <a class="button-custom nav-link bg-success bg-gradient p-2 m-1 rounded-bottom"
                    href="deconnexion">Déconnexion</a>
            </li>
            <?php
            }
            ?>
        </ul>
    </div>
</nav>