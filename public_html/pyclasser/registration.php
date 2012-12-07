<?php
error_reporting(E_ALL);
ini_set('display_errors', 'On');
include "validation.php";
if (empty($_REQUEST['email'])){
	echo 1;
}
try {
	session_start();
	$db = new PDO('sqlite:example.sqlite3');
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
	$hash = md5($_REQUEST['password']);
	$email = $_REQUEST['email'];
	$phone = isset($_REQUEST['phone'])? $_REQUEST['phone'] : '0';
	if (!valid_email($email)){
		echo 'email1';
		exit();
	}
	if (!valid_phone($phone)){
		$phone = '0';
	}
	foreach ($db->query("select user_id, password, is_admin from users where email = \"" . $email . "\"") as $row){
		if (isset($row['password'])){
			echo '2';
			exit();
		} else {
			$sql = "update users set password = \"" . $hash . "\" where email = \"" . $email . "\"";
			$db->exec($sql);
			echo '0';
			exit();
		}
	}
	$sql = $db->prepare("insert into users (email, username, phone, password) values (:email, :email, :phone, :password);");
	$sql->execute(array(':email' => $email, ':phone' => $phone, ':password' =>$hash));
} catch (Exception $e){
	echo $e->getMessage();
}?>
