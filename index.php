<?php
session_start();
require_once __DIR__ . '/vendor/autoload.php';
use Minichat\Utils\Config;
use Minichat\Utils\Template;
use Minichat\Utils\User;

$config = Config::getInstance();
$dbConfig = $config->get('db');
if(isset($_SESSION['pseudo'])){
	echo $_SESSION['pseudo'];
} else {
	echo "No session open";
}



?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8" />
	<title>TP : Mini-chat</title>
</head>
<body>
	<h1>Welcome to the minichat website</h1>
	<?php
	include(__DIR__ . '/src/Templates/nav.php');
	$template = new Template(); 
	$template->getTemplates();
	if(isset($_SESSION['pseudo'])){
		echo $_SESSION['pseudo'];
	} else {
		echo "No session open";
	}
	?>
	
</body>
</html>

