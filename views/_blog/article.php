<?php

	require_once('../../include.php');
	
	if(!isset($_GET['id'])){
		header('Location: blog.php');
		exit;
	}
	
	$get_id_article = (int) $_GET['id'];
	
	if($get_id_article <= 0){
		header('Location: blog.php');
		exit;
	}
	
	$req = $DB->prepare("SELECT a.*, u.pseudo, b.titre AS titre_blog
		FROM article a
		INNER JOIN utilisateur u ON u.id = a.id_utilisateur
		INNER JOIN blog b ON b.id = a.id_blog
		WHERE a.id = ?
		ORDER BY a.date_creation DESC");
	
	$req->execute([$get_id_article]);
	
	$req_article = $req->fetch();
	
	if(!isset($req_article['id'])){
		header('Location: blog.php');
		exit;
	}
	
	
	$req = $DB->prepare("SELECT ac.*, u.pseudo
		FROM article_commentaire ac
		INNER JOIN utilisateur u ON u.id = ac.id_utilisateur
		WHERE ac.id_article = ?
		ORDER BY ac.date_creation DESC");
		
	$req->execute([$req_article['id']]);
	
	$req_article_commentaires = $req->fetchAll();
	
	if(!empty($_POST)){
		extract($_POST);
		
		$valid = true;	
		
		if(isset($_POST['poster'])){
			
			$commentaire = (String) trim($commentaire);
			
			if(empty($commentaire)){
				$valid = false;
				$err_commentaire = "Ce champ ne peut pas être vide";
			
			}elseif(grapheme_strlen($commentaire) < 4){
				$valid = false;
				$err_commentaire = "Le commentaire doit faire plus de 3 caractères";
			}
			
			if($valid && isset($_SESSION['id'])){
				
				$date_creation = date('Y-m-d H:i:s');
								
				$req = $DB->prepare("INSERT INTO article_commentaire (id_article, id_utilisateur, contenu, date_creation, date_modification) VALUES (?, ?, ?, ?, ?)");	
				
				$req->execute([$req_article['id'], $_SESSION['id'], $commentaire, $date_creation, $date_creation]);
				
				header('Location: article.php?id=' . $req_article['id']);
				exit;
			}
		}elseif(isset($_POST['supp-com'])){
			
			$id_com = (int) $id_com;
			
			if($id_com <= 0){
				$valid = false;
				$err_commentaire = "Impossible de supprimer ce commentaire";
			
			}else{
				$req = $DB->prepare("SELECT id 
					FROM article_commentaire
					WHERE id = ? AND id_utilisateur = ?");
					
				$req->execute([$id_com, $_SESSION['id']]);
				
				$req_verif_com = $req->fetch();
				
				if(!isset($req_verif_com['id'])){
					$valid = false;
					$err_commentaire = "Impossible de supprimer ce commentaire";
				}
			}

			if($valid && isset($_SESSION['id'])){
				
				$req = $DB->prepare("DELETE FROM article_commentaire WHERE id = ?");
				$req->execute([$req_verif_com['id']]);
				
				header('Location: article.php?id=' . $req_article['id']);
				exit;	
			}
	
		}elseif(isset($_POST['supp-article'])){

			if($_SESSION['id'] <> $req_article['id_utilisateur']){
				$valid = false;
				$err_article = "Impossible de supprimer ce article";
			}

			if($valid && isset($_SESSION['id'])){
				
				$req = $DB->prepare("DELETE FROM article_commentaire WHERE id_article = ?");
				$req->execute([$req_article['id']]);
				
				$req = $DB->prepare("DELETE FROM article WHERE id = ?");
				$req->execute([$req_article['id']]);
				
				header('Location: blog.php');
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
		<title><?= $req_article['titre'] ?></title>
	</head>
	<body>
		<?php	
			require_once('../../components/menu/navbar.php');
		?>
		<div class="container">
			<div class="row">
				<div class="col-2"></div>
				<div class="col-8">
					<div class="topic__body">
						<h1 class="topic__body__h1"><?= $req_article['titre'] ?></h1>
						<?php if(isset($err_article)){ echo '<div>' . $err_article . '</div>'; }?>
						<?php
							if(isset($_SESSION['id']) && $_SESSION['id'] == $req_article['id_utilisateur']){
						?>
						<div class="topic__body__action__btn">
							<div>
								<form method="post">
									<button type="submit" name="supp-article" class="topic__action__btn">
										<i class="bi bi-trash2 btn__trash"></i> Supprimer mon poste
									</button>
								</form>
							</div>
							<div>
								<a href="editer-article.php?id=<?= $req_article['id'] ?>" class="topic__action__btn">
									<i class="bi bi-pencil btn__edit"></i> Éditer mon blog
								</a>
							</div>
						</div>
						<?php
							}
						?>
						<div class="topic__body__contenu"><?= nl2br($req_article['contenu']) ?></div>
						<div class="topic__footer">
							<div>De <?= $req_article['pseudo'] ?></div>
							<div class="topic__footer__cat"><?= $req_article['titre_blog'] ?></div>
							<div>Le <?= date_format(date_create($req_article['date_creation']), 'd/m/Y à H:i') ?></div>
							<?php
								if($req_article['date_creation'] < $req_article['date_modification']){
							?>
							<div>Modifié le <?= date_format(date_create($req_article['date_modification']), 'd/m/Y à H:i') ?></div>
							<?php	
								}
							?>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="container">
			<div class="row">
				<div class="col-2"></div>
				<div class="col-8">
					<div class="topic__body">
						<h1 class="topic__body__h1">Commentaires</h1>
						<div class="topic__body__zone__commentaire">
							<form method="post">
								<div class="mb-3">
									<?php 
										if(isset($err_commentaire)){
									?>
										<div class="topic__zone_commentaire__erreur"><?= $err_commentaire ?></div>
									<?php
										}
									?>
									<label class="form-label">Votre commentaire</label>
									<textarea class="topic__com__body__textarea" type="text" name="commentaire" placeholder="Votre commentaire ..."><?php if(isset($commentaire)){ echo $commentaire; }?></textarea>
								</div>
								<div class="topic__com__footer__btn">
									<button type="submit" name="poster" class="topic__action__btn">
										<i class="bi bi-send btn__send"></i> Poster
									</button>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="container">
			<div class="row">
				<?php
					foreach($req_article_commentaires as $rtc){
						
				?>
				<div class="col-2"></div>
				<div class="col-8">
					<div class="topic__commentaire__body">
						<div class="topic__commentaire__title">
							<div><?= $rtc['pseudo'] ?></div>
						</div>
						<?php
							if(isset($_SESSION['id']) && $_SESSION['id'] == $rtc['id_utilisateur']){
						?>
						<div class="topic__body__action__btn">
							<div>
								<form method="post">
									<button type="submit" name="supp-com" class="topic__action__btn">
										<i class="bi bi-trash2 btn__trash"></i> Supprimer mon commentaire
									</button>
									<input type="hidden" name="id_com" value="<?= $rtc['id'] ?>"/>
								</form>
							</div>
							<div>
								<a href="editer-article-commentaire.php?id=<?= $rtc['id'] ?>" class="topic__action__btn">
									<i class="bi bi-pencil btn__edit"></i> Éditer mon commentaire
								</a>
							</div>
						</div>
						<?php
							}
						?>
						<div class="topic__body__contenu"><?= nl2br($rtc['contenu']) ?></div>
						<div class="topic__footer">
							<div>Le <?= date_format(date_create($rtc['date_creation']), 'd/m/Y à H:i') ?></div>
						<?php
							if($rtc['date_creation'] < $rtc['date_modification']){
						?>
							<div>Modifié le <?= date_format(date_create($rtc['date_modification']), 'd/m/Y à H:i') ?></div>
						<?php	
							}
						?>
						</div>
					</div>
				</div>
				<div class="col-2"></div>
				<?php
					}
				?>
			</div>
		</div>

	</body>
	<?php
        require_once('../_footer/footer.php');
        ?>
</html>