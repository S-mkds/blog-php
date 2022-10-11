<?php

	require_once('../../include.php');
	
	$req_sql = "SELECT id, pseudo, avatar
		FROM utilisateur ";
	
	if(isset($_SESSION['id'])){
		$req_sql .= "WHERE id <> ?";
	}
	
	$req = $DB->prepare($req_sql);
	
	if(isset($_SESSION['id'])){
		$req->execute([$_SESSION['id']]);
	}else{
		$req->execute();
	}
	
	$req_membres = $req->fetchAll();

?>
<!doctype html>
<html lang="fr">
	<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../assets/style.css">
    <link rel="icon" href="../../assets/img/logo-blogybye.ico" type="image/x-icon" />
		<title>Membres</title>
	</head>
	<body>
		<?php	
			require_once('../../components/menu/navbar.php');
		?>
		<div class="container">
			<div class="row">
				<div class="col-12">
					<h1>Membres</h1>
				</div>
				<?php
					foreach($req_membres as $rm){
						
						$chemin_avatar = null;
							
						if(isset($rm['avatar'])){
							$chemin_avatar = '../public/avatar/' . $rm['id'] . '/' . $rm['avatar'];
						}else{
							$chemin_avatar = '../public/avatar/defaut/defaut.svg';
						}
						
				?>
				<div class="col-3">
					<div><?= $rm['pseudo'] ?></div>
					<div>
						<img src="<?= $chemin_avatar ?>" class="profil__avatar"/>
					</div>
					<div>
						<a href="_profil/voir-profil.php?id=<?= $rm['id'] ?>">Voir profil</a>
					</div>
				</div>
				<?php		
					}
	 			?>
			</div>
		</div>

	</body>
</html>