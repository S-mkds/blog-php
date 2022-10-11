<?php

	require_once('../../include.php');

	if(!isset($_SESSION['id'])){
		header('Location: /');
		exit;
	}
	
	if(!empty($_POST)){
		extract($_POST);
		
		$valid = true;
		
		if(isset($_POST['modifier'])){
			
			if(isset($_FILES['file']) && !empty($_FILES['file']['name'])){
				$filename 		= $_FILES['file']['tmp_name'];
				$filesize		= $_FILES['file']['size'];
				$ext 			= $_FILES["file"]["type"];
				$size 			= filesize($_FILES['file']['tmp_name']);
				
				
				$tailleMax = "5242880"; // 5mo
				
				if($size <= $tailleMax){
					
					$extensionsValides = array('jpg', 'png', 'jpeg');
					
					$extensionUpload = strtolower(substr(strrchr($_FILES['file']['name'], '.'), 1));
					
					if(in_array($extensionUpload, $extensionsValides)){
						$dossier = '../../assets/public/avatar/' . $_SESSION['id'] . '/';
						
						if(!is_dir($dossier)){
							mkdir($dossier);
						}
						
						$nom = md5(uniqid(rand(), true));
						
						$chemin = $dossier . $nom . '.' . $extensionUpload;
						
						//$resultat = move_uploaded_file($_FILES['file']['tmp_name'], $chemin);
														
						if(in_array($ext, array("image/gif", "image/jpeg", "image/jpg", "image/pjpeg", "image/x-png", "image/png"))){
							
							list($width1, $height1, $typeb, $attr) = getimagesize($filename);
							
							if($ext == 'image/jpeg' || $ext == 'image/jpg') {
								$src = imagecreatefromjpeg($filename);
							}elseif ($ext == 'image/gif') {
								$src = imagecreatefromgif($filename);
							}elseif(($ext=='image/png')||($ext=='image/x-png')){
								$src = imagecreatefrompng($filename);
						 	}
				
							$newwidth1 = $width1;
					
							$newheight1 =$height1; //($height1 * $newwidth1) / ($width1);
							
							$tmp = imagecreatetruecolor($newwidth1, $newheight1);
							imagealphablending($tmp, false);
							imagesavealpha($tmp, true);
					
							imagecopyresampled($tmp, $src, 0, 0, 0, 0, $newwidth1, $newheight1, $width1, $height1);
							imagedestroy($src);
													
							if ($ext == 'image/jpeg' || $ext == 'image/jpg') {
								header("Content-type: image/jpeg");
								imagejpeg($tmp, $chemin, 75);
								header("Content-type: image/gif");
							}else if ($ext == 'image/gif') {
								imagegif($tmp, $chemin, 75);
							}else if(($ext=='image/png')||($ext=='image/x-png')){
								header("Content-type: image/png");
								imagepng($tmp, $chemin, 0);
							}
							
							imagedestroy($tmp);
							
							$req = $DB->prepare("UPDATE utilisateur SET avatar = ? WHERE id = ?");
													
							$req->execute([($nom . '.' . $extensionUpload), $_SESSION['id']]);
							
							if(file_exists($dossier . $_SESSION['avatar']) && isset($_SESSION['avatar'])){
								unlink($dossier . $_SESSION['avatar']);
							}
							
							$_SESSION['avatar'] = ($nom . '.' . $extensionUpload);
															
							header('Location: profil.php');
							exit;
							
						}else{
							$err_avatar = "Impossible d'importer votre fichier";	
						}
					}else{
						$err_avatar = "L'extension de votre image n'est pas valide";	
					}
				}else{
					$err_avatar = "L'image doit faire 5mo ou moins";	
				}
			}else{
				$err_avatar = "Ceci n'est pas un fichier valide";
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
		<title>Modifier mon avatar</title>
	</head>
	<body>
		<?php	
			require_once('../../components/menu/navbar.php');
		?>
		<div class="container">
			<div class="row">
				<div class="col-3"></div>
				<div class="col-6">
					<h1>Modifier mon avatar</h1>
					
					<form method="post" enctype="multipart/form-data">
						<div class="mb-3">
							<?php if(isset($err_avatar)){ echo '<div>' . $err_avatar . '</div>'; }?>
							<input class="form-control" type="file" name="file"/>
						</div>
						<div class="mb-3">
							<input class="btn btn-primary" type="submit" name="modifier" value="Modifier"/>
						</div>
					</form>
				</div>
			</div>
		</div>

	</body>
</html>