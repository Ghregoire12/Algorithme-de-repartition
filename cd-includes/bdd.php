<?php

	include_once 'variables.php';

	session_start();
	date_default_timezone_set("Europe/Paris");

	try {
	    $bdd = new PDO($database['dsn'], $database['user'], $database['pass']);
	} catch (PDOException $e) {
	    die("Erreur ! :" . $e->getMessage());
	}

	$formatter = new IntlDateFormatter('fr_FR',IntlDateFormatter::LONG,
                IntlDateFormatter::NONE,
                'Europe/Paris',
                IntlDateFormatter::GREGORIAN );
	

?>
