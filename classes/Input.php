<?php
class Input {
	public static function exists($type = 'post') {
		$type = strtolower($type);
		switch($type) {
			case 'post':
				return (!empty($_POST)) ? true : false;
			break;
			case 'get':
				return (!empty($_GET)) ? true : false;
			break;
			default:
				return false;
			break;
		}
	}

	public static function get($item, $type = 'post') {
		if (isset($_POST[$item])) {
			return htmlentities($_POST[$item]);
		}
		switch($type) {
			case 'post':
				if(isset($_POST[$item])) {
					return htmlentities($_POST[$item]);
				} else {
					return "";
				}
			break;
			case 'get':
				if (isset($_GET[$item])) {
					return escape($_GET[$item]);
				} else {
					return "";
				}
		}
		return "";
	}
}

?>