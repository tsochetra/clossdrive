<?php
class Config {
	
	public static function get($path) {
		
		try {
			if ($path) {
			$path_upper = upper($path);
			$config = $GLOBALS['config'];
			
			$path_upper = explode("/",$path_upper);
			foreach($path_upper as $to) {
				if (isset($config[$to])) {
					$config = $config[$to]; 
				} else {
					$config = null;
					throw new Exception("404 {$path} Not Found");
				}
			}
			
			return $config;
			}
		} catch (Exception $e) {
			echo $e->getMessage();
		}
	}
}
?>