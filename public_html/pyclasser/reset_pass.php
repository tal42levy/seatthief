<?php
	error_reporting(E_ALL);
	ini_set('display_errors', 'On');
	function generatePassword() {
			$chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
			$count = mb_strlen($chars);

			for ($i = 0, $result = ''; $i < 8; $i++) {
					$index = rand(0, $count - 1);
					$result .= mb_substr($chars, $index, 1);
			}

			return $result;
	}

	if (isset($_REQUEST['user']) or isset($_REQUEST['email'])){
		$newpass = generatePassword();//Generate a random password
		$db = new PDO('sqlite:example.sqlite3');
		$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
		if (isset($_REQUEST['user'])){
			$user = $_REQUEST['user'];
			foreach($db->query('select email from users where user_id = ' . intval($_REQUEST['user'])) as $row){
				$email = $row['email'];
			}
		} else {
			$email = $_REQUEST['email'];	
			$results =$db->query('select user_id from users where email = "' . $email . '"'); 
			foreach($results as $row){
				$user = $row['user_id'];
			}
		}
		$sql = $db->prepare("update users set password = :newpass where user_id = :user");
		$sql->execute(array(':newpass' => md5($newpass), ':user' => intval($user)));
		$header = "To: " . $email . "\r\n From: info@seatthief.com ";
		if (mail($email, "Password reset request", "Hi! Somebody (hopefully you) requested that your password on Seat Thief be reset. We've changed your password accordingly. Your new password is: " . $newpass . " . You can login at www.seatthief.com and change your password to something else. \n\n Good luck!", $header)){
			echo '0';
			exit();
		} else {
			echo '1';
		}
	} else {
		echo "1";
	}

?>
