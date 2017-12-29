<?php

class Token {
	
	public static function set() {
		$tokenName = Config::get("SESSION/CSRFTOKEN");
		$token = Generate::make(Config::get("HASH/TOKEN"));
		Session::set($tokenName, $token);
		return $token;
	}
	public static function check($token) {
		$tokenName = Config::get("SESSION/CSRFTOKEN");
		if (Session::exists($tokenName) && Equals::check($token, Session::get($tokenName))) {
			Session::delete($tokenName);
			return true;
		}
		
		return false;
	}
}

?>