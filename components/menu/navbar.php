
<nav class="navbar navbar-expand-lg navbar-light navbar-bg">
<a class="navbar-brand" href="../../../index"><img src="../../assets/img/logo-blogybye.png" class="nav-logo" />
</a>
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
                <a class="button-custom nav-link p-1 m-2 rounded-bottom myButton"
                    href="../../views/_forum/forum">Forum</a>
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
                <a class="button-custom nav-link p-1 m-2 rounded-bottom myButton"
                    href="../../views/_blog/blog">Blog</a>
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
                <a class="button-custom nav-link p-1 m-2 rounded-bottom myButton"
                    href="../../views/_profil/profil">Profil</a>
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
                <a class="button-custom nav-link p-1 m-2 rounded-bottom myButton"
                    href="../../views/_profil/membres">Membres</a>
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
                <a class="button-custom nav-link p-1 m-2 rounded-bottom myButton"
                    href="../../components/inscription">Inscription</a>
            </li>
            <li class="nav-item">
                <a class="button-custom nav-link p-1 m-2 rounded-bottom myButton"
                    href="../../components/inscription">Connexion</a>
            </li>
            <?php
            } else {
            ?>
            <li class="nav-item">
                <a class="button-custom nav-link p-1 m-2 rounded-bottom myButton"
                    href="../../components/deconnexion">Déconnexion</a>
            </li>
            <?php
            }
            ?>
        </ul>
    </div>
</nav>