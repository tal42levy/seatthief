<!DOCTYPE html>
<html>
  <head>
    <title>Seat Thief</title>
    <!-- Bootstrap -->
    <link href="pyclasser/css/bootstrap.min.css" rel="stylesheet" media="screen">	
		<script type="text/javascript" src="pyclasser/jquery.min.js"></script>
		<script type="text/javascript" src="pyclasser/menus.js"></script>
		<script type="text/javascript" src="http://pagead2.googlesyndication.com/pagead/show_ads.js"></script>
  </head>
	<body>
		<?php 
		session_start();
		if (!$_SESSION['is_admin']){?>
			<script type="text/javascript"> window.location="index.php";</script>
		<?php
		}
			include "header.php";
		?>
		<div class="hero-unit">
			<h3>Users</h3>
			<form action="user_search.php">
				Username: <input type="text" name="username" />
				
				Phone: <input type="text" name="phone" />

				Admin? <input type="checkbox" name='isAdmin' value='Yes' />
				<input type="submit" value="Search"/>
			</form>
		</div>
	</body>
</html>
