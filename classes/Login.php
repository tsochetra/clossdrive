<?php

class Login {

	private $_db,
			$_user_email,
			$_user_password,
			$_user_remember;

	public function __construct($email, $password, $remember = false) {
		try {
			if (!empty($email) && !empty($password)) {
				$this->_db = DB::connect();
				$this->_user_email = lower($email);
				$this->_user_password = $password;
				$this->_user_rememeber = $remember;
			} else {
				throw new Exception("Email and Password can not empty");
			}
		} catch (Exception $e) {
			echo $e->getMessage();
		}
		
	}

	public function start() {
		if($this->_user_email && $this->_user_password) {

			$this->_db->track_login();
			$user_data = $this->_db->login_user($this->_user_email);
			
			if($user_data->num_rows === 1) {
				$user_data = $user_data->fetch_object();

				if(Crypt::check($this->_user_password, $user_data->user_password)) {

					if (Cookie::exists(Config::get("COOKIE/UNIQUE_USER")) && strlen(Cookie::get(Config::get("COOKIE/UNIQUE_USER"))) === 15) {
						
						$remember = $this->_user_rememeber ? 1 : 0;
						Session::set(Config::get("SESSION/HASH_LOGIN"), Session::Hash($user_data->user_uid, $remember));
						if($remember) {
							Cookie::set(Session::name(), Session::id());
							Cookie::set(Config::get("COOKIE/UNIQUE_USER"), Cookie::get(Config::get("COOKIE/UNIQUE_USER")));
						}
						
						$this->_db->login_history_user($user_data->user_uid);
						return true;
					}
				}
			}
		}

		return false;
	}





}



?>