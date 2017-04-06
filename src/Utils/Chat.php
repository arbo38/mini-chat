<?php
namespace Minichat\Utils;

require_once __DIR__ . '/../../vendor/autoload.php';
use Minichat\Utils\Spdo;
use Minichat\Utils\Config;
use \Exception;

class Chat {
	private $messages;
	private $maxChatMessages;

	public function __construct(bool $newMessage = false, string $message=null){
		if($newMessage){
			$this->storeNewMessage($message);
		}
		$this->maxChatMessages = Config::getInstance()->get('chat')['maxChatMessage'];
	}

	private function storeNewMessage($message){
		echo "Messages Stored <br>";
		$date = (string) date('Y-m-d H:i:s');
		$query = "
		INSERT INTO messages (pseudo, message, date)
		VALUES(:pseudo, :message, :date)
		";
		$statement = SPDO::getInstance()->prepare($query);
		$params = [
		'pseudo' => $_SESSION['pseudo'],
		'message' => $message,
		'date' => $date
		];
		if(!$statement->execute($params)){
			throw new Exception("Une erreure est survene lors de l'enregistrement du nouveau message <br>", 1);
			throw new Exception($statement->errorInfo()[2]);
			
		}
		$statement->closeCursor();
	}

	public function getMessages(){
		$query = "(SELECT * FROM messages ORDER BY id DESC LIMIT 10) ORDER BY id ASC";
		$statement = SPDO::getInstance()->prepare($query);
		if(!$statement->execute()){
			throw new Exception($statement->errorInfo()[2]);
		}
		$this->messages = $statement->fetchAll();
		$statement->closeCursor();
	}

	public function printMessages(){
		$printMessages = "<table id='chat'><th>Pseudo</th><th>Message</th><th><Date et Heure>";
		foreach ($this->messages as $value) {
			$printMessages .= '<tr><td>'.$value['pseudo'].'</td><td>'.$value['message'].'</td><td>'.$value['date'].'</td>';
		}
		$printMessages .= '</table>';
		echo $printMessages;
	}

	/*public function printMessageForm(){
		$messageForm = "
		<form action='index.php?chat=true' method='POST'>
			<textarea name='newMessage' id='newMessage' cols='40' rows='20'></textarea>
			<input type='submit' />
		</form>";
		echo $messageForm;
	}*/
}