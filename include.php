<?php
	
	setlocale(LC_TIME, "fr_FR.UTF-8");
	date_default_timezone_set('Europe/Paris');
	
	session_start();

	include_once('db/connexionDB.php');
	include_once('components/class/inscription.php');
	include_once('components/class/connexion.php');
	
	
	// Déclaration des classes sous forme de variables
	$_Inscription = new Inscription;
	$_Connexion = new Connexion;

?>