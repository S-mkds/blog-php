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
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.0/font/bootstrap-icons.css">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../assets/style.css">
    <link rel="icon" href="../../assets/img/logo-blogybye.ico" type="image/x-icon" />
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