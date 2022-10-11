<?php
	class Inscription {
		
		private $valid;
		
		private $err_pseudo;
		private $err_mail;
		private $err_password;
		
		public function verification_inscription($pseudo, $mail, $confmail, $password, $confpassword){
			
			global $DB;
			
			// Variables d'entrées
			$pseudo = (String) ucfirst(trim($pseudo));
			$mail = (String) trim($mail);
			$confmail = (String) trim($confmail);
			$password = (String) trim($password);
			$confpassword = (String) trim($confpassword);
			
			// Variables déclarés
			$this->err_pseudo = (String) '';
			$this->err_mail = (String) '';
			$this->err_password = (String) '';
			$this->valid = (boolean) true;

			$this->verification_pseudo($pseudo);			
			
			$this->verification_mail($mail, $confmail);
			
			$this->verification_password($password, $confpassword);			
			
			if($this->valid){
				
				$crytp_password = password_hash($password, PASSWORD_ARGON2ID);
				
				$date_creation = date('Y-m-d H:i:s');
				
				$req = $DB->prepare("INSERT INTO utilisateur(pseudo, mail, mdp, date_creation, date_connexion) VALUES (?, ?, ?, ?, ?)");
				$req->execute(array($pseudo, $mail, $crytp_password, $date_creation, $date_creation));
				
				header('Location: connexion.php');
				exit;
			}
			
			return [$this->err_pseudo, $this->err_mail, $this->err_password];
			
		}
		
		private function verification_pseudo($pseudo){
			
			global $DB;
			
			if(empty($pseudo)){
				$this->valid = false;
				$this->err_pseudo = "Ce champ ne peut pas être vide";
			
			}elseif(grapheme_strlen($pseudo) < 4){
				$this->valid = false;
				$this->err_pseudo = "Le pseudo doit faire plus de 3 caractères";
			}elseif(grapheme_strlen($pseudo) > 25){
				$this->valid = false;
				$this->err_pseudo = "Le pseudo doit faire moins de 26 caractères (" . grapheme_strlen($pseudo) . "/25)";
			}else{
				$req = $DB->prepare("SELECT id
					FROM utilisateur
					WHERE pseudo = ?");
					
				$req->execute(array($pseudo));
				
				$req = $req->fetch();
				
				if(isset($req['id'])){
					$this->valid = false;
					$this->err_pseudo = "Ce pseudo est déjà pris";
				}
			}		
		}
		
		private function verification_mail($mail, $confmail){
			
			global $DB;
			
			if(empty($mail)){
				$this->valid = false;
				$this->err_mail = "Ce champ ne peut pas être vide";
			
			}elseif(!filter_var($mail, FILTER_VALIDATE_EMAIL)){
				$this->valid = false;
				$this->err_mail = "Format invalide pour ce mail";
				
			}elseif($mail <> $confmail){
				$this->valid = false;
				$this->err_mail = "Le mail est différent de la confirmation";
				
			}else{
				$req = $DB->prepare("SELECT id
					FROM utilisateur
					WHERE mail = ?");
					
				$req->execute(array($mail));
				
				$req = $req->fetch();
				
				if(isset($req['id'])){
					$this->valid = false;
					$this->err_mail = "Ce mail est déjà pris";
				}
			}
		}
		
		private function verification_password($password, $confpassword){
			if(empty($password)){
				$this->valid = false;
				$this->err_password = "Ce champ ne peut pas être vide";
			
			}elseif($password <> $confpassword){
				$this->valid = false;
				$this->err_password = "Le mot de passe est différent de la confirmation";
			}
		}
	}