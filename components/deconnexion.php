<?php
session_start();
session_destroy();

header('Location: ../index'); // Ici il faut mettre la page sur lequel l'utilisateur sera redirigé.
exit;