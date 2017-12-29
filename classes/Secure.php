<?php

class Secure {
	private $_db,
			$_unique_user,
			$_user_key,
			$_time,
			$_remember = false,
			$_user_agent;

	public function __construct() {
		if (Session::exists(Config::get("SESSION/HASH_LOGIN"))) {
			$this->_db = DB::connect();
			$this->_user_key = Session::GetHash()->user_uid;
			$this->_user_agent = Session::GetHash()->user_agent;
			$this->_unique_user = Session::GetHash()->unique_user;
			$this->_time = Session::GetHash()->time;
			$this->_remember = Session::GetHash()->remember ? true : false;
		}
	}

	public function session() {
		if (Session::exists(Config::get("SESSION/HASH_LOGIN"))) {
			if (!Equals::check($this->_unique_user, Cookie::get(Config::get("COOKIE/UNIQUE_USER")))) {
				return $this->destroy_cookie();
			} else if (!Equals::check($this->_user_agent, md5(IP::get("user_agent")))) {
				return $this->destroy_cookie();
			} else if ($this->_remember === false && time() - $this->_time > 3600*24) {
				return $this->destroy_session();
			} else if ($this->_remember === true && time() - $this->_time > Config::get("COOKIE/EXPIRE")) {
				return $this->destroy_session();
			} else if ($this->_db->select_uid($this->_user_key) && $this->_db->select_uid($this->_user_key)->num_rows === 0) {
				return $this->destroy_session();
			}
		}

		return false;
	}

	public function key() {
		return $this->_db->secure_login();
	}

	public function destroy_cookie() {
		foreach($_COOKIE as $name => $val) {
			Cookie::delete($name);
		}
		Redirect::to("/account/login");
	}

	public function destroy_session() {
		
		Session::destroy();
		foreach($_COOKIE as $name => $val) {
			Cookie::delete($name);
		}
		Redirect::to("/account/login");
	}
}

?>