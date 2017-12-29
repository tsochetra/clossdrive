<?php

class Generate {
	
	public function make($size) {
		$ret = "";
		for($i=0;$i<$size;$i++) {
			$s1 = substr(str_shuffle("ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789"),0,1);
			$ret .= $s1;
		}
		return $ret;
	}

	public function make_uid() {
		$db = DB::connect();

		for($i=0;$i<5;$i++) {
			$uid = Generate::make(14);
			$result = $db->select_uid($uid);
			if ($result->num_rows === 0) {
				return $uid;
				break;
			}
		}
	}
	
}

?>