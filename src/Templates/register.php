<?php
require_once __DIR__ . '/../../vendor/autoload.php';
use Minichat\Utils\Config;
use Minichat\Utils\Template;
use Minichat\Utils\User;
use Minichat\Utils\Spdo;

if(isset($_POST['pseudo']) && isset($_POST['password']) && isset($_POST['email'])){ // check if all expected variables are set
	if(!empty($_POST['pseudo']) && !empty($_POST['password']) && !empty($_POST['email'])){ // check if those variables are not empty
		$pseudo = (string) $_POST['pseudo'];
		$email = (string) $_POST['email'];
		$password = (string) $_POST['password'];
		$createUser = true;
		var_dump($pseudo);
	}
} else {
	$createUser = false;
}

if($createUser){
	try{
		$user = new User(true, $pseudo, $password, $email);
		var_dump($user);
		echo "Votre enregistrement à bien été effectué $pseudo";
	} catch (Exception $e){
		echo "Une erreur est survenue lors de votre enregistrement : $e";
	}
}