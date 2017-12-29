<?php

class IP {
	
	public static function get($name) {
		$ip = $_SERVER["REMOTE_ADDR"];
		if (strlen(geoip_country_code_by_name($ip)) == 2) {
			$country_code = geoip_country_code_by_name($ip);
			$country_name = geoip_country_name_by_name($ip);
			$timezone = geoip_time_zone_by_country_and_region($country_code);
		} else {
			$country_code = "";
			$country_name = "";
			$timezone = "Asia/Phnom_Penh";
		}
	
		switch($name) {
				case "ip":
					return $ip;
				break;
				case "timezone":
					return $timezone;
				break;
				case "country_code":
					return $country_code;
				break;
				case "country_name":
					return $country_name;
				break;
				case "user_agent":
					return $_SERVER["HTTP_USER_AGENT"];
				break;
		}
	}
	
}

?>