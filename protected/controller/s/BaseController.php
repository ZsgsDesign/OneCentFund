<?php
class BaseController extends Controller{
	function init(){
		session_start();
		header("Content-type: text/html; charset=utf-8");
		require(APP_DIR.'/protected/include/functions.php');
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
	
} 