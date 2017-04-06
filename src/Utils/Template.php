<?php

namespace Minichat\Utils;

class Template {
	private $template;


	private static function disconnectTemplate(){
		include(__DIR__ . '/../Templates/disconnect.php');
	} 
	private static function registerTemplate(){
		include(__DIR__ . '/../Templates/register.php');
	} 
	private static function loginTemplate(){
		include(__DIR__ . '/../Templates/login.php');
	} 
	private static function chatTemplate(){
		include(__DIR__ . '/../Templates/chat.php');
	} 
	private static function memberTemplate(){
		include(__DIR__ . '/../Templates/member.php');
	} 
	private static function loginOrRegisterTemplate(){
		 include(__DIR__ . '/../Templates/Forms/login_form.php');
		 include(__DIR__ . '/../Templates/Forms/register_form.php');
	}

	public function __construct(){
		if(isset($_GET['disconnect']) && $_GET['disconnect'] == true){
			$this->template = "disconnect";
		} elseif( isset($_POST['register']) && $_POST['register'] == true) {
			$this->template = "register";
		} elseif ( isset($_POST['login']) && $_POST['login'] == true) {
			$this->template = "login";		
		} elseif ( isset($_GET['chat']) && $_GET['chat'] == true) {
			$this->template = "chat";	
		} elseif ( isset($_GET['member']) && $_GET['member'] == true) {
			$this->template = "member";	
		} else {
			$this->template = "loginOrRegister";
		}
	}
	
	public function getTemplates(){
		switch ($this->template){
			case "register":
			return self::registerTemplate();
			break;
			case "login":
			return self::loginTemplate();
			break;
			case "chat":
			return self::chatTemplate();
			break;
			case "member":
			return self::memberTemplate();
			break;
			case "loginOrRegister":
			return self::loginOrRegisterTemplate();
			break;
			case "disconnect":
			return self::disconnectTemplate();
			break;
			default:
			return self::errorTemplate();
		}
	}

}