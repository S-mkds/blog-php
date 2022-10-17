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
	
	$get_id_article = (int) $_GET['id'];
	
	if($get_id_article <= 0){
		header('Location: blog.php');
		exit;
	}
	
	$req = $DB->prepare("SELECT a.*, b.titre AS titre_blog
		FROM article a
		INNER JOIN blog b ON b.id = a.id_blog
		WHERE a.id = ?");
		
	$req->execute([$get_id_article]);
	
	$req_article = $req->fetch();
	
	if(!isset($req_article['id'])){
		header('Location: blog.php');
		exit;
	}
	
	if($req_article['id_utilisateur'] <> $_SESSION['id']){
		header('Location: article.php?id=' . $req_article['id']);
		exit;
	}
	
	
	$req = $DB->prepare("SELECT id, titre
		FROM blog");
		
	$req->execute();
	
	$req_blog = $req->fetchAll();
	
	if(!empty($_POST)){
		extract($_POST);
		
		$valid = true;	
		
		if(isset($_POST['modification'])){
			
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
				$err_titre = "Le titre doit faire moins de 51 caractères (" . grapheme_strlen($titre) . "/51)";
			}
			
			$req = $DB->prepare("SELECT id, titre
				FROM blog
				WHERE id = ?");
				
			$req->execute([$categorie]);
			
			$req_blog_verif = $req->fetch();
			
			if(!isset($req_blog_verif['id'])){
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
				
				$date_modification = date('Y-m-d H:i:s');
				
				$req = $DB->prepare("UPDATE article SET id_blog = ?, titre = ?, contenu = ?, date_modification = ? WHERE id = ?");	
				
				$req->execute([$req_blog_verif['id'], $titre, $contenu, $date_modification, $req_article['id']]);
				
				
				header('Location: article.php?id=' . $req_article['id']);
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
		<title>Éditer mon article</title>
	</head>
	<body>

		<?php	
			require_once('../../components/menu/navbar.php');
		?>
		<div class="container">
			<div class="row">
				<div class="col-3"></div>
				<div class="col-6">
					<h1>Éditer mon article</h1>
					<form method="post">
						<div class="mb-3">
							<?php if(isset($err_titre)){ echo '<div>' . $err_titre . '</div>'; }?>
							<label class="form-label">Titre</label>
							<input class="form-control" type="text" name="titre" value="<?php if(isset($titre)){ echo $titre; }else{ echo $req_article['titre']; }?>" placeholder="Titre"/>
						</div>
						<div class="mb-3">
							<?php if(isset($err_cat)){ echo '<div>' . $err_cat . '</div>'; }?>
							<label class="form-label">Catégorie</label>
							<select name="categorie" class="form-control">
								<?php
									if(isset($categorie)){
								?>
								<option value="<?= $req_blog_verif['id'] ?>"><?= $req_blog_verif['titre'] ?></option>
								<?php
									}elseif(isset($req_article['id_blog'])){
								?>
								<option value="<?= $req_article['id_blog'] ?>"><?= $req_article['titre_blog'] ?></option>
								<?php
									}else{
								?>
								<option hidden>Choisissez votre catégorie</option>
								<?php
									}
								?>
								<?php
									foreach($req_blog as $rb){
								?>
								<option value="<?= $rb['id'] ?>"><?= $rb['titre'] ?></option>
								<?php		
									}
								?>
							</select>
						</div>
						<div class="mb-3">
							<?php if(isset($err_contenu)){ echo '<div>' . $err_contenu . '</div>'; }?>
							<label class="form-label">Contenu</label>
							<textarea class="form-control" type="text" name="contenu" placeholder="Votre article ..."><?php if(isset($contenu)){ echo $contenu; }else{ echo $req_article['contenu']; }?></textarea>
						</div>
						<div class="mb-3">
							<button type="submit" name="modification" class="btn btn-primary">Modifier mon article</button>
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