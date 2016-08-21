<?php
function getIP() {
  if (@$_SERVER["HTTP_X_FORWARDED_FOR"]) $ip = $_SERVER["HTTP_X_FORWARDED_FOR"]; 
	else if (@$_SERVER["HTTP_CLIENT_IP"]) $ip = $_SERVER["HTTP_CLIENT_IP"]; 
	else if (@$_SERVER["REMOTE_ADDR"]) $ip = $_SERVER["REMOTE_ADDR"]; 
	else if (@getenv("HTTP_X_FORWARDED_FOR")) $ip = getenv("HTTP_X_FORWARDED_FOR"); 
	else if (@getenv("HTTP_CLIENT_IP")) $ip = getenv("HTTP_CLIENT_IP"); 
	else if (@getenv("REMOTE_ADDR")) $ip = getenv("REMOTE_ADDR"); 
	else $ip = "Unknown"; 
	return $ip; 
}
function is_login() {
	$is_login=1;
 	if (!isset($_SESSION['uid']) || !isset($_SESSION['name']) || !isset($_SESSION['pass'])) {
		$is_login=0;
	}
	/*if ($is_login) {
		$sql="select * from users where uid=".$_SESSION['uid'];
		if ($rs = $db->query($sql)) {
			$row=$rs->fetch();
			if($row['pass']==$_SESSION['pass'])$is_login=1;
			else $is_login=0;
		} else {
			$is_login=0;
		}
	}*/
}