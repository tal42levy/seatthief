<?php
include "validation.php";
error_reporting(E_ALL);
ini_set('display_errors', 'On');
session_start();
if ($_SESSION['is_admin'] && isset($_REQUEST['isadmin'])){
	$db = new PDO('sqlite:example.sqlite3',"","", array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_WARNING));
	$sql = $db->prepare("update users set email = :email, username = :email, phone = :phone, is_admin = " . (($_REQUEST['isadmin']) ? 1 : 0) . " where user_id = :id;");
	if (!valid_email($_REQUEST['email'])){
		echo 'email0';
		exit();
	}
	$email = $_REQUEST['email'];
	if (!valid_phone($_REQUEST['phone'])){
		$phone = "1234567890";
	} else {
		$phone = $_REQUEST['phone'];
	}
	$sql->execute(array(':email'=>$email, ':phone' => $phone, ':id' => intval($_REQUEST['id'])));
	echo "0";
} else if ($_SESSION['is_admin'] && isset($_REQUEST['isactive'])){
	$db = new PDO('sqlite:example.sqlite3',"","", array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION));
	$sql = $db->prepare("update alerts set section_id = :section, active = ". (($_REQUEST['isactive']) ? 1 : 0) . " where alert_id = :id;");
	$sql->execute(array(':section'=>intval($_REQUEST['section']), ':id' => intval($_REQUEST['id']))); //All inputs are ints, intval prevents injection
	echo "0";
}else{
	echo "fail";
}
?>
