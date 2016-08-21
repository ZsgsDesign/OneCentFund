<?php if(!class_exists("View", false)) exit("no direct access allowed");?><!DOCTYPE html>
<html>
<head lang="en">
  <meta charset="UTF-8">
  <title><?php if (@$title) : ?><?php echo htmlspecialchars($title, ENT_QUOTES, "UTF-8"); ?><?php else : ?>404<?php endif; ?> | 一分钱助学</title>
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
  <meta name="format-detection" content="telephone=no">
  <meta name="renderer" content="webkit">
  <meta http-equiv="Cache-Control" content="no-siteapp" />
  <link rel="alternate icon" type="image/png" href="/i/favicon.png">
  <link rel="stylesheet" href="/i/css/amazeui.min.css"/>
  <link rel="stylesheet" href="/i/css/ocf.css"/>
  <!--[if lt IE 9]>
	<script src="/i/js/jquery.1.11.1.min.js"></script>
	<script src="/i/js/modernizr.js"></script>
	<script src="/i/js/amazeui.ie8polyfill.min.js"></script>
	<![endif]-->

	<!--[if (gte IE 9)|!(IE)]><!-->
	<script src="/i/js/jquery.min.js"></script>
	<!--<![endif]-->
  <script src="/i/js/amazeui.min.js"></script>
  <script src="/i/js/ocf.js"></script>
</head>
<?php include $_view_obj->compile("topbar.html"); ?>
<?php include $_view_obj->compile($__template_file); ?>
<?php include $_view_obj->compile("footer.html"); ?>
</body>
</html>