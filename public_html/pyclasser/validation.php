<?php	
	function valid_email($email){
		if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
			return true;
		}
		return false;
	}

	function valid_phone($phone){
		return is_numeric($phone) && strlen($phone) == 10;
	}

	function find_user_id($db, $email){
		$sql = $db->prepare('select user_id from users where email = :email');
		$sql->execute(array(':email'=>$email));
		$ret = $sql->fetchAll();
		return $ret;

	}
?>
