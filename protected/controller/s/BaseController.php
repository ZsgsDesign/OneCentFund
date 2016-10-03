<?php
class BaseController extends Controller{
	function init(){
		session_start();
		header("Content-type: text/html; charset=utf-8");
	}

  function tips($msg, $url){
    $url = "location.href=\"{$url}\";";
		echo "<html><head><meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\"><script>function sptips(){alert(\"{$msg}\");{$url}}</script></head><body onload=\"sptips()\"></body></html>";
		exit;
  }
  function jump($url, $delay = 0){
    echo "<html><head><meta http-equiv='refresh' content='{$delay};url={$url}'></head><body></body></html>";
    exit;
  }
	
	public static function err404($controller_name, $action_name){
		header("HTTP/1.0 404 Not Found");
		//echo $controller_name."<br>".$action_name;
		//echo "<BR>".arg("username");
		$controlObj = new BaseController;
		$controlObj->display("404/index.html");
		//$controlObj->jump("/");
		exit;
	}
} 