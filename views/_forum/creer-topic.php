<?php

	require_once('../../include.php');
	
	if(!isset($_SESSION['id'])){
		header('Location: /');
		exit;
	}
	
	$req = $DB->prepare("SELECT id, titre
		FROM forum");
		
	$req->execute();
	
	$req_forum = $req->fetchAll();
	
	if(!empty($_POST)){
		extract($_POST);
		
		$valid = true;	
		
		if(isset($_POST['creation'])){
			
			$titre = (String) ucfirst(trim($titre));
			$categorie = (int) $categorie;
			$contenu = (String) trim($contenu);
			
			if(empty($titre)){
				$valid = false;
				$err_titre = "Ce champ ne peut pas être vide";
			
			}elseif(grapheme_strlen($titre) < 4){
				$valid = false;
				$err_titre = "Le titre doit faire plus de 3 caractères";
			}elseif(grapheme_strlen($titre) > 50){
				$valid = false;
				$err_titre = "Le titre doit faire moins de 51 caractères (" . grapheme_strlen($titre) . "/50)";
			}
			
			$req = $DB->prepare("SELECT id, titre
				FROM forum
				WHERE id = ?");
				
			$req->execute([$categorie]);
			
			$req_forum_verif = $req->fetch();
			
			if(!isset($req_forum_verif['id'])){
				$valid = false;
				$categorie = null;
				$err_cat = "Cette catégorie n'existe pas";
			}
			
			if(empty($contenu)){
				$valid = false;
				$err_contenu = "Ce champ ne peut pas être vide";
			
			}elseif(grapheme_strlen($contenu) < 4){
				$valid = false;
				$err_contenu = "Le contenu doit faire plus de 3 caractères";
			}
				
			if($valid){
				
				$date_creation = date('Y-m-d H:i:s');
				
				$req = $DB->prepare("INSERT INTO topic (id_forum, titre, contenu, date_creation, date_modification, id_utilisateur) VALUES (?, ?, ?, ?, ?, ?)");	
				
				$req->execute([$req_forum_verif['id'], $titre, $contenu, $date_creation, $date_creation, $_SESSION['id']]);
				
				$UID = (int) $DB->lastInsertId();
				
				if($UID >= 0){
					header('Location: topic.php?id=' . $UID);	
				}else{
					header('Location: forum.php');	
				}
				
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
		<title>Créer un topic</title>
	</head>
	<body>

		<?php	
			require_once('../../components/menu/navbar.php');
		?>
		<div class="container">
			<div class="row">
				<div class="col-3"></div>
				<div class="col-6">
					<h1>Créer un topic</h1>
					<form method="post">
						<div class="mb-3">
							<?php if(isset($err_titre)){ echo '<div>' . $err_titre . '</div>'; }?>
							<label class="form-label">Titre</label>
							<input class="form-control" type="text" name="titre" value="<?php if(isset($titre)){ echo $titre; }?>" placeholder="Titre"/>
						</div>
						<div class="mb-3">
							<?php if(isset($err_cat)){ echo '<div>' . $err_cat . '</div>'; }?>
							<label class="form-label">Catégorie</label>
							<select name="categorie" class="form-control">
								<?php
									if(isset($categorie)){
								?>
								<option value="<?= $req_forum_verif['id'] ?>"><?= $req_forum_verif['titre'] ?></option>
								<?php
									}else{
								?>
								<option hidden>Choisissez votre catégorie</option>
								<?php
									}
								?>
								<?php
									foreach($req_forum as $rf){
								?>
								<option value="<?= $rf['id'] ?>"><?= $rf['titre'] ?></option>
								<?php		
									}
								?>
							</select>
						</div>
						<div class="mb-3">
							<?php if(isset($err_contenu)){ echo '<div>' . $err_contenu . '</div>'; }?>
							<label class="form-label">Contenu</label>
							<textarea class="form-control" type="text" name="contenu" placeholder="Votre topic ..."><?php if(isset($contenu)){ echo $contenu; }?></textarea>
						</div>
						<div class="mb-3">
							<button type="submit" name="creation" class="btn btn-primary">Créer mon topic</button>
						</div>
					</form>
				</div>
			</div>
		</div>

	</body>
</html>