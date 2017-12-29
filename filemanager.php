<?php
require_once "config/init.php";
protected_not_login();
require_once "templates/header.php";
?>
<body>
<div class="overall">
	<div class="header"></div>
	<div class="file-manager">
		<div class="left-manager">

		</div>
		<div class="right-manager">
			<?php 
				get_file();
			?>
		</div>
	</div>
</div>

</body>