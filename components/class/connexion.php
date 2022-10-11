<?php
	class Connexion {
		
		private $valid;
		
		private $err_pseudo;
		private $err_password;
		
		public function verification_connexion($pseudo, $password){
					
			global $DB;	
			
			$pseudo = ucfirst(trim($pseudo));
			$password = trim($password);
			
			$this->valid = (boolean) true;
			
			if(empty($pseudo)){
				$this->valid = false;
				$this->err_pseudo = "Ce champ ne peut pas être vide";
			
			}
			
			if(empty($password)){
				$this->valid = false;
				$this->err_password = "Ce champ ne peut pas être vide";
			}
			
			if($this->valid){
				$req = $DB->prepare("SELECT mdp
					FROM utilisateur
					WHERE pseudo = ?");
					
				$req->execute(array($pseudo));
				
				$req = $req->fetch();
				
				if(isset($req['mdp'])){
					if(!password_verify($password, $req['mdp'])) {
						$this->valid = false;
						$this->err_pseudo = "La combinaison du pseudo / mot passe est incorrecte";
					}
					
				}else{
					$this->valid = false;
					$this->err_pseudo = "La combinaison du pseudo / mot passe est incorrecte";
				}
			}
			
			if($this->valid){
				
				$req = $DB->prepare("SELECT *
					FROM utilisateur
					WHERE pseudo = ?");
					
				$req->execute(array($pseudo));
				
				$req_user = $req->fetch();
				
				if(isset($req_user['id'])){
					$date_connexion = date('Y-m-d H:i:s');
									
					$req = $DB->prepare("UPDATE utilisateur SET date_connexion = ? WHERE id = ?");
					$req->execute(array($date_connexion, $req_user['id']));
					
					$_SESSION['id'] = $req_user['id'];
					$_SESSION['pseudo'] = $req_user['pseudo'];
					$_SESSION['mail'] = $req_user['mail'];
					$_SESSION['role'] = $req_user['role'];
					$_SESSION['avatar'] = $req_user['avatar'];
					
					header('Location: /');
					exit;	
				}else{
					$this->valid = false;
					$this->err_pseudo = "La combinaison du pseudo / mot passe est incorrecte";
				}
			}
			
			return [$this->err_pseudo, $this->err_password];
			
		}
	}
?>