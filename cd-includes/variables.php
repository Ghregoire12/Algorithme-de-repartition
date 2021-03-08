<?php
/*******************************************************************************
VARIABLES BDD
*******************************************************************************/

$database['hote'] = '*********';    //Adresse de l'hebergeur de la BDD
$database['user'] = '*********';    //Nom d'utilisateur
$database['base'] = '*********';    //Nom de la base


$database['pass'] = '*********';    //Mot de passe
$database['port'] = '3306';
$database['dsn'] = 'mysql:host='.$database['hote'].';port='.$database['port'].';dbname='.$database['base'].'; charset=utf8';



/*******************************************************************************
VARIABLES IDENTITE DU SITE
*******************************************************************************/
$website['url_local'] = '************';   //URL du site
$website['url'] = '************';         
$Website['name'] = '************';        //Nom du site

$root = $_SERVER['DOCUMENT_ROOT'];


/*******************************************************************************
VARIABLES JAVASCRIPT POST METHOD
template :
json_encode(array("name"=>"TEXTE VAR 1","status"=>CHIFFRE RESULTAT));
*******************************************************************************/
$javascript_responses['error_sql'] = json_encode(array("name"=>"Erreur SQL","status"=>0)); // Erreur de suppréssion SQL
$javascript_responses['error_access'] = json_encode(array("name"=>"ERROR ACCESS","status"=>0)); // Erreur coockie
$javascript_responses['error_variable'] = json_encode(array("name"=>"Erreur VAR","status"=>0)); // Erreur de placement variable form
$javascript_responses['error_loader'] = json_encode(array("name"=>"Erreur LOAD","status"=>0)); // Erreur de lancement form

?>
