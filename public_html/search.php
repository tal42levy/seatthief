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
				include 'header.php';
				if (empty($_REQUEST['query'])){
					echo "<div class='alert alert-info'> No results found! </div>";
					exit();
				}
				$db = new PDO('sqlite:pyclasser/example.sqlite3');
				$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);	
				echo '<div class="hero-unit">';
				$sql = "SELECT d.name, d.code as Department, d.id as d_id from departments d where d.name like :query or d.code = :query";
				$results = $db->prepare($sql);
				$query = "%".$_REQUEST['query']."%";
				$results->bindParam(':query', $query, PDO::PARAM_STR);
				$results->execute();
				$rows = $results->fetchAll();
				if (count($rows) > 0){
?>
			<h3>Departments </h3>
			<table border="1" class="table">
				<tr>
					<th>Name</th><th>Code</th>
				</tr>
				<?php
					foreach ($rows as $currentrow){
						echo "<tr>";
						$res = $currentrow["name"];
						echo "<td><a href=department.php?id=" . $currentrow["d_id"] . ">"  . $res . "</a></td>";
						$res = $currentrow["Department"];
						echo "<td>" . $res . "</td>";
						echo "</tr>";
					}
				?>
			</table>


<?php }?>
<?php

				$sql = "SELECT
							d.name, d.code as Department , d.id as d_id,
							 c.code as Code, c.id as c_id, c.title as Title, c.units , c.desc, c.id asc_id
						FROM courses c, departments d
						WHERE
							d.id = c.department_id AND c.title LIKE :query";
				$results = $db->prepare($sql);
				$query = "%".$_REQUEST['query']."%";
				$results->bindParam(':query', $query, PDO::PARAM_STR);
				$results->execute();
				$rows = $results->fetchAll();
				if (count($rows) > 0){
			?>
			<h3> Courses </h3>
			<table border="1" class="table">
				<tr>
					<th>Course code</th><th>Units</th><th>Title</th><th>Description</th>
				</tr>
				<?php
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
			<?php }?>

		</div>
	</body>
</html>
