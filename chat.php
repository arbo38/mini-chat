<?php
session_start();
if(isset($_SESSION['pseudo']) && !empty($_SESSION['pseudo'])){
	$logged = true;
}elseif(isset($_GET['pseudo']) && !empty($_GET['pseudo'])){
	$_SESSION['pseudo'] = (string) $_GET['pseudo'];
	$logged = true;
}else{
	$logged = false;
}
var_dump($_SESSION['pseudo']);

if(isset($_POST['chatPost']) && !empty($_POST['chatPost'])){
	$newMessage = true;
}else{
	$newMessage = false;
}

if($newMessage && $logged){
	$db = new PDO(
		'mysql:host=127.0.0.1;dbname=minichat',
		'root',
		'');
	$pseudo = (string)($_SESSION['pseudo']);
	$message = (string)($_POST['chatPost']);
	$date = (string) date('Y-m-d H:i:s');
	$queryInsertNewMessage = "INSERT INTO messages (pseudo, message, date)
	VALUES(:pseudo, :message, :date)";
	$statement = $db->prepare($queryInsertNewMessage);
	$statement->bindValue('pseudo', $pseudo);
	$statement->bindValue('message', $message);
	$statement->bindValue('date', $date);
	$result = $statement->execute();
	var_dump($result);
	$error = $statement->errorInfo()[2];
	var_dump($error);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8" />
	<title>Chatroom</title>
</head>
<body>
	<?php
	if($logged){
		echo 'Bonjour ' . $_SESSION['pseudo'];
		$db = new PDO(
			'mysql:host=127.0.0.1;dbname=minichat',
			'root',
			''
			);
		$queryMessages = 'SELECT * FROM messages ORDER BY id LIMIT 10';
		$statement = $db->prepare($queryMessages);
		$statement->execute();
		$result = $statement->fetchAll();
		$htmlChatTable = '<table><tr><th>Pseudo</th><th>Message</th>';
		foreach ($result as $value) {
			$htmlChatTable .= '<tr><td> ' . $value['pseudo'] . ' </td> <td>' . $value['message'] . ' </td></tr> ';
		}
		$htmlChatTable .= '</table>';
		echo $htmlChatTable;
		$chatForm = "
		<form class='chat-form' method='POST' action='chat.php'>
			<h2>Tapez votre message ici : </h2>
			<textarea name='chatPost' id='chatPost' cols='30' rows='1'></textarea>
			<input type='submit'>
		</form>";
	echo $chatForm;

}

else{
	echo "Merci de vous rendre sur la <a href='index.php'>page de login</a>";
}

?>

</body>
</html>

