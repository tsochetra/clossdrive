<?php 
require_once "config/init.php";
protected_not_login();
if (Input::exists()) {
	if (Token::check(Input::get("token"))) {
		if (Session::exists(Config::get("SESSION/HASH_LOGIN"))) {
			if (connection_status() == "CONNECTION_NORMAL") {
				$file = $_FILES['file']['name'];
				$tmp = $_FILES['file']['tmp_name'];
				$size = $_FILES['file']['size'];
				$type = $_FILES['file']['type'];
				$upload = new Upload($file, $tmp, $type, $size);
				if ($upload->start()) {
					echo "hoy";
				} else {
					echo "error";
				}
			}
		}
	}
}

?>

<form action method="POST" enctype="multipart/form-data">
	<input type="hidden" name="token" value="<?php echo Token::set(); ?>">
	<input type="file" name="file">
	<input type="submit" name="submit">
</form>