<?php

function lower($str) {
	return strtolower($str);
}

function upper($str) {
	return strtoupper($str);
}

function escape($str) {
	$patt = "/[^A-Za-z0-9]/";
	return preg_replace($patt, "", $str);
}

function escape_quote($str) {
	$notAllowed = array("'",'"',"\\");
	return str_replace($notAllowed, "", $str);
}

function escape_string($str) {
	$notAllowed = array(
	"`","~","!","@","#","$","%","^","&","*","(",")","","+","=","\\","|","[","]","{","}",";",":","'",'"',"/","?",">","<",".",",",
	" ","DROP","INSERT","DELETE","TRUNCATE","UPDATE","CREATE","OR","SELECT","select","drop","insert","delete","truncate","update","create","or"
	);
	return str_replace($notAllowed, "", $str);
}

function escape_email($str) {
	$patt = "/[^A-Za-z0-9@.]/";
	return preg_replace($patt, "", $str);
}

function protect_extension() {
	if(strpos($_SERVER['REQUEST_URI'], '.php')) {
		Redirect::to(404);
	}
}

function match_operator($operator) {
	$operators = array("=",">","<",">=","<=");
	if (in_array($operator, $operators)) {
		return true;
	}
	return false;
}

function match_country($country) {
	$countrys = array(
	'A1','A2','O1','AD','AE','AF','AG','AI','AL','AM','AO','AP','AQ','AR','AS','AT','AU','AW','AX','AZ','BA','BB','BD','BE','BF',
	'BG','BH','BI','BJ','BL','BM','BN','BO','BQ','BR','BS','BT','BV','BW','BY','BZ','CA','CC','CD','CF','CG','CH','CI','CK','CL',
	'CM','CN','CO','CR','CU','CV','CW','CX','CY','CZ','DE','DJ','DK','DM','DO','DZ','EC','EE','EG','EH','ER','ES','ET','EU','FI',
	'FJ','FK','FM','FO','FR','GA','GB','GD','GE','GF','GG','GH','GI','GL','GM','GN','GP','GQ','GR','GS','GT','GU','GW','GY','HK',
	'HM','HN','HR','HT','HU','ID','IE','IL','IM','IN','IO','IQ','IR','IS','IT','JE','JM','JO','JP','KE','KG','KH','KI','KM','KN',
	'KP','KR','KW','KY','KZ','LA','LB','LC','LI','LK','LR','LS','LT','LU','LV','LY','MA','MC','MD','ME','MF','MG','MH','MK','ML',
	'MM','MN','MO','MP','MQ','MR','MS','MT','MU','MV','MW','MX','MY','MZ','NA','NC','NE','NF','NG','NI','NL','NO','NP','NR','NU',
	'NZ','OM','PA','PE','PF','PG','PH','PK','PL','PM','PN','PR','PS','PT','PW','PY','QA','RE','RO','RS','RU','RW','SA','SB','SC',
	'SD','SE','SG','SH','SI','SJ','SK','SL','SM','SN','SO','SR','SS','ST','SV','SX','SY','SZ','TC','TD','TF','TG','TH','TJ','TK',
	'TL','TM','TN','TO','TR','TT','TV','TW','TZ','UA','UG','UM','US','UY','UZ','VA','VC','VE','VG','VI','VN','VU','WF','WS','YE',
	'YT','ZA','ZM','ZW');
	if(in_array($country, $countrys)) {
		return true;
	}
	
	return false;
}

function get_os() {
	$user_agent = $_SERVER["HTTP_USER_AGENT"];
	$os_platform = "Unknown OS Platform";
	$os_array = array(
		'/windows nt 10/i'		=>	'Windows 10',
		'/windows nt 6.3/i'		=>	'Windows 8.1',
		'/windows nt 6.2/i'		=>	'Windows 8',
		'/windows nt 6.1/i'		=>	'Windows 7',
		'/windows nt 6.0/i'		=>	'Windows Vista',
		'/windows nt 5.2/i'		=>	'Windows Server 2003/XP x64',
		'/windows nt 5.1/i'		=>	'Windows XP',
		'/windows xp/i'			=>	'Windows XP',
		'/windows nt 5.0/i'		=>  'Windows 2000',
		'/windows me/i'			=>	'Windows ME',
		'/win98/i'				=>	'Windows 98',
		'/win95/i'				=>	'Windows 95',
		'/win16/i'				=>	'Windows 3.11',
		'/macintosh|mac os x/i'	=>	'Mac OS X',
		'/mac_powerpc/i'		=>  'Mac OS 9',
		'/linux/i'				=>	'Linux',
		'/ubuntu/i'				=>	'Ubuntu',
		'/iphone/i'				=>	'iPhone',
		'/ipod/i'				=>	'iPod',
		'/ipad/i'				=>	'iPad',
		'/android/i'			=>	'Android',
		'/blackberry/i'			=>	'BlackBerry',
		'/webos/i'				=>	'Mobile'
	);

	foreach ($os_array as $regex => $value) {
		if (preg_match($regex, $user_agent)) {
		$os_platform = $value;
		}
	}

	return $os_platform;
}

function getbrowser() {
	$user_agent = $_SERVER["HTTP_USER_AGENT"];
	$browser = "Unknown Browser";
	$browser_array = array(
		'/msie/i'		=>	'Internet Explorer',
		'/firefox/i'	=>	'Firefox',
		'/safari/i'		=>	'Safari',
		'/chrome/i'		=>	'Chrome',
		'/opera/i'		=>	'Opera',
		'/netscape/i'	=>	'Netscape',
		'/maxthon/i'	=>	'Maxthon',
		'/konqueror/i'	=>	'Konqueror',
		'/mobile/i'		=>	'Handheld Browser'
	);

	foreach ($browser_array as $regex => $value) {
		if (preg_match($regex, $user_agent)) {
			$browser = $value;
		}
	}

	return $browser;
}

function get_size($size) {
	if ($size >= 1073741824) {
		$bytes = array(($size/1073741824)," GB",($size % 1073741824));
	} else if ($size >= 1048576) {
		$bytes = array(($size/1048576)," MB",($size % 1048576));
	} else if ($size >= 1024) {
		$bytes = array(($size/1024)," KB",($size % 1024));
	} else {
		$bytes = array($size," B",0);
	}
	if ($bytes[2] !== 0) {
		$split = explode(".",$bytes[0]);
		$end_bytes = substr($split[1],0,2);
		$end_bytes = ($end_bytes != 00) ? ".".$end_bytes : "";
		$bytes_modulus = $split[0].$end_bytes.$bytes[1];
		return $bytes_modulus;
	} else {
		return $bytes[0].$bytes[1];
	}
}



?>