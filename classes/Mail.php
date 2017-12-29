<?php

class Mail {
	public function register($name, $email, $code) {
		mail($email,"Verify Email", $code, "Clossdrive");
	}
}
?>