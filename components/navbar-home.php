<ul class="navbar-nav mr-auto">
            <?php
                if (!isset($_SESSION['id'])) {
                    // ...
                } else {
                ?>
                <li class="nav-item">
                    <a class="button-custom nav-link nav-link bg-success bg-gradient p-2 m-1 rounded-bottom"
                        href="./components/forum">forum</a>
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
                        href="./components/blog">blog</a>
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
                        href="./components/profil">Mon profil</a>
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
                        href="./components/modifier-profil">Modifier Profil</a>
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
                        href="./components/utilisateur">Membres</a>
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
                        href="./components/inscription">Inscription</a>
                </li>
                <li class="nav-item">
                    <a class="button-custom nav-link bg-success bg-gradient p-2 m-1 rounded-bottom"
                        href="./components/connexion">Connexion</a>
                </li>
                <?php
                } else {
                ?>
                <li class="nav-item">
                    <a class="button-custom nav-link bg-success bg-gradient p-2 m-1 rounded-bottom"
                        href="./components/deconnexion">Déconnexion</a>
                </li>
                <?php
                }
                ?>
            </ul>