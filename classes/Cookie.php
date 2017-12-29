<?php

class Cookie {
	
	public static function exists($name) {
		return (isset($_COOKIE[$name])) ? true : false;
	}
	
	public static function get($name) {
		if (self::exists($name)) {
			return $_COOKIE[$name];
		}
		
		return false;
	}
	
	public static function set($name, $value, $time = null) {
		$time = isset($time) ? $time : Config::get("COOKIE/EXPIRE");
		return setcookie($name, $value, time() + $time, "/", Config::get('HTTP/DOMAIN'), Config::get('HTTP/HTTPS'), Config::get('HTTP/ONLY'));
	}

	public static function set_session($name, $value) {
		return setcookie($name, $value, 0, "/", Config::get('HTTP/DOMAIN'), Config::get('HTTP/HTTPS'), Config::get('HTTP/ONLY'));
	}
	
	public static function delete($name) {
		return self::set($name, "", 1);
	}
	
	public static function unique_visitor() {
		if (!self::exists(Config::get("COOKIE/UNIQUE_USER")) || strlen(escape(self::get(Config::get("COOKIE/UNIQUE_USER")))) !== 15 ) {
			self::set_session(Config::get("COOKIE/UNIQUE_USER"), Generate::make(15));
		}
	}
}

?>