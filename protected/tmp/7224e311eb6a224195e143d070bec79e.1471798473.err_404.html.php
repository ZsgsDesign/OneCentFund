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
<!--
<div class="am-g am-container">
	<div style="margin-top:5rem;margin-bottom:5rem;">
		<center>
			<span class="am-icon-lg am-icon-warning" style="color:#F37B1D;font-size: xx-large;"></span>
			<h1 style="color:#c7254e;">404 PAGES NOT FOUND</h1>
			<hr>
			<p>不得了啦，页面走失啦！</p><small>没有找到你要的页面，三秒后返回主页，<a href="https://www.1cf.co">点此</a>立即返回</small>
		</center>
	</div>
</div>
-->

<div class="am-container">
	<article class="am-article">
    <div class="am-g">
      <div class="am-u-sm-12">
        <h2 class="am-text-center am-text-xxxl am-margin-top-lg">404. Not Found</h2>
        <p class="am-text-center">没有找到你要的页面哦<br><small><a href="/">返回主页</small></p>
        <center><pre class="page-404">          .----.
       _.'__    `.
   .--($)($$)---/#\
 .' @          /###\
 :         ,   #####
  `-..__.-' _.-\###/
        `;_:    `"'
      .'"""""`.
     /,  ya ,\\
    //  404!  \\
    `-._______.-'
    ___`. | .'___
   (______|______)
        </pre></center></a>
      </div>
    </div>
	</article>
</div>
<?php include $_view_obj->compile("footer.html"); ?>
</body>
</html>