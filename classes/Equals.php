<?php

class Equals {
	public static function check($string, $verify) {
		if(hash_equals(md5($string), md5($verify))) {
			return true;
		}

		return false;
	}
}

?>