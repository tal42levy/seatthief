<!DOCTYPE html>
<html>
  <head>
    <title>Seat Thief</title>
    <!-- Bootstrap -->
    <link href="pyclasser/css/bootstrap.min.css" rel="stylesheet" media="screen">	
		<script type="text/javascript" src="pyclasser/jquery.min.js"></script>
		<script type="text/javascript" src="pyclasser/menus.js"></script>
		<script type="text/javascript" src="http://pagead2.googlesyndication.com/pagead/show_ads.js"></script>
		<scrip type="text/javascript" src="pyclasser/menus.js"></script>
  </head>
	<body>
		<script type="text/javascript">
		$(document).ready(function(){
			//Simple script to generate SQL update statement
			$("#edit").submit(function(form){
				form.preventDefault();
				var department = $("#deps option:selected").attr("value");
				var course = $("#courses option:selected").attr("value");
				var sec = $("#sects option:selected").attr("value");
				console.log(sec);
				if (sec == 0){
					$(".alert").remove();
					$("#edit").after("<div class='alert alert-error'>Section is required for alerts</div>");
				} else {
					$.post("pyclasser/update_record.php", {id: $("#id").text(), department: department, section: sec, course:course, isactive:($('#isActive').is(':checked') ? 1 : 0)}, function(ret){
						console.log(ret);	
						if (ret == 0){
							$(".alert").remove();
							$("#edit").after("<div class='alert alert-success'>Alert updated</div>");
						}
					});
				}
			});
		});

		</script>
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
			echo '<div class="hero-unit">';
			echo '<form id="edit">';
			$db = new PDO('sqlite:pyclasser/example.sqlite3');
			
			$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$table = "user";
			$id = $_REQUEST['id'];
	
			$req = '
					SELECT
						d.name, d.id, d.code as Department,
						c.code as Code, c.title as Title, c.units, c.id as c_id,
						s.id as s_id, s.code as section, s.sect, s.reg as num_registered, s.seats as total_seats, s.instructor_ids, s.loc as Location,
						u.email, u.phone,
						a.alert_id as a_id, a.active
					FROM users u, alerts a, sections s, courses c, departments d
					WHERE a.user_id = u.user_id
						AND s.id = a.section_id
						AND c.id = s.course_id
						AND d.id = c.department_id		
				AND alert_id = ' . intval($id).";";
			$results = $db->query($req);
			function make_dropdown($sel, $target){
				$db = new PDO('sqlite:pyclasser/example.sqlite3');
				$req = 'select * from ' . $sel . ' order by "code" ASC';
				$rs = $db->query($req);
				foreach($rs as $row){
					$res = $row["code"];
					if ($res != $target){
						echo "<option value=\"" . $row['id'] . "\">" . $res . "</option><br>";
					}
				}
			}
			foreach($results->fetchAll() as $row){
				echo "You're editing an alert from user: " . $row['email'] . " (alert #<span id='id'> " . intval($id) . "</span>)";
			?>
					<div class="control-group">
						<label class="control-label">Department</label>
						<div class="controls">
							<select id="deps">
							<option value=<?php echo $row['id'] . "\">" . $row['Department'] . "</option>";?>
								<?php $sel = 'departments'; make_dropdown($sel, $row['Department']);?>
							</select>
						</div>
					</div>
					<div class="control-group">
						<label class="control-label">Course</label>
						<div class="controls">
							<select id="courses">
							<option value=<?php echo '"' . $row['c_id'] . '">' . $row['Code'] . '</option>';
								$sel = 'courses where department_id = ' . $row['id']; make_dropdown($sel, $row['Code']);?>
							</select>
						</div>
					</div>
					<div class="control-group">
						<label class="control-label">Section</label>
						<div class="controls">
							<select id="sects">
								<option value=<?php echo '"' . $row['s_id'] . '">' . $row['section'] . '</option>';
								$sel = 'sections where course_id = ' . $row['c_id']; make_dropdown($sel, $row['section']);?>
							</select>
						</div>
					</div>
			<?php
				echo "<input type='checkbox' id='isactive' value='isactive'" .($row['active']=='1'?"checked":"").">"."<label>Is Active?</label>";
				echo "";
			}
			?>
				<button type='submit' class='btn'>Submit</button>
			</form>
		</div>
	</body>
</html>

