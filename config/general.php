<?php
//set error 
//error_reporting(0);

//set sessions
Session::start();
$login = new Secure();
$login->session();

//set time zone for users
date_default_timezone_set(IP::get('timezone'));

//check for unique visitors
Cookie::unique_visitor();

//set users language
Cookie::set_session(Config::get("COOKIE/LOCALE"), "EN");

//protect php extension
//protect_extension();

if (!isset($_SERVER["HTTP_REFERER"]) && $_SERVER["REQUEST_URI"] == "/" && Session::exists(Config::get("SESSION/HASH_LOGIN"))) {
	Redirect::to("/files");
}
?>