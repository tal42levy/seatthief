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
							 c.code as Code, c.id as c_id, c.title as Title, c.units , c.desc, c.id asc_id
						FROM  sections s, courses c, departments d
						WHERE
						  c.id = s.course_id
							AND d.id = c.department_id AND d.id = :id";
 	$db = new PDO('sqlite:pyclasser/example.sqlite3');
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);	
	$results = $db->prepare($sql);
	$results->bindParam(':id', intval($_REQUEST['id']), PDO::PARAM_INT);
	$results->execute();
?>
	<div class="hero-unit">
			<table border="1" class="table">
			<tr>
				<th>Course code</th><th>Units</th><th>Title</th><th>Description</th>
			</tr>
			<?php
				$rows = $results->fetchAll();
				echo "<h3>Sections</h3><p>Displaying all sections for " . $rows[0]['Department'] . " ". $rows[0]['Code']. ": " . $rows[0]['Title'];
				foreach ($rows as $currentrow){
					echo "<tr>";
					$res = $currentrow["Code"];
					echo "<td><a href=course.php?id=" . $currentrow["c_id"] . ">"  . $res . "</a></td>";
					$res = $currentrow["units"];
					echo "<td>" . $res . "</td>";
					$res = $currentrow["Title"];
					echo "<td>" . $res . "</td>";
					$res = $currentrow["desc"];
					echo "<td>" . $res . "</td>";
					echo "</tr>";
				}
			?>
			</table>	
		</div>
	</body>
</html>	

