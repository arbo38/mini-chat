<?php

require_once __DIR__ . '/../../vendor/autoload.php';

use Minichat\Utils\Spdo;
use Minichat\Utils\Config;
use Minichat\Utils\Chat;

if(isset($_POST['newMessage']) && !empty($_POST['newMessage']) && isset($_SESSION['pseudo']) && !empty($_SESSION['pseudo'])){
	$message = $_POST['newMessage'];
	$chat = new Chat(true, $message);
	try{
		$chat->getMessages();
	} catch(Exception $e){
		echo $e;
	}
	$chat->printMessages();
} else {
	$chat = new Chat(false);
	$chat->getMessages();
	$chat->printMessages();
	
}

include(__DIR__ .'/Forms/message_form.php');

/*
if(newMessage){
	$chat = new Chat(bool, $message);
} else {
	$chat = new Chat();
}

echo 'Formulaire de nouveau messages';
*/
?> 

