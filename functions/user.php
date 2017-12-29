<?php

function protected_login() {
	if (Session::exists(Config::get("SESSION/HASH_LOGIN"))) {
		Redirect::to("/files");
	}
}

function protected_not_login() {
	if (!Session::exists(Config::get("SESSION/HASH_LOGIN"))) {
		Redirect::to("/account/login");
	}
}
?>