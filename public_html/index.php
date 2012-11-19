<!DOCTYPE html>
<html>
  <head>
    <title>Seat Thief</title>
    <!-- Bootstrap -->
    <link href="pyclasser/css/bootstrap.min.css" rel="stylesheet" media="screen">	
		<script type="text/javascript" src="pyclasser/jquery.min.js"></script>
		<script type="text/javascript" src="pyclasser/menus.js"></script>
		<?php 
			function make_dropdown($sel){
				$db = new PDO('sqlite:pyclasser/example.sqlite3');
				$req = 'select * from ' . $sel . ' order by "code" ASC';
				$rs = $db->query($req);
				foreach($rs as $row){
					$res = $row["code"];
					echo "<option value=\"" . $row['id'] . "\">" . $res . "</option><br>";
				}
			}
		?>
  </head>
	<body>
		<div class="navbar navbar-inverse">
			<div class="navbar-inner">
				<a class="brand" href="#">Seat Thief</a>
				<ul class="nav">
					<li class="active"><a href="#">Home</a></li>
				</ul>
			</div>
		</div>
		<div class="container">
			<div class="hero-unit">
				<h1> Seat Thief </h1>
				<p> Set up an alert for a class so you can snag any seat that opens up. </p>
				<form class="form" id="alert">
					<div class="control-group">
						<div class="container">
							<input type="text" placeholder="Email" id="email">
							<br>
						</div>
							<input type="text" placeholder="Phone" id="phone">
							<br>
						</div>
						<select id="deps">
							<option value="0">Department</option>
							<?php $sel = 'departments'; make_dropdown($sel);?>
						</select>
						<br>
						<select id="courses">
							<option value="0">Course</option>
							<?php $sel = 'courses';?>
						</select>
						<br>
						<select id="sects">
							<option value="0">Section</option>
							<?php $sel = 'sections'; ?>
						</select>
						<br>
						<input id="submit" class='btn btn-large btn-success' type="submit" value="Make My Alert!"/>
					</div>
				</form>
			</div>
		</div>
	</body>
</html>
