<?php
	session_start();
	include('../../db/connexionDB.php');

	$get_id_forum = (int) trim(htmlentities($_GET['id_forum']));
	$get_id_topic = (int) trim(htmlentities($_GET['id_topic']));

	if(empty($get_id_forum) || empty($get_id_topic)){
		header('Location: ../_forum/forum');
		exit;
	}

	$req = $DB->query("SELECT t.*, DATE_FORMAT(t.date_creation, 'Le %d/%m/%Y à %H\h%i') as date_c, U.prenom
		FROM topic T
		LEFT JOIN utilisateur U ON U.id = T.id_user
		WHERE t.id = ? AND t.id_forum = ?
		ORDER BY t.date_creation DESC",
		array($get_id_topic, $get_id_forum));

	$req = $req->fetch();

	if(!isset($req['id'])){
		header('Location: ../_forum/forum/' . $get_id_forum);
		exit;
	}

	$req_commentaire = $DB->query("SELECT TC.*, DATE_FORMAT(TC.date_creation, 'Le %d/%m/%Y à %H\h%i') as date_c, U.prenom, U.nom
		FROM topic_commentaire TC
		LEFT JOIN utilisateur U ON U.id = TC.id_user
		WHERE id_topic = ?
		ORDER BY date_creation DESC",
		array($get_id_topic));

	$req_commentaire = $req_commentaire->fetchAll();

	if(!empty($_POST)){
		extract($_POST);
		$valid = true;

		// On se positionne sur le formulaire d'ajout d'un commentaire
		if (isset($_POST['ajout-commentaire'])){

			// On récupère le contenu du commentaire
			$text= (String) trim($text);

			// On fait quelques vérifications
			if(empty($text)){
				$valid = false;
				$er_commentaire = "Il faut mettre un commentaire";
			}elseif(iconv_strlen($text, 'UTF-8') <= 3){
				$valid = false;
				$er_commentaire = "Il faut mettre plus de 3 caractères";
			}
			// Par précaution on sécurise notre commentaire
			$text = htmlentities($text);

			if($valid){
				$date_creation = date('Y-m-d H:i:s');

				// On insètre le commentaire dans la base de données
				$DB->insert("INSERT INTO topic_commentaire (id_topic, id_user, text, date_creation) VALUES (?, ?, ?, ?)",
					array($get_id_topic, $_SESSION['id'], $text, $date_creation));

				header('Location: ../_forum/forum/' . $get_id_forum . '/' . $get_id_topic);
				exit;
			}
		}
	}	
?>

<!DOCTYPE html>
<html>
	<head>
		<base href="/"/>
		<meta charset="utf-8"/>
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>
		<title>Topic</title>
		<link rel="stylesheet" href="../../css/bootstrap.min.css"/>
		<link rel="stylesheet" href="../../css/style.css"/>
	</head>
	<body>

    <?php
    require_once('../../components/navbar.php');
    ?>

		<div class="container">
			<div class="row">	
				
				<div class="col-sm-12 col-md-12 col-lg-12">
					<h1 style="text-align: center">Topic : <?= $req['titre'] ?></h1>
				
					<div style="background: white; box-shadow: 0 5px 15px rgba(0, 0, 0, .15); padding: 5px 10px; border-radius: 10px">
					<h3>Contenu</h3>
					<div style="border-top: 2px solid #eee; padding: 10px 0"><?= $req['contenu'] ?></div>
					<div style="color: #CCC; font-size: 10px; text-align: right">
						<?= $req['date_c'] ?>
							par
							<?= $req['prenom'] ?>
					</div>				
					</div>
					
					<?php
						// Mis en place de notre espace pour poster des commentaires
						// Uniquement si l'utilisateur est connecté il pourra faire un commentaire
						if(isset($_SESSION['id'])){
					?>
						<div style="background: white; box-shadow: 0 5px 15px rgba(0, 0, 0, .15); padding: 5px 10px; border-radius: 10px; margin-top: 20px">
						<h3>Participer à la discussion</h3>
							
							<?php
				// S'il y a une erreur sur le nom alors on affiche
				if (isset($er_commentaire)){
				?>
				<div class="er-msg"><?= $er_commentaire ?></div>
				<?php
				}
				?>
 
							<form method="post">
								<div class="form-group">
								<textarea class="form-control" name="text" rows="4"></textarea>
								</div>
								<div class="form-group">
						<button class="btn btn-primary" type="submit" name="ajout-commentaire">Envoyer</button>
								</div>
							</form>
						</div>
					<?php
						}	
					?>
					
					<div style="background: white; box-shadow: 0 5px 15px rgba(0, 0, 0, .15); padding: 5px 10px; border-radius: 10px; margin-top: 20px">
					<h3>Commentaires</h3>
			
						<div class="table-responsive">
						<table class="table table-striped">
							<?php
							foreach($req_commentaire as $rc){
							?>
							<tr>
							<td>
							<?= "De " . $rc['nom'] . " " . $rc['prenom'] ?></a>
							</td>
							<td>
							<?= $rc['text'] ?>
							</td>
							<td>
							<?= $rc['date_c'] ?>
							</td>
							</tr>
							<?php
							}
							?>
							</table>					
						</div>
					</div>
				</div>
			</div>
		</div>
 
	<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
		<script src="../js/bootstrap.min.js"></script>
	</body>
</html>