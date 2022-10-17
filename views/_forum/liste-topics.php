<?php

	require_once('../../include.php');
	
	
	if(!isset($_GET['id'])){
		header('Location: forum.php');
		exit;
	}
	
	$get_id_forum = (int) $_GET['id'];
	
	if($get_id_forum <= 0){
		header('Location: forum.php');
		exit;
	}
	
	$req = $DB->prepare("SELECT *
		FROM forum 
		WHERE id = ?");
	
	$req->execute([$get_id_forum]);
	
	$req_forum = $req->fetch();
	
	$req = $DB->prepare("SELECT T.*, U.pseudo
		FROM topic T
		INNER JOIN utilisateur U ON U.id = T.id_utilisateur
		WHERE T.id_forum = ?
		ORDER BY T.date_creation DESC");
	
	$req->execute([$get_id_forum]);
	
	$req_liste_topics = $req->fetchAll();

?>
<!doctype html>
<html lang="fr">
	<head>
		<?php	
			require_once('../../components/header/head.php');
		?>
		<title>Forum - <?= $req_forum['titre'] ?></title>
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
						<h1 class="list__topic__h1"><?= $req_forum['titre'] ?></h1>
						<?php
							foreach($req_liste_topics as $rlt){
								
								$req = $DB->prepare("SELECT COUNT(id) AS NbCommentaire
									FROM topic_commentaire
									WHERE id_topic = ?");
								
								$req->execute([$rlt['id']]);
								
								$req_nb_commentaire = $req->fetch();
								
								$nb_commentaire = $req_nb_commentaire['NbCommentaire'];
								
						?>

					
						<a href="topic.php?id=<?= $rlt['id'] ?>" class="list__topic__link">
							<div class="list__topic__sujet">
								<div><?= $rlt['titre'] ?></div>
								<div class="list__topic__footer">
									<div><?= $rlt['pseudo'] ?></div>
									<div><i class="bi bi-chat"></i> <?= $nb_commentaire ?></div>
									<div>Le <?= date_format(date_create($rlt['date_creation']), 'd/m/Y à H:i') ?></div>
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