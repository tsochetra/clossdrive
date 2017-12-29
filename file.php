<?php
require_once "config/init.php";
protected_not_login();
require_once "templates/header.php";
?>
<body>
<div class="overall">
	<div class="header">
		<div class="wrap-header">
			<a href="/" class="logo-href"><div class="logo-header"></div>Clossdrive</a>
			<div class="account-header">
				<a class="register-header" href="/account/register">Register</a>
				<a class="login-header" href="/account/login">Login</a>
			</div>
		</div>
	</div>
	<div class="file-manager">
		<div class="left-manager">

		</div>
		<div class="right-manager">
			<div class="bt-manager">
			</div>
				<div class="wrapper scrollbar-dynamic file-list">
				<?php get_file(); ?>
				</div>
		</div>
	</div>
</div>

</body>