<?php if(!class_exists("View", false)) exit("no direct access allowed");?><!doctype html>
<html>
<head>
  <meta charset="utf-8" />
  <meta name="apple-touch-fullscreen" content="yes" />
  <title>404 | 一分钱助学</title>
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


        <style>
            body {
                margin: 0;
                padding: 0;
                text-align: center;
                overflow: auto;
            }
            #screen {
                display: inline-block;
                max-height:80%;
            }
        </style>
    </head>
    <body>
<?php include $_view_obj->compile("topbar.html"); ?>
<div class="am-container">
	<article class="am-article">
    <div class="am-g">
      <div class="am-u-sm-12 am-u-md-7">
        <h2 class="am-text-center am-text-xxxl am-margin-top-lg">404. Not Found</h2>
        <p class="am-text-center">没有找到你要的页面哦</p>
        <p><small><a href="/">返回主页</small></a></p>
        <p><small><a href="#screen">居中屏幕</small></a></p>
        <a href="/">
        <center><pre class="page-404">
          .----.
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
      <div class="am-u-sm-12 am-u-md-5">
        <div id="screen"></div>
      </div>
    </div>
	</article>
</div>
<?php include $_view_obj->compile("footer.html"); ?>
</body>
</html>
        <script src="/i/404/phaser.min.js"></script>
        <script src="/i/404/main.js"></script>
        <script>
            initGame({
                feedback: '"5"可奉告',
                feedbackFunc: function() {
                    window.open('https://github.com/tusenpo/FlappyFrog/issues');
                },
                parent: document.querySelector('#screen')
            });
        </script>
    </body>
</html>



