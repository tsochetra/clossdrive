<style>
html,body {
	margin:0;
}
	:focus {
		outline: none;
	}
	input {
		width: 330px;
		height: 34px;
		padding: 10px;
		border: 2px solid transparent;
		border-bottom: 2px solid #1ab585;
		margin-top: 25px;
		margin-left: 15px;
		font-family: arial;
		font-size: 16px;
		color: #777;
		font-weight: bold;
		transition: .3s;
	}
	input#firstname {
		width: 155px;
	}
	input#lastname {
		width: 155px;
	}
	input:focus {
		background-color: #F0F0F0;
		border-bottom: 2px solid #1ab585;
	}
	input[type=submit] {
		background-color: #1ab585;
	}
	input[type=submit] {
		width: 150px;
		margin-left: 195px;
		line-height: 10px;
		color: #FFF;
	}
	.register {
		margin: 150px;
	}
	.password-progress {
		width: 330px;
		height: 5px;
		background-color: #F0F0F0;
	}
	.header {
		width: 100%;
		top: 0px;
		position: fixed;
		height: 50px;
		background-color: rgba(0,0,0,0.5);
	}

</style>
<div class="header"></div>
<div class="register">
<form method="POST" autocomplete="off">
	<input type="hidden" id="token" name="token" value="">
	<input type="text" name="firstname" id="firstname" autocomplete="off" value="" placeholder="First Name">
	<input type="text" name="lastname" id="lastname" autocomplete="off" value="" placeholder="Last Name"><br>
	<input type="text" name="email" id="email" autocomplete="off" value="" placeholder="Email Address"><br>
	<input type="password" name="password" autocomplete="off" id="password" placeholder="Password"><br>
	<input type="password" name="confirm_password" autocomplete="off" id="confirm_password" placeholder="Verify Password"><br>
	<input type="submit" name="submit">
</form>
</div>