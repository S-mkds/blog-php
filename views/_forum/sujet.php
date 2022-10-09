<?php
  session_start();
  include('../../db/connexionDB.php'); // Fichier PHP contenant la connexion à votre BDD
  $get_id = (int) trim(htmlentities($_GET['id'])); // On récupère l'id de la catégorie
  if(empty($get_id)){ // On vérifie qu'on a bien un id sinon on redirige vers la page forum
    header('Location: /forum');
    exit;
  }
  // On va récupérer toutes les informations des sujets, mettre les dates au format 'Le 24/04/2018 à 21h32' 
  // et ajouter les prénoms des personnes qui ont créé leur sujet
  $req = $DB->query("SELECT t.*, DATE_FORMAT(t.date_creation, 'Le %d/%m/%Y à %H\h%i') as date_c, U.prenom
    FROM topic T
    LEFT JOIN utilisateur U ON U.id = T.id_user
    WHERE t.id_forum = ?
    ORDER BY t.date_creation DESC", 
    array($get_id));
    
  $req = $req->fetchAll();
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>
    <title>Sujet</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../assets/style.css">
    <link rel="icon" href="../../assets/img/logo-blogybye.ico" type="image/x-icon" />
  </head>
  <body>
  <?php
    require_once('../../components/navbar.php');
    ?>
  <div class="container">
    <div class="row"> 
      <div class="col-sm-0 col-md-0 col-lg-0"></div>
      <div class="col-sm-12 col-md-12 col-lg-12">
        <h1 style="text-align: center">Forum</h1>
        <div class="table-responsive">
          <table class="table table-striped">
            <tr>
              <th>ID</th>
              <th>Titre</th>
              <th>Date</th>
              <th>Par </th>
            </tr>
            <?php
              foreach($req as $r){ // Ici on va afficher tous nos enregistrements trouvés
              ?>
              <tr>
                <td><?= $r['id'] ?> </td>
                <!-- On met un lien pour afficher le topic en entier -->
                <td><a href="./topic?id=<?= $get_id?>/<?= $r['id']?>"><?= $r['titre'] ?></a></td>
              
                <td><?= $r['date_c'] ?></td>
                <td><?= $r['prenom'] ?></td>
              </tr> 
              <?php
              }
            ?>
            </table>         
          </div>
        </div>
      </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>
  </body>
</html>