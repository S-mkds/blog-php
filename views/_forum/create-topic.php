<?php
session_start();
include('../../db/connexionDB.php'); // Fichier PHP contenant la connexion à votre BDD

if (!isset($_SESSION['id'])){
header('Location: /forum');
exit;
}

	if(!empty($_POST)){
extract($_POST);
$valid = true;

if (isset($_POST['creer-topic'])){
					
			// Récupération de nos différents champs
$titre= htmlentities(trim($titre));
$contenu = htmlentities(trim($contenu));
			$categorie = (int) htmlentities(trim($categorie));
			
if(empty($titre)){
$valid = false;
$er_titre = ("Il faut mettre un titre");
}

if(empty($contenu)){
$valid = false;
$er_contenu = ("Il faut mettre un contenu");
}
			
if(empty($categorie)){
$valid = false;
$er_categorie = "Le mail ne peut pas être vide";

}else{
// On vérifit que la catégorie existe
$verif_cat = $DB->query("SELECT id, titre FROM forum WHERE id = ?",
array($categorie));

$verif_cat = $verif_cat->fetch();

if (!isset($verif_cat['id'])){
$valid = false;
$er_categorie = "Cette catégorie n'existe pas";
}
}

if($valid){
$date_creation = date('Y-m-d H:i:s');

$DB->insert("INSERT INTO topic (id_forum, titre, contenu, date_creation, id_user) VALUES
(?, ?, ?, ?, ?)",
array($categorie, $titre, $contenu, $date_creation, $_SESSION['id']));

header('Location: /forum/' . $categorie);
exit;
}
}
}
?>
<!DOCTYPE html>
<html>
	<head>
		<base href="/"/>
		<meta charset="utf-8"/>
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>
		<title>Créer mon topic</title>
		<link rel="stylesheet" href="../../css/bootstrap.min.css"/>
		<link rel="stylesheet" href="../../css/style.css"/>
	</head>

	<body>
    <?php
    require_once('../../components/navbar.php');
    ?>
		<div class="container">
			<div class="row">	
				
				<div class="col-sm-0 col-md-0 col-lg-0"></div>
				<div class="col-sm-12 col-md-12 col-lg-12">
					<div class="cdr-ins">
				
				<h1>Créer mon topic</h1>
				
				<form method="post">
				
				<?php
				// S'il y a une erreur sur la catégorie alors on affiche
				if (isset($er_categorie)){
				?>
				<div class="er-msg"><?= $er_categorie ?></div>
				<?php
				}
				?>
				<div class="form-group">
					<div class="input-group mb-3">
									<select name="categorie" class="custom-select" id="inputGroupSelect01">
										
										<?php
											if(!isset($categorie)){
											?>
											<option selected>Sélectionner votre catégorie</option>
											<?php
											}else{
											?>
											<option value="<?= $categorie ?>"><?= $verif_cat['titre'] ?></option>
											<?php	
											}
										?>
										
										<?php
											$req_cat = $DB->query("SELECT * FROM forum");
											
											$req_cat = $req_cat->fetchALL();
											
											foreach($req_cat as $rc){
											?>
												<option value="<?= $rc['id'] ?>"><?= $rc['titre'] ?></option>
											<?php
											}	
										?>
									</select>
								</div>
				</div>
				<?php
				if (isset($er_titre)){
				?>
				<div class="er-msg"><?= $er_titre ?></div>
				<?php
				}
				?>
				<div class="form-group">
					<input class="form-control" type="text" placeholder="Votre titre" name="titre" value="<?php if(isset($titre)){ echo $titre; }?>">
				</div>
				<?php
				if (isset($er_contenu)){
				?>
				<div class="er-msg"><?= $er_contenu ?></div>
				<?php
				}
				?>
				<div class="form-group">
					<textarea class="form-control" rows="3" placeholder="Décrivez votre topic" name="contenu"><?php if(isset($contenu)){ echo $contenu; }?></textarea>
				</div>
				
							<div class="form-group">
					<button class="btn btn-primary" type="submit" name="creer-topic">Envoyer</button>
							</div>
				
				</form>
			</div>
				</div>
			</div>
		</div>
 
	<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
		<script src="../js/bootstrap.min.js"></script>
	</body>
</html>