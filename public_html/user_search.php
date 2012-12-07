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
			error_reporting(E_ALL);
			session_start();
			if (!$_SESSION['is_admin']){    ?>
				<script type="text/javascript"> window.location="index.php";</script>
			<?php
			}
			include "header.php";
			
			$sql = "select user_id, username, phone, is_admin from users";
			$is_admin = empty($_REQUEST['isAdmin']) ? false : true;
			$sql = $sql . " WHERE 1 ";
			if ($is_admin) { $sql = $sql . "AND is_admin = 1"; }
			if (!empty($_REQUEST['username'])){
				$sql = $sql . " AND username LIKE :usr";
				$usn = '%'.$_REQUEST['username'].'%';
				$results->bindParam(':usr', $usn, PDO::PARAM_STR);
			}
			if (!empty($_REQUEST['username'])){
				$sql = $sql . " AND phone LIKE :phone";
				$phone ='%'.$_REQUEST['phone'].'%'; 
				$results->bindParam(':phone', $phone, PDO::PARAM_STR);
			}
			$db = new PDO('sqlite:pyclasser/example.sqlite3');
			
			$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$results = $db->prepare($sql);
			$results->execute();
?>
		<div class="hero-unit">
			<table border="1" class="table">
			<tr>
				<th>user id</th><th>username</th><th>phone</th><th>admin?</th>
			</tr>
			<?php
				foreach ($results->fetchAll() as $currentrow){
					echo "<tr>";
					$res = $currentrow["user_id"];
					echo "<td>" . $res . "</td>";
					$res = $currentrow["username"];
					echo "<td>" . $res . "</td>";
					$res = $currentrow["phone"];
					echo "<td>" . $res . "</td>";
					$res = $currentrow["is_admin"];
					echo "<td>" . $res . "</td>";
					echo "<td><a href='user_alerts.php?id=" . $currentrow["user_id"] . "'>DETAILS</a></td>";
					echo "<td><a href='edit_user.php?id=" . $currentrow["user_id"] ."'>EDIT</a></td>";
					echo "<td><a href='delete_user.php?id=" . $currentrow["user_id"] . "'>DELETE</a></td>";
					echo "</tr>";
				}
			?>
			</table>	
		</div>
	</body>
</html>
