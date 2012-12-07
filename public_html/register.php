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
			} else {
				$flag = 0;
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
				<h1> Register </h1><br>
				<p> Have you already set a Seat Thief alert before? If so, set up an account with the same email</p>
				<form class="form-horizontal" id="register">
					Email:<input type="text" class="input" id ="email" placeholder="Email"><br><br>
					Phone: <input type="text" class="input" id="phone" placeholder="Phone (optional)"><br><br>
					Password: <input type="password" class="input" id="password" placeholder="Password"><br><br>
					Confirm: <input type="password" class="input" id="passconf" placeholder="Confirm Password"><br><br>
					<button type="submit" class="btn">Register!</button>
				</form>
			</div>
		</div>
		<script type="text/javascript">
			$(document).ready(function(){
				$("#register").submit(function(form){
					form.preventDefault();
					if ($("#password").val() != $("#passconf").val()){
						$(".alert").remove();
						$("#passconf").after('<div class="alert alert-error">Passwords don\'t match!</div>');
					} else if (!validateEmail($("#email").val())) {
						$(".alert").remove();
						$("#email").after('<div class="alert alert-error">Invalid email!</div>');
					} else {
						console.log("submit");
						$.post("pyclasser/registration.php", {email: $("#email").val(), phone: $("#phone").val(), password: $("#password").val() }, function(retval){
							console.log(retval);
							if (retval == 2){
								$(".alert").remove();
								$("#email").after("<div class='alert alert-error'>There is already an account registered under this email!</div>");
							} else if (retval == 0){
								$(".btn").attr("disabled", "disabled");
								$(".alert").remove();
								$(".btn").after("<div class='alert alert-success'>Account created! You can now <a href='login.php'>log in</a></div>");
							}
						});
					}
				});
			});
		</script>
	</body>
</html>
