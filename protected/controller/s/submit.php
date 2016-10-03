<?php
header('Cache-Control: no-cache, must-revalidate');
header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
header('Content-type: application/json');

/*
@param name string;
@param id string;
@param school string;
*/

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

if (!isset($_POST['name']) || !isset($_POST['id']) || !isset($_POST['school'])) exit(0);

$name=$_POST['name'];
$id=$_POST['id'];
$school=$_POST['school'];
$ip=getIP();
$date=date("Y-m-d");
$time=date("Y-m-d H:i:s");
require_once("conn.php");
$rs=$db->prepare("select * from stu where id=? or school=? or ip=?");
$rs->execute(
  array(
    $id,
    $school,
    $ip
  )
);
if (@$rs->rowCount) {
  $output['status']=0;
  $output['info']="每台设备/每名同学只能进行一次活动";
  echo json_encode($output);
  exit(0);
}



//////////////////////////
$score=0;/////////////Pending
$rs=$db->prepare("insert into stu (name,id,school,ip,date,time,score) values (?,?,?,?,?,?,?)");
$rs->execute(
  array(
    $name,
    $id,
    $school,
    $ip,
    $date,
    $time,
    $score
  )
);
if ($rs) {
  $output['status']=1;
  echo json_encode($output);
}