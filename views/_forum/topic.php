<?php

	require_once('../../include.php');
	
	if(!isset($_GET['id'])){
		header('Location: forum.php');
		exit;
	}
	
	$get_id_topic = (int) $_GET['id'];
	
	if($get_id_topic <= 0){
		header('Location: forum.php');
		exit;
	}
	
	$req = $DB->prepare("SELECT t.*, u.pseudo, f.titre AS titre_forum
		FROM topic t
		INNER JOIN utilisateur u ON u.id = t.id_utilisateur
		INNER JOIN forum f ON f.id = t.id_forum
		WHERE t.id = ?
		ORDER BY t.date_creation DESC");
	
	$req->execute([$get_id_topic]);
	
	$req_topic = $req->fetch();
	
	if(!isset($req_topic['id'])){
		header('Location: forum.php');
		exit;
	}
	
	
	$req = $DB->prepare("SELECT tc.*, u.pseudo
		FROM topic_commentaire tc
		INNER JOIN utilisateur u ON u.id = tc.id_utilisateur
		WHERE tc.id_topic = ?
		ORDER BY tc.date_creation DESC");
		
	$req->execute([$req_topic['id']]);
	
	$req_topic_commentaires = $req->fetchAll();
	
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
								
				$req = $DB->prepare("INSERT INTO topic_commentaire (id_topic, id_utilisateur, contenu, date_creation, date_modification) VALUES (?, ?, ?, ?, ?)");	
				
				$req->execute([$req_topic['id'], $_SESSION['id'], $commentaire, $date_creation, $date_creation]);
				
				header('Location: topic.php?id=' . $req_topic['id']);
				exit;
			}
		}elseif(isset($_POST['supp-com'])){
			
			$id_com = (int) $id_com;
			
			if($id_com <= 0){
				$valid = false;
				$err_commentaire = "Impossible de supprimer ce commentaire";
			
			}else{
				$req = $DB->prepare("SELECT id 
					FROM topic_commentaire
					WHERE id = ? AND id_utilisateur = ?");
					
				$req->execute([$id_com, $_SESSION['id']]);
				
				$req_verif_com = $req->fetch();
				
				if(!isset($req_verif_com['id'])){
					$valid = false;
					$err_commentaire = "Impossible de supprimer ce commentaire";
				}
			}

			if($valid && isset($_SESSION['id'])){
				
				$req = $DB->prepare("DELETE FROM topic_commentaire WHERE id = ?");
				$req->execute([$req_verif_com['id']]);
				
				header('Location: topic.php?id=' . $req_topic['id']);
				exit;	
			}
	
		}elseif(isset($_POST['supp-topic'])){

			if($_SESSION['id'] <> $req_topic['id_utilisateur']){
				$valid = false;
				$err_topic = "Impossible de supprimer ce topic";
			}

			if($valid && isset($_SESSION['id'])){
				
				$req = $DB->prepare("DELETE FROM topic_commentaire WHERE id_topic = ?");
				$req->execute([$req_topic['id']]);
				
				$req = $DB->prepare("DELETE FROM topic WHERE id = ?");
				$req->execute([$req_topic['id']]);
				
				header('Location: forum.php');
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
		<title><?= $req_topic['titre'] ?></title>
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
						<h1 class="topic__body__h1"><?= $req_topic['titre'] ?></h1>
						<?php if(isset($err_topic)){ echo '<div>' . $err_topic . '</div>'; }?>
						<?php
							if(isset($_SESSION['id']) && $_SESSION['id'] == $req_topic['id_utilisateur']){
						?>
						<div class="topic__body__action__btn">
							<div>
								<form method="post">
									<button type="submit" name="supp-topic" class="topic__action__btn">
										<i class="bi bi-trash2 btn__trash"></i> Supprimer mon topic
									</button>
								</form>
							</div>
							<div>
								<a href="_forum/editer-topic.php?id=<?= $req_topic['id'] ?>" class="topic__action__btn">
									<i class="bi bi-pencil btn__edit"></i> Éditer mon topic
								</a>
							</div>
						</div>
						<?php
							}
						?>
						<div class="topic__body__contenu"><?= nl2br($req_topic['contenu']) ?></div>
						<div class="topic__footer">
							<div>De <?= $req_topic['pseudo'] ?></div>
							<div class="topic__footer__cat"><?= $req_topic['titre_forum'] ?></div>
							<div>Le <?= date_format(date_create($req_topic['date_creation']), 'd/m/Y à H:i') ?></div>
							<?php
								if($req_topic['date_creation'] < $req_topic['date_modification']){
							?>
							<div>Modifié le <?= date_format(date_create($req_topic['date_modification']), 'd/m/Y à H:i') ?></div>
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
					foreach($req_topic_commentaires as $rtc){
						
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
								<a href="_forum/editer-commentaire.php?id=<?= $rtc['id'] ?>" class="topic__action__btn">
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
</html>