<?php

	require_once('../../include.php');
	
	if(!isset($_SESSION['id'])){
		header('Location: /');
		exit;
	}
	
	if(!isset($_GET['id'])){
		header('Location: forum.php');
		exit;
	}
	
	$get_id_topic_commentaire = (int) $_GET['id'];
	
	if($get_id_topic_commentaire <= 0){
		header('Location: forum.php');
		exit;
	}
	
	$req = $DB->prepare("SELECT *
		FROM topic_commentaire
		WHERE id = ?");
		
	$req->execute([$get_id_topic_commentaire]);
	
	$req_topic_commentaire = $req->fetch();
	
	if(!isset($req_topic_commentaire['id'])){
		header('Location: forum.php');
		exit;
	}
	
	if($req_topic_commentaire['id_utilisateur'] <> $_SESSION['id']){
		header('Location: topic.php?id=' . $req_topic_commentaire['id_topic']);
		exit;
	}

	if(!empty($_POST)){
		extract($_POST);
		
		$valid = true;	
		
		if(isset($_POST['modification'])){
			
			$commentaire = (String) trim($commentaire);
			
			if(empty($commentaire)){
				$valid = false;
				$err_commentaire = "Ce champ ne peut pas être vide";
			
			}elseif(grapheme_strlen($commentaire) < 4){
				$valid = false;
				$err_commentaire = "Le commentaire doit faire plus de 3 caractères";
			}
				
			if($valid){
				
				$date_modification = date('Y-m-d H:i:s');
				
				$req = $DB->prepare("UPDATE topic_commentaire SET contenu = ?, date_modification = ? WHERE id = ?");	
				
				$req->execute([$commentaire, $date_modification, $req_topic_commentaire['id']]);
				
				
				header('Location: topic.php?id=' . $req_topic_commentaire['id_topic']);
				exit;
			}			
		}
	}	


?>
<!doctype html>
<html lang="fr">
	<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../assets/style.css">
    <link rel="icon" href="../../assets/img/logo-blogybye.ico" type="image/x-icon" />
		<title>Éditer mon commentaire</title>
	</head>
	<body>

		<?php	
			require_once('../../components/menu/navbar.php');
		?>
		<div class="container">
			<div class="row">
				<div class="col-3"></div>
				<div class="col-6">
					<h1>Éditer mon commentaire</h1>
					<form method="post">
						<div class="mb-3">
							<?php if(isset($err_commentaire)){ echo '<div>' . $err_commentaire . '</div>'; }?>
							<label class="form-label">Commentaire</label>
							<textarea class="form-control" type="text" name="commentaire" placeholder="Votre commentaire ..."><?php if(isset($commentaire)){ echo $commentaire; }else{ echo $req_topic_commentaire['contenu']; }?></textarea>
						</div>
						<div class="mb-3">
							<button type="submit" name="modification" class="btn btn-primary">Modifier mon commentaire</button>
						</div>
					</form>
				</div>
			</div>
		</div>

	</body>
</html>