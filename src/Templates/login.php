<?php
session_destroy();
session_start();

require_once __DIR__ . '/../../vendor/autoload.php';
use Minichat\Utils\Spdo;
use Minichat\Utils\User;

if (isset($_POST['pseudo']) && isset($_POST['password']) && isset($_POST['login']) && $_POST['login'] == true){
	if( !empty($_POST['pseudo']) && !empty($_POST['password'])){
		$pseudo = (string) $_POST['pseudo'];
		$password = (string) $_POST['password'];
		$checkLogin = true;
	} else {
		$checkLogin = false;
	}
} else {
	$checkLogin = false;
}

if($checkLogin){
	try{
		$user = new User(false, $pseudo, $password);
		echo 'Vous êtes connecté ' . $user->pseudo . '<br>';
	} catch (Exception $e){
		echo "Une erreur est survenue<br>";
		echo $e->getMessage();
		include(__DIR__ .'/Forms/login_form.php');
		include(__DIR__ .'/Forms/register_form.php');
	}
} else{
	echo "Les indentifiants sont incorrect, merci de réessayer : ";
	include(__DIR__ .'/Forms/login_form.php');
	include(__DIR__ .'/Forms/register_form.php');
}