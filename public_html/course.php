<!DOCTYPE html>
<html>
  <head>
    <title>Seat Thief</title>
    <!-- Bootstrap -->
    <link href="pyclasser/css/bootstrap.min.css" rel="stylesheet" media="screen">	
		<script type="text/javascript" src="pyclasser/jquery.min.js"></script>
		<script type="text/javascript" src="pyclasser/menus.js"></script>
		<script type="text/javascript" src="http://pagead2.googlesyndication.com/pagead/show_ads.js"></script>
		<script type="text/javascript">
			$(document).ready(function(){
				$("#setalert").click(function(){
					if (empty($_SESSION['user_id'])){
						$(".alert").remove();
						$("#setalert").after("<div class='alert alert-failure'>You must log in to set an alert</div>");
					} else {
						sec = ("#setalert").val();
						user = $SESSION['user_id'];
						if (sec != 0 && user) {
							$.post("pyclasser/submit.php", {department: department, course: course, section: sec, user:user}, function(retval){
								if (retval == 0){
									$("#setalert").after("<div class=\"alert alert-success\">Alert created</div>");
									//Alert was created. Handle
								}
							});
						} else {
							//Alert wasn't created
							$("#setalert").after("<div class=\"alert alert-error\">Something went wrong!</div>");
							$("#setalert").removeAttr("disabled");
						}
					}
				});
			});
		</script>
  </head>
	<body>
<?php
	error_reporting(E_ALL);
	ini_set('display_errors', 'On');
	include "header.php";
	if (empty($_REQUEST['id'])){
		echo "Sorry, something went wrong. Set up an alert at our <a href='index.php'>Home page</a>";
		exit();
	}

	$sql = "SELECT
							d.name, d.code as Department , d.id as d_id, 
							c.code as Code, c.title as Title, c.units, c.id as c_id,
							s.code as section, s.id as s_id, s.days, s.start, s.end, s.sect, s.reg as num_registered, s.seats as total_seats, s.instructor_ids, s.loc as Location
						FROM  sections s, courses c, departments d
						WHERE
						  c.id = s.course_id
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
				<th>Section</th><th>Units</th><th>Registered</th><th>Seats</th><th>Location</th><th>Days</th><th>Start</th><th>End</th>
			</tr>
			<?php
				$rows = $results->fetchAll();
				echo "<h3>Sections</h3><p>Displaying all sections for <a href='department.php?id=". $rows[0]['d_id'] . "'>" . $rows[0]['Department'] . "</a> <a href='course.php?id=". $rows[0]['c_id']. "'>". $rows[0]['Code'] . ": " . $rows[0]['Title'] . "</a>";
				foreach ($rows as $currentrow){
					echo "<tr>";
					$res = $currentrow["section"];
					echo "<td>" . $res . "</td>";
					$res = $currentrow["units"];
					echo "<td>" . $res . "</td>";
					$res = $currentrow["num_registered"];
					echo "<td>" . $res . "</td>";
					$res = $currentrow["total_seats"];
					echo "<td>" . $res . "</td>";
					$res = $currentrow["Location"];
					echo "<td>" . $res . "</td>";
					$res = $currentrow["days"];
					echo "<td>" . $res . "</td>";
					$res = $currentrow["start"];
					echo "<td>" . $res . "</td>";
					$res = $currentrow["end"];
					echo "<td>" . $res . "</td>";
					echo "</tr>";
				}
			?>
			</table>	
		</div>
	</body>
</html>	
