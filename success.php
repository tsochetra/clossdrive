<?php
require_once "config/init.php";
if (isset($_SESSION['register'])) {
unset($_SESSION['register']);
echo "please verify your email";
} else {
Redirect::to('register.php');
}
?>