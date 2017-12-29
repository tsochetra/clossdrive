<?php

$GLOBALS['config'] = array(
	'DATABASE' => array(
		'HOST' => '127.0.0.1',
		'NAME' => 'clossdrive',
		'USERNAME' => 'root',
		'PASSWORD' => ''
	),
	'COOKIE' => array(
		'EXPIRE' => 7776000,
		'DESTROY' => 1,
		'LANG' => 'lang',
		'UNIQUE_USER' => 'u_v',
		'LOCALE' => 'geoip_locale'
	),
	'SESSION' => array(
		'NAME' => 'cd',
		'CSRFTOKEN' => 'csrf_t',
		'HASH_LOGIN' => 'h_l',
		'CAPTCHATOKEN' => 'cap_t'
	),
	'AES' => array(
		'MTD' => 'aes256',
		'PASSWORD' => 'supersecret',
		'IV' => 'sochetra12045637'
	),
	'HTTP' => array(
		'HTTPS' => 1,
		'ONLY' => 1,
		'DOMAIN' => 'clossdrive.com'
	),
	'HASH' => array(
		'TOKEN' => 32
	),
	'BASE' => array(
		'DIR' => '',
		'URL' => '',
		'STORAGE' => 'datacenter'
	)
);

spl_autoload_register(function($classes) {
	require_once 'classes/' . $classes . '.php';
});

require_once "functions/general.php";
require_once "functions/user.php";
require_once "functions/filemanager.php";
require_once "config/general.php";


?>
