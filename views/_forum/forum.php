<?php

	require_once('../../include.php');
	
	
	$req = $DB->prepare("SELECT * 
		FROM forum
		ORDER BY ordre");
	
	$req->execute();
	
	$req_forum = $req->fetchAll();

?>
<!doctype html>
<html lang="fr">
	<head>
		<?php	
			require_once('../../components/header/head.php');
		?>
		<title>Forum</title>
	</head>
	<body>
		<?php	
			require_once('../../components/menu/navbar.php');
		?>
		<div class="container">
			<div class="row">
				<div class="col-2"></div>
				<div class="col-8">
					<div class="forum__body">
						<h1 class="forum__h1">Forum</h1>
						<div class="forum__body__btn">
							<a href="creer-topic.php" class="forum__btn__create">
								<i class="bi bi-plus btn__create"></i> Créer un topic
							</a>
						</div>
						<?php
							foreach($req_forum as $rf){
								
								$req = $DB->prepare("SELECT COUNT(id) AS NbCommentaire
									FROM topic
									WHERE id_forum = ?");
								
								$req->execute([$rf['id']]);
								
								$req_nb_topic = $req->fetch();
								
								$nb_topic = $req_nb_topic['NbCommentaire'];
								
								if($nb_topic > 1){
									$lib_nb_topic = "Il y a " . $nb_topic . ' topics';
								}else{
									$lib_nb_topic = "Il y a " . $nb_topic . ' topic';
								}
						?>
						<a href="_forum/liste-topics.php?id=<?= $rf['id'] ?>" class="list__link__forum">
							<div class="list__cat__forum">
								<div><?= $rf['titre'] ?></div>
								<div class="list__footer__forum">
									<div>
										<?= $lib_nb_topic ?>
									</div>
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
		<?php	
			require_once('../_footer/footer.php');
		?>
	</body>
</html>