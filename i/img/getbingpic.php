<?php
//
// Function: 获取远程图片并把它保存到本地
//
//
// 确定您有把文件写入本地服务器的权限
//
//
// 变量说明:
// $url 是远程图片的完整URL地址，不能为空。
// $filename 是可选变量: 如果为空，本地文件名将基于时间和日期// 自动生成.
function GrabImage($url,$filename='') {
if($url==''):return false;endif;
$file = "bing.png";
unlink($file);
ob_start();
readfile($url);
$img = ob_get_contents();
ob_end_clean();
$size = strlen($img);
$fp2=@fopen($filename, 'a');
fwrite($fp2,$img);
fclose($fp2);
return $filename;
}
//$img=GrabImage('http://www.ccc.cc/static/image/common/logo.png','');
//if($img){echo '<pre><img src='.$img.'></pre>';}else{echo 'false';}
/*$fromurl="https://www.1cf.co/"; //跳转往这个地址
if( $_SERVER['HTTP_REFERER'] == "" )
{
header("Location:".$fromurl); exit;
}

if( $_SERVER['HTTP_REFERER'] == "" )
{
header("Location:".$fromurl); exit;
}
*/
$str = file_get_contents('http://www.bing.com/HPImageArchive.aspx?format=js&idx=0&n=1&mkt=zh-CN');
$array = json_decode($str);
$imgurl = $array->{"images"}[0]->{"url"};
$img=GrabImage('http://s.cn.bing.net'.$imgurl,'bing.png');
echo 'http://s.cn.bing.net'.$imgurl;
/*
$str=file_get_contents('http://cn.bing.com/HPImageArchive.aspx?idx=0&n=1');
if(preg_match("/<url>(.+?)<\/url>/ies",$str,$matches)){
	$imgurl='http://cn.bing.com'.$matches[1];
}

if($imgurl){
	$today = strtotime(date('Y-m-d', time()));
	$now=time();
	$end = $today + 24 * 60 * 60;
	$up=$end-$now;
	header('Content-Type: image/JPEG');
	header("HTTP/1.1 304 Not Modified"); 
	header('Cache-Control:public, max-age='.$up);
	header('Date:'.$today);
	@ob_end_clean();
@readfile("http://s.cn.bing.net{$imgurl}");
	@flush(); @ob_flush();
	exit();
}else{
	exit('error');
}*/
?>
