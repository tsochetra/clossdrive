<?php

class Captcha {
	private $_db;

	public function __construct() {
		$this->_db = DB::connect();
	}

	public function login() {
		$data = $this->_db->secure_login();
		if($data && $data->num_rows === 1) {
			$data = $data->fetch_object();
			if(Equals::check($data->user_hash, md5(IP::get('user_agent') . IP::get('ip'))) && $data->amount_login >= 20 && time() - $data->time < 600) {
				return 3;
			} else if(Equals::check($data->user_hash, md5(IP::get('user_agent') . IP::get('ip'))) && $data->amount_login >= 5 && time() - $data->time < 600) {
				return 2;
			}
		}

		return false;
	}
}



?>