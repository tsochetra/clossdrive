<?php

class Register {
	private $_db,
			$_user_firstname,
			$_user_lastname,
			$_user_email,
			$_user_password;

	public function __construct($user_surname, $user_email, $user_password) {
		
		try {
			if(!empty($user_surname) && !empty($user_email) && !empty($user_password)) {
				$this->_db = DB::connect();
				$this->_user_firstname = $this->split($user_surname)[0];
				$this->_user_lastname = $this->split($user_surname)[1];
				$this->_user_email = lower($user_email);
				$this->_user_password = Crypt::make($user_password);
			} else {
				throw new Exception("Wrong Parameter in Class Register");
			}
		} catch (Exception $e) {
			echo $e->getMessage();
		}
	}

	public function start() {
		if(!empty($this->_user_firstname) && !empty($this->_user_lastname) && !empty($this->_user_email) && !empty($this->_user_password)) {
			$insert = $this->_db->register_user($this->_user_firstname,$this->_user_lastname, $this->_user_email, $this->_user_password);
			if ($insert) {
				return true;
			}
		}

		return false;
	}

	public function split($surname) {
		return explode(",", $surname);
	}
}

?>