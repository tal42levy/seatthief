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
	include "header.php";
	if (empty($_REQUEST['id'])){
		echo "Sorry, something went wrong. Set up an alert at our <a href='index.php'>Home page</a>";
		exit();
	}

	$sql = "SELECT
							d.name, d.code as Department ,
							c.code as Code, c.title as Title, c.units, 
							s.code as section, s.sect, s.reg as num_registered, s.seats as total_seats, s.instructor_ids, s.loc as Location,
						FROM  sections s, courses c, departments d
						WHERE
							AND s.id = a.section_id
							AND c.id = s.course_id
							AND d.id = c.department_id AND c.id = :id";
 	$db = new PDO('sqlite:pyclasser/example.sqlite3');
			
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);	
	$results = $db->prepare($sql);
	$results->bindParam(':id', intval($_REQUEST['id']), PDO::PARAM_INT);
	$results->execute();
?>
	<div class="hero-unit">
			<table border="1" class="table">
			<tr>
				<th>Section</th><th>Num Registered</th><th>Seats</th><th>Location</th><th>Active?</th>
			</tr>
			<?php
				$rows = $results->fetchAll();
				echo "<h3>Alerts</h3><p>Displaying all sections for " . $rows[0]['Department'] . " " $rows[0]['Code'];
				foreach ($rows as $currentrow){
					echo "<tr>";
					$res = $currentrow["Department"];
					echo "<td>" . $res . "</td>";
					$res = $currentrow["Code"];
					echo "<td>" . $res . "</td>";
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