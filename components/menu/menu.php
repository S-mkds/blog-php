<nav class="navbar navbar-expand-lg navbar-light bg-light">
	<div class="container-fluid">
		<a class="navbar-brand" href="/">Accueil</a>
		<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>
		<div class="collapse navbar-collapse" id="navbarNavAltMarkup">
			<div class="navbar-nav">
				<a class="nav-link" href="_forum/forum.php">Forum</a>
				<a class="nav-link" href="_profil/membres.php">Membres</a>
				<?php
					if(!isset($_SESSION['id'])){
				?>
				<a class="nav-link" href="inscription.php">Inscription</a>
				<a class="nav-link" href="connexion.php">Connexion</a>
				<?php
					}else{
				?>
				<a class="nav-link" href="_profil/profil.php">Mon profil</a>
				<a class="nav-link" href="deconnexion.php">Déconnexion</a>
				<?php		
					}
				?>
			</div>
		</div>
	</div>
</nav>