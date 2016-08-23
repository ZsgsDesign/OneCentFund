<?php
class db {
	public $host='localhost';
	public $username='root';
	public $password='t3dv95my';
	public $dbname='1cf';
}
//连接数据库
$db=new db();
$dsn = "mysql:host=".$db->host.";dbname=".$db->dbname.";charset=utf8";
$db = new PDO($dsn, $db->username, $db->password);
date_default_timezone_set('Asia/Shanghai');
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