<?php
	@session_start();
	include_once('thit.db.operate.php');
    $dsn = "mysql:host=localhost;dbname=1cf";
	$db = new PDO($dsn, 'root', 't3dv95my');
	$thdb=new TianhaiPdoMysql($db);
	$db->query('set names utf8;');
	date_default_timezone_set('PRC');
	function getIP() { 
		if (@$_SERVER["HTTP_X_FORWARDED_FOR"]) 
			$ip = $_SERVER["HTTP_X_FORWARDED_FOR"]; 
		else if (@$_SERVER["HTTP_CLIENT_IP"]) 
			$ip = $_SERVER["HTTP_CLIENT_IP"]; 
		else if (@$_SERVER["REMOTE_ADDR"]) 
			$ip = $_SERVER["REMOTE_ADDR"]; 
		else if (@getenv("HTTP_X_FORWARDED_FOR"))
			$ip = getenv("HTTP_X_FORWARDED_FOR"); 
		else if (@getenv("HTTP_CLIENT_IP")) 
			$ip = getenv("HTTP_CLIENT_IP"); 
		else if (@getenv("REMOTE_ADDR")) 
			$ip = getenv("REMOTE_ADDR"); 
		else 
			$ip = "Unknown"; 
		return $ip; 
	}

?>