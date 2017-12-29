<?php

class DB {
	private static $_connect = null;
	private	$_db,
			$_host,
			$_user,
			$_pass,
			$_name;
	private function __construct() {
		$this->_host = Config::get("DATABASE/HOST");
		$this->_user = Config::get("DATABASE/USERNAME");
		$this->_pass = Config::get("DATABASE/PASSWORD");
		$this->_name = Config::get("DATABASE/NAME");
		
		try {
			$this->_db = new mysqli($this->_host, $this->_user, $this->_pass, $this->_name);
			if ($this->_db->connect_errno) {
				throw new Exception($this->_db->connect_error);
				//exit();
			}
		} catch (Exception $e) {
			echo $e->getMessage();
		}
	}
	
	public function connect() {
		if (!isset(self::$_connect)) {
			self::$_connect = new DB();
		}
		
		return self::$_connect;
	}
	
	public function select($tbl, $column, $fields) {
		if(!$this->_db->connect_error) {
			if (count($fields) === 3) {
				$where = $fields[0];
				$operator = $fields[1];
				$value = $fields[2];
				if (match_operator($operator)) {
					$prepare = $this->_db->prepare("SELECT {$column} FROM `{$tbl}` WHERE {$where} {$operator} ?");
					$prepare->bind_param('s', $value);
					$prepare->execute();
				
					return $prepare->get_result();
				
				}
			}
		}
		
		return false;
	}
	
