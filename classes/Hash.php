<?php 

class Hash {

	private static $arrayid = array(0,7,13,31,45,59,71,77,89,100,111,115,125);
	public static function make($id) {
		if (Equals::check(strlen($id), 12)) {
			$i=0;

			foreach(self::$arrayid as $ord) {
				if ($ord === 0) {
					$hash = "";
				} else if ($ord === 125) {
					$hash .= Generate::make($ord - 1 - self::$arrayid[$i]) . $id[$i] . Generate::make(3);
					$i++;
				} else {
					$hash .= Generate::make($ord - 1 - self::$arrayid[$i]) . $id[$i];
					$i++;
				}
			}

			return $hash;
		}
	}

	public static function solve($hash) {
		if (Equals::check(strlen($hash), 128)) {
			$uid = "";
			
			foreach(self::$arrayid as $id) {
				if($id === 0) {
					$uid = "";
				} else {
					$uid .= $hash[$id - 1];
				}

			}

			return $uid;
		}
	}

}


?>