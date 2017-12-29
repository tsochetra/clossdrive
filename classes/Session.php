<?php

class Session {
	public static function exists($name) {
		return (isset($_SESSION[$name])) ? true : false;
	}
	
	public static function get($name) {
		if (self::exists($name)) {
			return $_SESSION[$name];
		}
		
		return false;
	}
	
	public static function set($name, $value) {
		return $_SESSION[$name] = $value;
	}
	
	public static function delete($name) {
		if (self::exists($name)) {
			unset($_SESSION[$name]);
			return true;
		}
		
		return false;
	}

	public static function name() {
		return session_name();
	}

	public static function id() {
		return session_id();
	}

	public static function destroy() {
		return session_destroy();
	}

	public static function start() {
		session_name(Config::get("SESSION/NAME"));
		session_set_cookie_params(0, "/", Config::get("HTTP/DOMAIN"), 1, 1);
		session_start();
	}

	public static function Hash($userkey, $remember) {
		return $userkey . "-" . md5(IP::get("user_agent")) . "-" . Cookie::get(Config::get("COOKIE/UNIQUE_USER")) . "-" . time() . "-" . $remember;
	}

	public static function GetHash() {
		if (self::exists(Config::get("SESSION/HASH_LOGIN"))) {
			$hash = explode("-", self::get(Config::get("SESSION/HASH_LOGIN")));
			$obj = array("user_uid", "user_agent", "unique_user", "time", "remember");
			return (object)array_combine($obj, $hash);
		}
		
		return false;
	}

}

?>