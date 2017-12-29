<?php
require_once "config/init.php";
protected_login();
//require_once "templates/header.php";
if (Input::exists()) {
	if (Token::check(Input::get('token'))) {
		$validate = new Validate();
		$validation = $validate->check($_POST, array(
			'email' => array(
				'required' => true,
				'min' => 5,
				'max' => 64
			),
			'password' => array(
				'required' => true,
				'min' => 5,
				'max' => 64
			)
		));
		
		if ($validation->passed()) {
			$remember = (Input::get("check") == 'on') ? true : false;
			$login = new Login(Input::get('email'), Input::get('password'), $remember);
			if($login->start()) {
				header("Location: /files");
			} else {
				echo "email or password incorrect";
			}
		} else {
			foreach($validation->errors() as $error) {
				echo $error;
			}
		}
	}
}
?>
<?php
$cap = new Captcha();
$login = $cap->login();
if($login === 3) {
echo "disable";
} else {
?>
<form action method="post">
	<input type="hidden" name="token" value="<?php echo Token::set(); ?>">
	<input type="text" name="email" id="email">
	<input type="password" name="password" id="password">
	<input type="checkbox" name="check" checked="checked">remember
	<input type="submit" name="submit">
	<?php if($login === 2){echo "captcha";} ?>
</form>
<?php
}
?>

