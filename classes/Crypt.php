<?php

class Crypt {
	public function make($pass) {
		return password_hash(md5($pass), PASSWORD_DEFAULT);
	}
	
	public function check($pass, $salt) {
		return password_verify(md5($pass), $salt);
	}
	
}

?>