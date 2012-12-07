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
		<?php include "header.php";?>
		<script type="text/javascript"><!--
			google_ad_client = "ca-pub-8836924644544461";
			/* Test */
			google_ad_slot = "2508507691";
			google_ad_width = 728;
			google_ad_height = 90;
			//-->
		</script>
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
		<div class="container">
			<div class="hero-unit">
				<h1> Seat Thief </h1>
				<p> Set up an alert for a class so you can snag any seat that opens up. Seat Thief currently only serves USC.</p>
				<form class="form-horizontal" id="alert">
					<div class="control-group">
						<label class="control-label" for="email">Email</label>
						<div class="controls">
							<input type="text" placeholder="Email" id="email">
						</div>
					</div>
					<div class="control-group">
						<label class="control-label" for="phone">Phone</label>
						<div class="controls">
							<input type="text" placeholder="Phone" id="phone">
						</div>
					</div>
					<div class="control-group">
						<label class="control-label">Department</label>
						<div class="controls">
							<select id="deps">
								<option value="0">Department</option>
								<?php $sel = 'departments'; make_dropdown($sel);?>
							</select>
						</div>
					</div>
					<div class="control-group">
						<label class="control-label">Course</label>
						<div class="controls">
							<select id="courses">
								<option value="0">Course</option>
								<?php $sel = 'courses';?>
							</select>
						</div>
					</div>
					<div class="control-group">
						<label class="control-label">Section</label>
						<div class="controls">
							<select id="sects">
								<option value="0">Section</option>
								<?php $sel = 'sections'; ?>
							</select>
						</div>
					</div>
						<div class="controls">
							<input id="submit" class='btn btn-large btn-success' type="submit" value="Make My Alert!"/>
						</div>
					</div>
				</form>
			</div>
		</div>
	</body>
</html>
