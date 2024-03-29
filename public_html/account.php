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
			if (empty($_SESSION['user_id'])){    ?>
				<script type="text/javascript"> window.location="index.php";</script>
			<?php
			}
			include "header.php";
			$sql = "SELECT
							d.name, d.code as Department , d.id as d_id,
							c.code as Code,c.id as c_id, c.title as Title, c.units, 
							s.code as section, s.sect, s.reg as num_registered, s.seats as total_seats, s.instructor_ids, s.loc as Location,
							u.email, u.phone,
							a.alert_id, a.active
						FROM users u, alerts a, sections s, courses c, departments d
						WHERE a.user_id = u.user_id
							AND s.id = a.section_id
							AND c.id = s.course_id
							AND d.id = c.department_id AND a.user_id = :id";
			$db = new PDO('sqlite:pyclasser/example.sqlite3');
			
			$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
			$results = $db->prepare($sql);
			$id = $_SESSION['user_id'];
			$results->bindParam(':id', $id, PDO::PARAM_INT);
			$results->execute();
			$rows = $results->fetchAll();
			if (count($rows) == 0){
				echo "<h1> You don't have any alerts! Go <a href='index.php'>set some!</a></h1>";
				exit();
			}
?>
		<div class="hero-unit">
			<table border="1" class="table">
			<tr>
				<th>Department</th><th>Course code</th><th>Title</th><th>Units</th><th>Section</th><th>Num Registered</th><th>Seats</th><th>Location</th><th>Active?</th>
			</tr>
			<?php
				echo "<h3>My Alerts</h3><p>Displaying all alerts for " . $rows[0]['email'];
				foreach ($rows as $currentrow){
					echo "<tr>";
					$res = $currentrow["Department"];
					echo "<td><a href='department.php?id=" . $currentrow['d_id'] . "'>" . $res . "</a></td>";
					$res = $currentrow["Code"];
					echo "<td><a href='course.php?id=" . $currentrow["c_id"] . "'>" . $res . "</a></td>";
					$res = $currentrow["Title"];
					echo "<td>" . $res . "</td>";
					$res = $currentrow["units"];
					echo "<td>" . $res . "</td>";
					$res = $currentrow["section"];
					echo "<td>" . $res . "</td>";
					$res = $currentrow["num_registered"];
					echo "<td>" . $res . "</td>";
					$res = $currentrow["total_seats"];
					echo "<td>" . $res . "</td>";
					$res = $currentrow["Location"];
					echo "<td>" . $res . "</td>";
					$res = $currentrow["active"];
					echo "<td>" . $res . "</td>";
					echo "<td><a href='edit_alert.php?id=" . $currentrow["alert_id"] ."'>EDIT</a></td>";
					echo "<td><a href='delete_alert.php?id=" . $currentrow["alert_id"] . "'>DELETE</a></td>";
					echo "</tr>";
				}
			?>
			</table>	
		</div>
	</body>
</html>	

