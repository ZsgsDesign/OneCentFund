<?php

date_default_timezone_set('PRC');


$config = array(
	'rewrite' => array(
		//'admin/index.html' 	=> 'admin/main/index',
		//'admin/<c>_<a>.html'=> 'admin/<c>/<a>', 
		'account/<a>'				=> 'account/<a>',
		'user/<uid>'		=> 'user/info',
		'api/<a>'						=> 'api/<a>',
		'ajax/<a>'					=> 'ajax/<a>',
		'terms/<a>'					=> 'terms/<a>',
		'<a>'          			=> 'main/<a>',
		'/'               	=> 'main/index',
	),
);

$domain = array(
	"1cf" => array( // 调试配置
		'debug' => 1,
		'mysql' => array(
				'MYSQL_HOST' => 'localhost',
				'MYSQL_PORT' => '3306',
				'MYSQL_USER' => 'root',
				'MYSQL_DB'   => '1cf',
				'MYSQL_PASS' => 't3dv95my',
				'MYSQL_CHARSET' => 'utf8',
		),
	),
	"1cf.co" => array( //线上配置
		'debug' => 0,
		'mysql' => array(
				'MYSQL_HOST' => 'localhost',
				'MYSQL_PORT' => '3306',
				'MYSQL_USER' => 'root',
				'MYSQL_DB'   => '1cf',
				'MYSQL_PASS' => 't3dv95my',
				'MYSQL_CHARSET' => 'utf8',
		),
	),
	"www.1cf.co" => array( //线上配置
		'debug' => 0,
		'mysql' => array(
				'MYSQL_HOST' => 'localhost',
				'MYSQL_PORT' => '3306',
				'MYSQL_USER' => 'root',
				'MYSQL_DB'   => '1cf',
				'MYSQL_PASS' => 't3dv95my',
				'MYSQL_CHARSET' => 'utf8',
		),
	)
);
// 为了避免开始使用时会不正确配置域名导致程序错误，加入判断
if(empty($domain[$_SERVER["HTTP_HOST"]])) die("配置域名不正确，请确认".$_SERVER["HTTP_HOST"]."的配置是否存在！");

return $domain[$_SERVER["HTTP_HOST"]] + $config;