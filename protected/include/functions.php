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
  if ($loginid=arg("loginid")) {
    $this->loginid=$loginid;
    $is_login=validate_loginid($loginid,"app");
  } else if (!@$_SESSION['loginid']) {
		$is_login=0;
	} else {
    $is_login=validate_loginid($_SESSION['loginid'],"browser");
    $this->loginid=$_SESSION['loginid'];
  }
  return $is_login;
}

function validateapi($time='',$secret='') {
  $task=arg("a");
	if(!$task || !$time || !$secret) {
		$output=array(
      'status'=>0,
      'info'=>"Invalid post."
    );
    echo json_encode($output);
		exit;
	}
	$secret2=sha1($task."7d3cfe8c4ecbdad6539e0b8d50d91215".$time);
	if ($secret!=$secret2) {
		$output=array(
      'status'=>0,
      'info'=>"Unauthorized post."
    );
    echo json_encode($output);
		exit;
	}
}
function validate_loginid($loginid,$mode='browser') {
  $user_db=new Model("users");
  $result=$user_db->find(array("loginid = :loginid", 
															":loginid" => $loginid
												));
	if (empty($result)) {
    if ($mode=="app") {
      $output=array(
        'status'=>0,
        'info'=>'invalid loginid'
      );
      echo json_encode($output);
      exit;
    } else return 0;
  }
  else return 1;
}