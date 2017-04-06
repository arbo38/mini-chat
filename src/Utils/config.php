<?php

namespace Minichat\Utils;

class Config {
	private  $data;
	private static $instance;

	private function __construct(){
		$json = file_get_contents(__DIR__ . '/' . '../config/config.json');
		$this->data = json_decode($json, true);
	}

	public static function getInstance(){
		if(self::$instance == null){
			self::$instance = new Config();
		} 
		return self::$instance;
	}

	public function get($key){
		if(!isset($this->data[$key])){
			throw new Exception("Key $key not found in config");
		} else {
			return $this->data[$key];
		}
	}


}