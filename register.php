<title>Register</title>
<?php
require_once "config/init.php";
protected_login();
require_once "templates/header.php";
require_once "templates/body.php";
protect_extension();
if (Input::exists()) {
	if (Token::check(Input::get("token"))) {
		$validate = new Validate();
		$validation = $validate->check($_POST, array(
			'email' => array(
				'required' => true,
				'email' => true,
				'min' => 10,
				'max' => 50,
				'unique' => 'user_email'
			),
			'username' => array(
				'required' => true,
				'min' => 6,
				'max' => 32,
				'escape' => true,
				'unique' => 'user_username'
			),
			'firstname' => array(
				'required' => true,
				'min' => 2,
				'max' => 32,
				'escape' => true
			),
			'lastname' => array(
				'required' => true,
				'min' => 2,
				'max' => 32,
				'escape' => true
			),
			'password' => array(
				'required' => true,
				'min' => 6,
				'max' => 32
			),
			'confirm_password' => array(
				'required' => true,
				'min' => 6,
				'max' => 32,
				'matches' => 'password'
			)
		));
		if ($validation->passed()) {
			$register = new Register(Input::get('firstname') . "," . Input::get('lastname'), Input::get('email'), Input::get('password'));
			if($register->start()) {
				//Session::set("register", "qwe");
				//Redirect::to("success.php");
			} else {
				echo 'register fail';
			}
		} else {
			foreach($validation->errors() as $error) {
			echo $error."<br>";
			}
		}

	}
}
?>
<!DOCTYPE html>
<html>
	<head>
		<script>
		$(document).ready(function () {

			$("#firstname").focus(function () {
				$("#firstname").attr("class", "focus");
			});
			$("#lastname").focus(function () {
				$("#lastname").attr("class", "focus");
			});
			$("#password").focus(function () {
				$("#password").attr("class", "focus");
			});
			$("#email").focus(function () {
				$("#email").attr("class", "focus");
			});
			$("#confirm_password").focus(function () {
				$("#confirm_password").attr("class", "focus");
			});
			$("#username").focus(function () {
				$("#username").attr("class", "focus");
			});
			$("#firstname").focusout(function () {
				$("#firstname").attr("class", "focusout");
			});
			$("#lastname").focusout(function () {
				$("#lastname").attr("class", "focusout");
			});
			$("#password").focusout(function () {
				$("#password").attr("class", "focusout");
			});
			$("#email").focusout(function () {
				$("#email").attr("class", "focusout");
			});
			$("#confirm_password").focusout(function () {
				$("#confirm_password").attr("class", "focusout");
			});
			$("#username").focusout(function () {
				$("#username").attr("class", "focusout");
			});

			$("form").submit(function() {
				return false;
			});
			$("form").submit(function() {
				var token = $("#token").val();
				var firstname = $("#firstname").val();
				var lastname = $("#lastname").val();
				var username = $("#username").val();
				var email = $("#email").val();
				var password = $("#password").val();
				var confirm_password = $("#confirm_password").val();
				$.ajax({
					type: "POST",
					url: "/account/register",
					data: {"token": token, "firstname": firstname, "lastname": lastname, "username": username, "email": email, "password": password, "confirm_password": confirm_password},
					success: function(data) {
						$("body").html(data);
					}
				});
			});
		});
		</script>
		<title>Register Your Clossworld Account</title>
		<style>
			body, html {
				margin:0;
				padding:0;
				font-family: arial;
				font-size: 14px;
				background-color: #FFF;
			}
			:focus {
				outline: none;
			}
			.register {
				top:100px;
				padding:100px;
				position:absolute;
			}
			.focus {
				border: 1px solid #FC0;
			}
			.focusout {
				border: 1px solid transparent;
			}
			.error {
				border: 1px solid #F00;
			}
			input {
				padding:5px;
				color: #FFF;
				margin-bottom:10px;
				width:250px;
				height:29px;
				border:1px solid transparent;
				background-color: rgba(0,0,0,0.2);
			}
			input[type=submit] {
				width: 262px;
				height: 34px;
				padding:5px;
			}
			input:focus {
				border: 1px solid #FC0;
			}
		</style>
	</head>
	<body>
		<div class="register">
			<form method="POST" autocomplete="off">
				<input type="hidden" id="token" name="token" value="<?php echo Token::set(); ?>">
				<input type="text" name="firstname" id="firstname" value="<?php echo Input::get("firstname"); ?>" placeholder="First Name">
				<input type="text" name="lastname" id="lastname" value="<?php echo Input::get("lastname"); ?>" placeholder="Last Name"><br>
				<input type="text" name="username" id="username" value="<?php echo escape_string(Input::get("username")); ?>" placeholder="Username"><br>
				<input type="text" name="email" id="email" value="<?php echo escape_email(Input::get("email")); ?>" placeholder="Email Address"><br>
				<input type="password" name="password" id="password" placeholder="Password"><br>
				<input type="password" name="confirm_password" id="confirm_password" placeholder="Confirm Password"><br>
				<input type="submit" name="submit">
			</form>
		</div>
	</body>

</html>
