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
				if (!$_SESSION['is_admin']){    ?>
					<script type="text/javascript"> window.location="index.php";</script>
				<?php
				}
				if (empty($_REQUEST['id'])){
					?>
					<script type="text/javascript"> window.location="admin_dash.php";</script>
				<?php
				}
				include "header.php";
				echo "<div class='hero-unit'>";
				echo '<form method="post" href="#">';
				
				$db = new PDO('sqlite:pyclasser/example.sqlite3');
			
				$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				$table = "user";
				$id = $_REQUEST['id'];
				$req = "DELETE from ".$table ."s where ".$table."_id = ".intval($id)." ;";

				$results = $db->prepare($req);
				echo "DELETE Statement: <br>";
				echo $req . "<br><br>";

				if (isset($_POST['button'])) {
					$results->execute();
					echo "<div class='alert alert-info'>User deleted. Return to <a href='admin_dash.php'>search page</a>";
				}

				?>
				<button name="button" class="btn">EXECUTE DELETE</button>
			</form>
		</div>
	</body>
</html>
