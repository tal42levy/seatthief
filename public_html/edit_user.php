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
		<script type="text/javascript">
		$(document).ready(function(){
			//Simple script to generate SQL update statement
			$("#edit").submit(function(form){
				form.preventDefault();
				console.log($("#id").text());
				$.post("pyclasser/update_record.php", {id: $("#id").text(), email: $("#email").val(), phone: $("#phone").val(), isadmin:($('#isAdmin').is(':checked') ? 1 : 0)}, function(ret){
					console.log(ret);	
					if (ret == 0){
						$("#edit").after("<div class='alert alert-success'>User updated</div>");
					}
				});
			});
			$("#reset").click(function(){
				//Reset pass	
				$.post("reset_pass.php", {user: $("#id").text()}, function(ret){
					if (ret != 0){
						//This shouldn't happen. Something's probably up with the database.
						console.log("Something bad happened.");
					}
				});
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
	
			$req = 'select * from users where user_id = ' . intval($id).";";
			$results = $db->query($req);
			foreach($results->fetchAll() as $row){
				echo "You're editing the user: " . $row['email'] . " (user <span id='id'> " . intval($id) . "</span>)";
				echo "<br><label>Email</label><input type='text' id='email' value='".$row['email']."'>";
				echo "<label>Phone</label><input type='text' id='phone' value='".$row['phone']."'>";
				echo "<br><input type='checkbox' id='isadmin' value='isadmin'" .($row['is_admin']=='1'?"checked":"").">"."<label>Is Admin?</label>";
				echo "<button type='submit' class='btn'>Submit</button>";
				echo "<button class='btn' id='reset'>Reset password</button>";
			}
			?>
			</form>
		</div>
	</body>
</html>
