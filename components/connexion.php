<?php

	require_once('../include.php');
	
	if(isset($_SESSION['id'])){
		header('Location: /');
		exit;
	}
	
	if(!empty($_POST)){
		extract($_POST);
		
		if(isset($_POST['connexion'])){
			[$err_pseudo, $err_password] = $_Connexion->verification_connexion($pseudo, $password);
		}
	}	


?>

<!doctype html>
<html lang="fr">
	    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
        <link rel="stylesheet" href="../assets/style.css">
        <link rel="shortcut icon" href="favicon.ico" type="image/x-icon" />
        <link rel="icon" href="../assets/img/logo-blogybye.ico" type="image/x-icon" />
		<title>Connexion</title>
	</head>
	<body>
		<?php	
			require_once('menu/navbar.php');
		?>
		<div class="container">
			<div class="row">
				<div class="col-3"></div>
				<div class="col-6">
					<h1>Connexion</h1>
					<form method="post">
						<div class="mb-3">
							<?php if(isset($err_pseudo)){ echo '<div>' . $err_pseudo . '</div>'; }?>
							<label class="form-label">Pseudo</label>
							<input class="form-control" type="text" name="pseudo" value="<?php if(isset($pseudo)){ echo $pseudo; }?>" placeholder="Pseudo"/>
						</div>
						<div class="mb-3">
							<?php if(isset($err_password)){ echo '<div>' . $err_password . '</div>'; }?>
							<label class="form-label">Mot de passe</label>
							<input class="form-control" type="password" name="password" value="<?php if(isset($password)){ echo $password; }?>" placeholder="Mot de passe"/>
						</div>
						<div class="mb-3">
							<button type="submit" name="connexion" class="btn btn-primary">Se connecter</button>
						</div>
					</form>
				</div>
			</div>
		</div>

	</body>
</html>