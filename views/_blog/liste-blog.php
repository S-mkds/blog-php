<?php

	require_once('../../include.php');
	
	
	if(!isset($_GET['id'])){
		header('Location: blog.php');
		exit;
	}
	
	$get_id_blog = (int) $_GET['id'];
	
	if($get_id_blog <= 0){
		header('Location: blog.php');
		exit;
	}
	
	$req = $DB->prepare("SELECT *
		FROM blog 
		WHERE id = ?");
	
	$req->execute([$get_id_blog]);
	
	$req_blog = $req->fetch();
	
	$req = $DB->prepare("SELECT A.*, U.pseudo
		FROM article A
		INNER JOIN utilisateur U ON U.id = A.id_utilisateur
		WHERE A.id_blog = ?
		ORDER BY A.date_creation DESC");
	
	$req->execute([$get_id_blog]);
	
	$req_liste_articles = $req->fetchAll();

?>
<!doctype html>
<html lang="fr">
	<head>
		<?php	
			require_once('../../components/header/head.php');
		?>
		<title>blog - <?= $req_blog['titre'] ?></title>
	</head>
	<body>
		<?php	
			require_once('../../components/menu/navbar.php');
		?>
		<div class="container">
			<div class="row">
				<div class="col-2"></div>
				<div class="col-8">
					<div class="list__topic__body">
						<h1 class="list__topic__h1"><?= $req_blog['titre'] ?></h1>
						<?php
							foreach($req_liste_articles as $rla){
								
								$req = $DB->prepare("SELECT COUNT(id) AS NbCommentaire
									FROM article_commentaire
									WHERE id_article = ?");
								
								$req->execute([$rla['id']]);
								
								$req_nb_commentaire = $req->fetch();
								
								$nb_commentaire = $req_nb_commentaire['NbCommentaire'];
								
						?>

					
						<a href="article.php?id=<?= $rla['id'] ?>" class="list__topic__link">
							<div class="list__topic__sujet">
								<div><?= $rla['titre'] ?></div>
								<div class="list__topic__footer">
									<div><?= $rla['pseudo'] ?></div>
									<div><i class="bi bi-chat"></i> <?= $nb_commentaire ?></div>
									<div>Le <?= date_format(date_create($rla['date_creation']), 'd/m/Y à H:i') ?></div>
								</div>
							</div>
							</a>
						<?php		
							}
						?>
					

					</div>
				</div>
			</div>
		</div>

	</body>
	<?php
        require_once('../_footer/footer.php');
        ?>
</html>