	public function register_user($first, $last, $email, $password) {
		if(!$this->_db->connect_error) {
			$user_create = time();
			$user_account_type = 'E';
			$uid = Generate::make_uid();
			$user_timezone = IP::get('timezone');
			$user_country = IP::get('country_code');
			$user_email_code = Generate::make(rand(32,64));
			$user_email_code_md5 = md5($user_email_code);
			
			$table = array("user_address", "user_company", "user_email", "user_email_activation", "user_id", "user_info", "user_password", "user_phone_number", "user_profile_picture", "user_security_question", "user_settings", "user_surname", "user_username", "user_website");
		
			if (connection_status() == "CONNECTION_NORMAL" && !$this->_db->connect_errno) {
				foreach($table as $tbl) {
					$this->_db->query("INSERT INTO `$tbl` (`user_uid`) VALUE('$uid')");
				}

				$prepare = $this->_db->prepare("
					UPDATE
					user_email, user_email_activation, user_id, user_info, user_password, user_settings, user_surname
					SET
					user_email.user_email 						= ?,
					user_email_activation.user_email_activation = ?,
					user_email_activation.date 					= ?,
					user_info.user_country 						= ?,
					user_info.user_timezone 					= ?,
					user_password.user_password 				= ?,
					user_settings.user_created_date 			= ?,
					user_settings.user_account_type				= ?,
					user_surname.user_firstname					= ?,
					user_surname.user_lastname					= ?
					WHERE
					user_email.user_uid 				= ?
					AND user_email_activation.user_uid 	= ?
					AND user_id.user_uid 				= ?
					AND user_info.user_uid 				= ?
					AND user_password.user_uid 			= ?
					AND user_settings.user_uid 			= ?
					AND user_surname.user_uid 			= ?
				");
				
				$prepare->bind_param("ssisssissssssssss", $email, $user_email_code_md5,$user_create, $user_country, $user_timezone, $password, $user_create, $user_account_type, $first, $last, $uid, $uid, $uid, $uid, $uid, $uid, $uid);
				if($prepare->execute()) {		
					Session::set(Config::get("SESSION/HASH_LOGIN"), Session::Hash($uid, 1));
					Mail::register($first, $email, $user_email_code);
					return true;
				}
			}
		}

		return false;
	}

	public function login_user($email) {

		if(!$this->_db->connect_error) {
			$user_data = $this->_db->prepare("
				SELECT 
				user_email.user_uid,
				user_username.user_username,
				user_password.user_password

				FROM users 
				JOIN user_email ON user_email.user_email = ? OR user_email.user_second_email = ?
				JOIN user_username ON user_username.user_uid = user_email.user_uid
				JOIN user_password ON user_password.user_uid = user_email.user_uid
			");
			$user_data->bind_param('ss', $email, $email);
			$user_data->execute();

			return $user_data->get_result();
		}

		return false;
	}

	public function login_history_user($uid) {

		if(!$this->_db->connect_error) {
			$browser = getbrowser();
			$os = get_os();
			$country = IP::get("country_name");
			$ip = IP::get("ip");
			$date = time();
			$session = Session::id();
			$prepare = $this->_db->prepare("
				INSERT INTO 
				user_login_history (`user_uid`,`user_login_browser`,`user_login_os`,`user_login_country`,`user_login_ip`,`user_session`,`date`) 
				VALUES (?, ?, ?, ?, ?, ?, ?)
			");
			$prepare->bind_param('ssssssi', $uid, $browser, $os, $country, $ip, $session, $date);
			$prepare->execute();
		}

		return false;
		
	}

	public function get_file($uid) {

		if(!$this->_db->connect_error) {
			$prepare = $this->_db->prepare("SELECT * FROM `files` WHERE `user_uid` = ?");
			$prepare->bind_param("s",$uid);
			$prepare->execute();

			return $prepare->get_result();
		}

		return false;
	}

	public function upload($file_uid, $name, $filename, $size, $key, $user_uid, $type) {

		if(!$this->_db->connect_error) {
			$time = time();
			$prepare = $this->_db->prepare("INSERT INTO `files` VALUE (?,?,?,?,?,?,?,?)");
			$prepare->bind_param("sssisiss",$file_uid, $name, $filename, $size, $key, $time, $type, $user_uid);
			if ($prepare->execute()) {
				return true;
			}
		}
		
		return false;
	}

	public function file_found($id) {

		if(!$this->_db->connect_error) {
			$prepare = $this->_db->prepare("SELECT * FROM files WHERE `file_uid` = ?");
			$prepare->bind_param("s", $id);
			$prepare->execute();

			return $prepare->get_result();
		}
		
		return false;
	}

	public function select_uid($uid) {

		if(!$this->_db->connect_error) {
			$query = $this->_db->query("SELECT user_uid FROM user_id WHERE user_uid = '$uid'");
			return $query;
		}
		
		return false;
	}

	public function secure_login() {
	
		if(!$this->_db->connect_error) {
			$user_hash = md5(IP::get('user_agent') . IP::get('ip'));
			$prepare = $this->_db->prepare("SELECT * FROM `user_secure_login` WHERE `user_hash` = ?");
			$prepare->bind_param("s", $user_hash);
			$prepare->execute();

			return $prepare->get_result();
		}
		
		return false;
	}

	public function track_login() {
		if(!$this->_db->connect_error) {
			
			$data = $this->secure_login();
			$amount = 1;
			$user_hash = md5(IP::get('user_agent') . IP::get('ip'));
			$time = time();

			if($data->num_rows === 1) {
				$data = $data->fetch_object();
				if ($data->amount_login >= 5 && time() - $data->time > 600){
					$amount = 1;
					$time = time();
				} else if ($data->amount_login >= 5){
					$amount = $data->amount_login + 1;
					$time = $data->time;
				} else if (time() - $data->time < 60) {
					$amount = $data->amount_login + 1;
				}

				$prepare = $this->_db->prepare("UPDATE `user_secure_login` SET `amount_login` = ?, `time`= ? WHERE `user_hash` = ?");
				$prepare->bind_param("iis",$amount, $time, $user_hash);
				if($prepare->execute()) {
					return true;
				}
			} else {
				$prepare = $this->_db->prepare("INSERT INTO `user_secure_login` (`user_hash`,`amount_login`,`time`) VALUES(?,?,?) ");
				$prepare->bind_param("ssi",$user_hash, $amount, $time);
				if($prepare->execute()) {
					return true;
				}
			}

			
			
		}

		return false;
	}

	

}
?>