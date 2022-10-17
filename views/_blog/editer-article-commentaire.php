<?php

	require_once('../../include.php');
	
	if(!isset($_SESSION['id'])){
		header('Location: /');
		exit;
	}
	
	if(!isset($_GET['id'])){
		header('Location: blog.php');
		exit;
	}
	
	$get_id_article_commentaire = (int) $_GET['id'];
	
	if($get_id_article_commentaire <= 0){
		header('Location: blog.php');
		exit;
	}
	
	$req = $DB->prepare("SELECT *
		FROM article_commentaire
		WHERE id = ?");
		
	$req->execute([$get_id_article_commentaire]);
	
	$req_article_commentaire = $req->fetch();
	
	if(!isset($req_article_commentaire['id'])){
		header('Location: blog.php');
		exit;
	}
	
	if($req_article_commentaire['id_utilisateur'] <> $_SESSION['id']){
		header('Location: article.php?id=' . $req_article_commentaire['id_article']);
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
				
				$req = $DB->prepare("UPDATE article_commentaire SET contenu = ?, date_modification = ? WHERE id = ?");	
				
				$req->execute([$commentaire, $date_modification, $req_article_commentaire['id']]);
				
				
				header('Location: article.php?id=' . $req_article_commentaire['id_article']);
				exit;
			}			
		}
	}	


?>
<!doctype html>
<html lang="fr">
	<head>
		<?php	
			require_once('../../components/header/head.php');
		?>
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
							<textarea class="form-control" type="text" name="commentaire" placeholder="Votre commentaire ..."><?php if(isset($commentaire)){ echo $commentaire; }else{ echo $req_article_commentaire['contenu']; }?></textarea>
						</div>
						<div class="mb-3">
							<button type="submit" name="modification" class="btn btn-primary">Modifier mon commentaire</button>
						</div>
					</form>
				</div>
			</div>
		</div>

	</body>
    <?php
        require_once('../_footer/footer.php');
        ?>
</html>