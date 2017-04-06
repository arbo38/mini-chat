<?php

namespace Minichat\Utils;
use Minichat\Utils\Spdo;
use \Exception;


class User {
	public $pseudo;
	public $password;
	public $email;
	public $date;
	public $userId;
	public $new;
	private function checkPseudo($pseudo){
		$pseudo = trim(strip_tags($pseudo));
		var_dump($pseudo);
		return true;
		/*if(strlen($pseudo >= 2)){
			return true;
		} else {
			throw new Exception("The pseudo provided is incorrect", 1);
		}*/
	}

	private function checkPassword($password){
		if(strlen($password) >= 8){
			return true;
		} else {
			throw new Exception("The password provided is incorrect", 1);
		}
	}

	private function checkEmail($email){
		if(filter_var($email) != false){
			return true;
		} else {
			throw new Exception("The email provided is incorrect", 1);
		}
	}

	public function __construct (bool $new, string $pseudo, string $password, string $email=null){
		if($new){ // Cas de l'ajout d'un nouveau User en Database
			if($this->checkPseudo($pseudo)){
				$this->pseudo = $pseudo;
			} 
			if($this->checkPassword($password)){
				$this->password = sha1($password);
			}
			if($this->checkEmail($email)){
				$this->email = $email;
			} 
			$this->date = (string)date('Y-m-d');
			$this->addUserToDb();
			$this->openUserSession();
		} else { // Récupération d'un User existant en Database
			if($this->checkPseudo($pseudo) && $this->checkPassword($password)){
				$this->pseudo = $pseudo;
				$this->password = sha1($password);
				if($this->getUserFromDb()){
					$this->openUserSession();
				} else{
					throw new Exception("Error Processing Request", 1);
					
				}
			} else {
				throw new Exception("Error, login or password incorrect", 1);
			}
		}
	}

	private function addUserToDb(){
		$query = "
		INSERT INTO users (pseudo, password, email, member_since)
		VALUES (:pseudo, :password, :email, :date)
		";
		$statement = SPDO::getInstance()->prepare($query);
		$params = [
		'pseudo' => $this->pseudo,
		'password' => $this->password,
		'email' => $this->email,
		'date' => $this->date
		];
		if(!$statement->execute($params)){
			throw new Exception($statement->errorInfo()[2]);	
		} else {
			if($this->getUserFromDb()){
				$this->openUserSession();
			} else{
				throw new Exception("Error Processing Request", 1);
				
			}
		}
		$statement->closeCursor();
	}

	private function getUserFromDb(){
		$inputPassword = $this->password;
		$query = "SELECT password FROM users WHERE pseudo=:pseudo";
		$statement = SPDO::getInstance()->prepare($query);
		$statement->bindValue('pseudo', $this->pseudo);
		$statement->execute();
		$dbPassword = $statement->fetch()['password'];
		$statement->closeCursor();
		if($dbPassword == null){
			throw new Exception("Pseudo not found", 1);
		} else {
			if($dbPassword == $inputPassword){
			$query = "SELECT * FROM users WHERE pseudo=:pseudo";
			$statement = SPDO::getInstance()->prepare($query);
			$statement->bindValue('pseudo', $this->pseudo);
			$statement->execute();
			$result = $statement->fetchAll()[0];
			$statement->closeCursor();
			$this->email = $result['email'];
			$this->date = $result['member_since'];
			$this->userId = $result['id'];
			return true;
			} else {
			 	throw new Exception("Password does not match", 1);
			}
		}
	}

	public function openUserSession(){
		$_SESSION['pseudo'] = $this->pseudo;
		$_SESSION['email'] = $this->email;
		$_SESSION['member_since'] = $this->date;
		$_SESSION['userId'] = $this->userId;
	}

	public function closeUserSession(){
		$this->pseudo = null;
		$this->password = null;
		$this->email = null;
		$this->date = null;
		$this->userId = null;
		$this->new = null;
		return session_destroy();
	}

	public function changeUserInformation(string $informatioType, $newValue){
		switch ($informatioType) {
			case 'pseudo':
				if($this->checkPseudo($newValue)){
					$query = "UPDATE SET pseudo=:pseudo WHERE id=:id";
				} else {
					throw new Exception("incorrect pseudo provided", 1);
				}
				break;
			case 'email':
				if($this->checkEmail($newValue)){
					$query = "UPDATE SET email=:email WHERE id=:id";
				} else {
					throw new Exception("incorrect email provided", 1);
				}
				break;
			case 'password':
				if($this->checkPassword($newValue)){
					$query = "UPDATE SET password=:password WHERE id=:id";
				} else {
					throw new Exception("incorrect password provided", 1);
				}			
				break;
			default:
				throw new Exception("Error while updating user information", 1);
				break;
		}
		$statement = SPDO::getInstance()->prepare($query);
		$statement->bindValue($informatioType, $newValue);
		$statement->bindValue('id', $userId);
		if(!$statement->execute()){
			throw new Exception("Errore while updating user information", 1);
			throw new Exception($statement->errorInfo()[2]);
		}
		$statement->closeCursor();
	}

	public function getPseudo(){
		return $this->pseudo;
	}

	public function getEmail(){
		return $this->email;
	}
}