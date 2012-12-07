
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
		<?php session_start();
			if (!empty($_SESSION['user_id'])){
				session_destroy();
				$flag = 1;
			}
			include "header.php";
			if ($flag){
				echo "<div class='alert alert-info'>You have been logged out</div>";
			}
		?>
		<script type="text/javascript"><!--
			google_ad_client = "ca-pub-8836924644544461";
			/* Test */
			google_ad_slot = "2508507691";
			google_ad_width = 728;
			google_ad_height = 90;
			//-->
		</script>
		<div class="container">
			<div class="hero-unit">
				<h1> Log In </h1><br>
				<form class="form-horizontal" id="login">
					<input type="text" class="input" id ="email" placeholder="Email"><br>
					<input type="password" class="input" id="password" placeholder="Password">
					<label class="checkbox">
						<input type="checkbox"> Remember me
					</label>
					<button type="submit" class="btn" id="sign_btn">Sign in</button>
					<p>No account? Click <a href="register.php">here</a> to register!</p><br>
				</form>
				<form class="form-horizontal" id="reset">
					<p>Forgotten password? Enter your email below and we'll send you an email to reset your password:</p>
					<input type="text" class="input" id="remail">
					<button class="btn" type="submit" id="reset_btn">Reset</button>
					
				</form>
			</div>
		</div>
		<script type="text/javascript">
			$(document).ready(function(){
				$("#login").submit(function(form){
					form.preventDefault();
					$("#submit").attr('disabled','disabled');
					var username = $("#email").val();
					var password = $("#password").val();
					$.post("pyclasser/login.php", {username: username, password: password}, function(retval){
						console.log($.parseJSON(retval));
						if (retval == 0){
							window.location = "index.php";
						} else if (retval == 1) {
							$(".alert").remove();
							$("#password").after('<div class="alert alert-error">Wrong email or password!</div>');
						} else {
							$(".alert").remove();
							$("#password").after('<div class="alert alert-error">Too many failed login attempts</div>');
						}
					});
				});
				$("#reset").submit(function(form){
					form.preventDefault();
					$.post("pyclasser/reset_pass.php", {email: $("#remail").val()}, function(ret){
						if (ret != 0){
							$(".alert").remove();
							$("#reset").after('<div class="alert alert-error">Something went wrong!</div>');
						} else {
							$(".alert").remove();
							$("#reset").after('<div class="alert alert-success">We just sent you an email with your new password!</div>');
						}
					});
				});
			});
			</script>
	</body>
</html>
