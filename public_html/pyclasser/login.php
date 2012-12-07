<?php
if (empty($_REQUEST['username'])){
	echo 1;
}
try {
	session_start();
	if (isset($_SESSION['time_failed'])){
		if ( time() - $_SESSION['time_failed'] > 600){
			session_unset();
			session_destroy();
			session_start();
		}
	}
	if (isset($_SESSION['num_attempts'])){
		if ($_SESSION['num_attempts'] >= 5){
			echo -1;
			exit();
		}
	}
	$db = new PDO('sqlite:example.sqlite3');
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
	$hash = md5($_REQUEST['password']);
	$usn = $_REQUEST['username'];
	foreach ($db->query("select user_id, password, is_admin from users where username = \"" . $usn . "\"") as $row){
		if ($row['password'] == $hash){
			$_SESSION['user_id'] = $row['user_id'];
			$_SESSION['is_admin'] = $row['is_admin'];
			$_SESSION['num_attempts'] = 0;
			echo "0"; 
		} else {
			if(empty($_SESSION['num_attempts'])){
				$_SESSION['num_attempts'] = 1;
			}else {
				$_SESSION['num_attempts'] += 1;
				if ($_SESSION['num_attempts'] >= 5){
					$_SESSION['time_failed'] = time();
				}
			}
			echo $_SESSION['num_attempts'];
		}
	}

} catch (Exception $e){
	echo $e->getMessage();
}?>
