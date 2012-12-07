<div class="navbar navbar-inverse">
	<div class="navbar-inner">
		<a class="brand" href="index.php">Seat Thief</a>
		<ul class="nav">
			<li class="active"><a href="index.php">Home</a></li>
		</ul>
		<ul class="nav pull-right">
			<?php 
				session_start();
				if (empty($_SESSION['user_id'])){
			?>
			<li><a href="login.php">Log in or Register</a></li>
			<?php } else {?>

			<li><a href="account.php">My account</a></li>
			<li><a href="login.php">Log Out</a></li>
			<?php if ($_SESSION['is_admin']) { ?>
			<li><a href="admin_dash.php">Admin Dashboard</a></li>
			<?php }
				} ?>
		</ul>
	</div>
</div>
