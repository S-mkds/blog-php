<?php

	require_once('../../include.php');
	
	
	$req = $DB->prepare("SELECT * 
		FROM blog
		ORDER BY ordre");
	
	$req->execute();
	
	$req_blog = $req->fetchAll();

?>
<!doctype html>
<html lang="fr">
	<head>
		<?php	
			require_once('../../components/header/head.php');
		?>
		<title>Blog</title>
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
						<h1 class="forum__h1">Blog</h1>
						<div class="forum__body__btn">
							<a href="create-blog.php" class="forum__btn__create">
								<i class="bi bi-plus btn__create"></i> Crée un blog
							</a>
						</div>
						<?php
							foreach($req_blog as $rb){
								
								$req = $DB->prepare("SELECT COUNT(id) AS NbCommentaire
									FROM article
									WHERE id_blog = ?");
								
								$req->execute([$rb['id']]);
								
								$req_nb_article = $req->fetch();
								
								$nb_article = $req_nb_article['NbCommentaire'];
								
								if($nb_article > 1){
									$lib_nb_article = "Il y a " . $nb_article . ' articles';
								}else{
									$lib_nb_article = "Il y a " . $nb_article . ' article';
								}
						?>
						<diV class="topics_list" >
						<a href="liste-blog.php?id=<?= $rb['id'] ?>" class="list__link__forum">
							<div class="list__cat__forum">
								<div><?= $rb['titre'] ?></div>
								<div class="list__footer__forum">
									<div>
										<?= $lib_nb_article ?>
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
		</div>

	</body>

</html>