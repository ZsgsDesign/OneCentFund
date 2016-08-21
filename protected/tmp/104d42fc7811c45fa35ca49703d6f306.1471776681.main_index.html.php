<?php if(!class_exists("View", false)) exit("no direct access allowed");?><!DOCTYPE html>
<html>
<head lang="zh-cn">
  <meta charset="UTF-8">
  <title>快速模式 | 一分钱助学</title>
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport"
        content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
  <meta name="format-detection" content="telephone=no">
  <meta name="renderer" content="webkit">
  <meta http-equiv="Cache-Control" content="no-siteapp"/>
  <META HTTP-EQUIV="Pragma" CONTENT="no-cache">
  <META HTTP-EQUIV="Cache-Control" CONTENT="no-cache">
  <META HTTP-EQUIV="Expires" CONTENT="0">
	<script src="/i/js/ua.js"></script>
  <link rel="alternate icon" type="image/png" href="/i/favicon.png">
  <link rel="stylesheet" href="/i/css/amazeui.min.css"/>
  <link rel="stylesheet" href="/i/css/ocf.css"/>
  <style>
	body{
	  background: url(/i/img/bing.png) top center no-repeat fixed;
	  background-size: cover;
	}
	.am-container {max-width:1200px !important;}
	.wrong {
	  background-color: rgba(221, 81, 76, 0.9);
	}
	.correct {
	  background-color: rgba(74, 170, 74, 0.9);
	}
	.staff {
	  background-color: rgba(10, 105, 153, 0.9);
	}
	.ocf-btn-float {
	  position: fixed;
	  right: 2rem;
	  bottom: 2rem;
	  z-index: 999;
	}
	.grantee {
		color:#000;
		padding:1rem 0 1rem 0;
	}

	.goal {
		color:#000;
		padding:1rem 0 1rem 0;
	}

	.tip {
		margin-top:2rem;
		border-top:1px solid #ddd;
		border-bottom:none;
		padding-top:1rem;
	}

	.grantee-info {
		margin-top:0;
	}

	.grantee-image-container {
		overflow: hidden;
		border: 1px rgba(0,0,0,.1) solid;
	}

	.grantee-image {
		margin-top:0;
        transition:All 2s ease-in-out;
        -webkit-transition:All 2s ease-in-out;
        -moz-transition:All 2s ease-in-out;
        -o-transition:All 2s ease-in-out;
		-webkit-filter: grayscale(0.7); /* Chrome, Opera */
		   -moz-filter: grayscale(0.7);
			-ms-filter: grayscale(0.7);
				filter: grayscale(0.7);
	}

    .grantee-image:hover {
        transform:scale(1.15);
        -webkit-transform:scale(1.15);
        -moz-transform:scale(1.15);
        -o-transform:scale(1.15);
        -ms-transform:scale(1.15);
		-webkit-filter: none; /* Chrome, Opera */
		   -moz-filter: none;
			-ms-filter: none;
				filter: none;
    }

	@media screen and (max-width:640px) {
		.grantee-info {
			border-left:none;

			padding-top:2rem;
		}

		.tip {
		margin-top:2rem;
		border-top:1px solid #ddd;
		border-bottom:1px solid #ddd;
		}

		.grantee-image {
			/*margin-top:1rem;*/
		}
	}
.height-set {height:30px;}
.am-topbar-btn {margin-top:9px;}
.am-nav>li>a:focus, .am-nav>li>a:hover {text-decoration: none;background-color: #FFF;}
.ocf-cover-img {
	background: url(/i/img/bing.png) top center no-repeat fixed;
	background-size: cover;
	height:100%;
	color:#fff;
	text-shadow: #000 2px 2px 2px;
	padding:3rem;
}
.ocf-cover-name {
	position:absolute;
	text-align:left;
	bottom:3rem;
	left:3rem;
}
.ocf-cover-name > a {color:#fff; text-decoration:none;}
.ocf-cover-name > a:hover {color:#fff; text-decoration:none;}
.ocf-cover-name > a:active {color:#fff; text-decoration:none;}
.ocf-cover-name > a:focus {color:#fff; text-decoration:none;}
.ocf-cover-name > a:visited {color:#fff; text-decoration:none;}
.ocf-cover-copyright {
	position:absolute;
	text-align:right;
	bottom:3rem;
	right:3rem;
}
.dp-footer {
	margin-top:3rem;
	background-color:#272727;
	color:#939393;
}
.dp-footer-box {padding:5rem 0 5rem 0;}
.ocf-icon-share {
	font-size:120%;
	margin:0 1rem;
	color:#666;
	cursor:normal;
	transition:All 1s;
    -webkit-transition:All 1s;
    -moz-transition:All 1s;
    -o-transition:All 1s;
}
.ocf-icon-share:hover {color:#fff;cursor:pointer;}
.ocf-icon-map {color:rgb(232,101,85);}
.ocf-icon-phone {color:rgb(52,210,147);}
.ocf-icon-envelope {color:rgb(58,176,226);}
.ocf-panel-question {
	background:rgba(255,255,255,0.8);
	padding:2.5rem;
}
.ocf-panel-options {
	background:transparent;
	border-color:#bbb;
	padding:1rem;
	cursor:normal;
	transition:All 1s;
    -webkit-transition:All 1s;
    -moz-transition:All 1s;
    -o-transition:All 1s;
}
.ocf-panel-options:hover {background:rgba(220,220,220,1);cursor:pointer;}
.ocf-panel-recommend {background:rgba(255,255,255,0.8);}
.ocf-panel-recommend > .am-panel-bd {padding:2.5rem;}
.ocf-progress {margin:0;}
.ocf-progress-text {padding:0;}
.ocf-logo-mxpx{
	display: inline-block;
	height: 21px;
	width: 86px;
	background: url(/i/img/sponsor/1.png) no-repeat left center;
	-webkit-background-size: 86px 21px;
	background-size: 86px 21px;
}
.ocf-question-incorrect {
	color:rgb(221,81,76) !important;
	background:rgb(250,229,228) !important;
}
.ocf-question-correct {
	color:rgb(94,185,94) !important;
	background:rgb(231,245,231) !important;
}
.ocf-hint-left {
	border-bottom:#ccc solid 3px;
	padding-right:2rem;
	float:left;
}
.ocf-hint-right {
	border-bottom:#ccc solid 3px;
	padding-left:2rem;
	float:right;
}

  </style>
</head>
<body>

<header class="am-topbar ocf-topbar" id="ocf-header">
  <div class="am-container ">
  <div class="am-vertical-align">
    <h1 class="am-topbar-brand am-vertical-align-middle">
	  <a href="/"><img src="/i/img/logo.png" height="30"></a>
    </h1>
  </div>
    <button class="am-topbar-btn am-topbar-toggle am-btn am-btn-sm am-show-sm-only" data-am-collapse="{target: '#collapse-head'}" style="background:none; border-color:#ddd;"><span class="am-sr-only">导航切换</span> <span class="am-icon-bars"></span></button>

    <div class="am-collapse am-topbar-collapse" id="collapse-head">
      <ul class="am-nav am-nav-pills am-topbar-nav">
        
		
		<li class="am-dropdown" data-am-dropdown="">
        <a class="am-dropdown-toggle" data-am-dropdown-toggle="" href="javascript:;">
          答题 
        </a>
        <ul class="am-dropdown-content">
          <li class="am-dropdown-header">答题模式</li>
          <li class="am-active"><a href="javascript:;"><i class="am-icon-random am-icon-fw"></i> 快速模式</a></li>
          <li><a href="javascript:;"><i class="am-icon-gavel am-icon-fw"></i> 闯关模式</a></li>
          <li><a href="javascript:;"><i class="am-icon-users am-icon-fw"></i> PK模式</a></li>
        </ul>
      </li>
	  
		<li><a href="javascript:;">题库</a></li>
		<li><a href="javascript:;">捐助</a></li>
        <li><a href="javascript:;">排行</a></li>
        <li><a href="javascript:;">关于</a></li>
		<li><a href="javascript:;">帮助</a></li>
		<li><a href="javascript:;">致谢</a></li>
      </ul>

      <div class="am-topbar-right">
	  	<ul class="am-nav am-nav-pills am-topbar-nav">
		<li class="am-dropdown" data-am-dropdown="">
          <a class="am-dropdown-toggle" data-am-dropdown-toggle="" href="javascript:;">
            <img src="/i/img/avatar/zyj.jpg" alt="" class="am-img-thumbnail am-circle height-set"> 下午好，张佑杰！ <span class="am-icon-caret-down"></span>
          </a>
          <ul class="am-dropdown-content">
            <li class="am-dropdown-header"> 用户菜单</li>
            <li><a href="javascript:;"><i class="am-icon-dashboard am-icon-fw"></i> 用户中心</a></li>
            <li><a href="javascript:;"><i class="am-icon-info-circle am-icon-fw"></i> 我的资料</a></li>
			<li><a href="javascript:;"><i class="am-icon-inbox am-icon-fw"></i> 通知中心</a></li>
			<li><a href="javascript:;"><i class="am-icon-bar-chart am-icon-fw"></i> 数据统计</a></li>
			<li><a href="javascript:;"><i class="am-icon-shield am-icon-fw"></i> 账户安全</a></li>
			<li><a href="javascript:;"><i class="am-icon-gears am-icon-fw"></i> 高级设置</a></li>
			<li class="am-nav-divider"></li>
            <li><a href="javascript:;" style="color: #dd514c; margin: 0.9em!important;"><i class="am-icon-power-off am-icon-fw"></i> 退出登录</a></li>
          </ul>
        </li>
		</ul>
	  </div>
    </div>
  </div>
</header>
<div class="am-g am-container">
	<div class="am-u-sm-12 am-u-md-8">
		<div class="am-panel am-panel-default ocf-panel-question am-cf">
			<h2 class="question"></h2>
			<div class="options">
				<div class="am-panel am-panel-default am-radius ocf-panel-options option1">
				</div>
				<div class="am-panel am-panel-default am-radius ocf-panel-options option2">
				</div>
				<div class="am-panel am-panel-default am-radius ocf-panel-options option3">
				</div>
				<div class="am-panel am-panel-default am-radius ocf-panel-options option4">
				</div>
				<div class="ocf-hint-left">
					答对本题，您将得到<span class="combo">10</span>积分
				</div>
				<div class="ocf-hint-right">
					当前积分：<span class="current-credit">870</span> <a class="go-now" href="javascript:;">立即捐助</a>
				</div>
			</div>
		</div>
	</div>
	<div class="am-u-sm-12 am-u-md-4">
		<div class="am-panel am-panel-default ocf-panel-recommend grantee-info">
			<div class="am-panel-hd">
				<h3 class="am-panel-title">推荐项目</h3>
			</div>
			<div class="am-panel-bd">
				<div class="am-g am-cf">
					<div class="am-u-sm-12 am-u-sm-centered">
						<center><div class="grantee-image-container"><img src="/i/img/grantee/1.jpg" class="grantee-image am-img-responsive" alt=""/></div></center>
					</div>
					<div align="center" class="am-u-sm-12 am-u-sm-centered am-text-lg grantee">
						<p>仪征刘集中心小学</p>
						<p class="am-text-sm">由<a href="http://www.mengxpx.com/" target="_blank" class="ocf-logo-mxpx">&nbsp;</a>捐助</p>
					</div>
					<div class="am-u-sm-12">
						<div class="am-progress am-progress-striped ocf-progress am-active">
							<div class="am-progress-bar am-progress-bar-secondary" style="width: 0%;"></div>
						</div>
						<div class="am-text-sm am-u-sm-6 ocf-progress-text" style="text-align:left;"><span class="progress">0</span>%已达成</div>
						<div class="am-text-sm am-u-sm-6 ocf-progress-text" style="text-align:right;">目标金额：5000RMB</div>
					</div>
					<br><br>
					<div class="am-u-sm-12">
						<button type="button" class="am-btn am-btn-primary am-btn-block" data-am-modal="{target: '#popup-1'}"><i class="am-icon-book am-icon-fw"></i> 查看他们的故事</button>
						<button
						  type="button"
						  class="am-btn am-btn-success am-btn-block"
						  style="margin-top:0.9rem;"
						  data-am-modal="{target: '#share'}">
						  <i class="am-icon-slideshare am-icon-fw"></i>分享给好友
						</button>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="am-popup" id="popup-1">
	<div class="am-popup-inner">
		<div class="am-popup-hd">
			<h4 class="am-popup-title">仪征刘集中心小学</h4>
			<span data-am-modal-close class="am-close">&times;</span>
		</div>
		<div class="am-popup-bd">
			<p><center><img src="/i/img/grantee/1.jpg" class="am-radius am-img-responsive" alt=""/></center></p>
			<h2>简介</h2>
			<p>
				有这样一个学校，“尚德 笃学”的校训，“健康 快乐 向上”的校风，“勤学 会学 乐学”的学风，“敬业 精业 创业”的教风。里面有着一群充满活力的孩子，他们求知若渴，像棵棵幼苗需要雨露的滋润，快快长大。他们没有优越的家庭条件，无法拥有舒适的学习环境，只能自己默默地承担这个年纪不该承受的苦。他们需要您的帮助，举手之劳。我们一起 汇聚微弱创造更多。
			</p>
		</div>
	</div>
</div>
<footer class="dp-footer">
<div class="am-g am-container am-text-center">
	<div class="am-u-md-3 dp-footer-box">
		<p><i class="am-icon-map-marker am-icon-lg ocf-icon-map"></i></p>
		<p>扬州市广陵区汤汪乡杉湾花园92幢-101室 杉湾花园邻里中心</p>
	</div>
	<div class="am-u-md-3 dp-footer-box">
		<p><i class="am-icon-phone-square am-icon-lg ocf-icon-phone"></i></p>
		<p>18752782679</p>
	</div>
	<div class="am-u-md-3 dp-footer-box">
		<p><i class="am-icon-envelope am-icon-lg ocf-icon-envelope"></i></p>
		<p>contact@1cf.co</p>
	</div>
	<div class="am-u-md-3 dp-footer-box" style="background:#171717;">
		<p>
			<span class="ocf-icon-share am-icon-qq"></span>
			<span class="ocf-icon-share am-icon-weibo"></span>
			<span class="ocf-icon-share am-icon-tencent-weibo"></span>
			<span class="ocf-icon-share am-icon-weixin"></span>
		</p>
		<p style="color:#404040;">
		一分钱助学 开发者预览版<br>
		&copy; 2016 扬州市多公益发展中心<br>
		由 <i class="am-icon-windows"></i> 江苏微软创新中心 孵化<br>
		黔ICP备16006126号-3
		</p>
	</div>
</div>
</footer>
<!--信息按钮-->

<div class="ocf-btn-float " id="ocf-btn-float">
	<a href="javascript:;" data-am-modal="{target: '#info'}" title="图片信息" class="ocf-panel-shadow am-icon-btn am-primary am-icon-arrows-alt info"></a>
</div>

<!--modals-->
<div class="am-modal" tabindex="-1" id="info">
	<div class="am-modal-dialog" style="width:99%; height:99%;">
		<div class="am-u-sm-12 ocf-cover-img">
			<a href="javascript: void(0)" class="am-close" style="float:right; opacity:0.8; color:#fff; font-size:1.5em;" data-am-modal-close>&times;</a>
			<span class="ocf-cover-name">
				<a href="javascript:;" class="am-text-xxl">特雷西塔海滩</a><br>
				<text class="am-text-lg"><i class="am-icon-location-arrow am-icon-fw"></i> 圣克鲁斯-德特内里费，加那利群岛，西班牙</text>
			</span>
			<span class="ocf-cover-copyright">
				&copy; Cornelia Doerr/age fotostock<br><i class="am-icon-windows am-icon-fw"></i> 由Bing&trade;今日美图提供
			</span>
			
		</div>
	</div>
</div>

<div class="am-modal am-modal-no-btn" tabindex="-1" id="share">
	<div class="am-modal-dialog">
		<div class="am-modal-hd">分享给好友
			<a href="javascript: void(0)" class="am-close am-close-spin" data-am-modal-close>&times;</a>
		</div>
		<div class="am-modal-bd">
			<a href="javascript:;" class="am-icon-btn am-icon-qq"></a>
			<a href="javascript:;" class="am-icon-btn am-icon-weibo"></a>
			<a href="javascript:;" class="am-icon-btn am-icon-tencent-weibo"></a>
			<a href="javascript:;" class="am-icon-btn am-icon-renren"></a>
		</div>
	</div>
</div>
<div class="am-modal am-modal-confirm" tabindex="-1" id="my-confirm">
  <div class="am-modal-dialog">
    <div class="am-modal-hd">一分钱助学</div>
    <div class="am-modal-bd">
      确定捐助<span class="current-credit">870</span>积分吗？
    </div>
    <div class="am-modal-footer">
      <span class="am-modal-btn" data-am-modal-cancel>取消</span>
      <span class="am-modal-btn" data-am-modal-confirm>捐助</span>
    </div>
  </div>
</div>
<div class="am-modal am-modal-alert" tabindex="-1" id="alert-success">
  <div class="am-modal-dialog">
    <div class="am-modal-hd">一分钱助学</div>
    <div class="am-modal-bd">
      成功捐助<span class="exchange"></span>元！项目 仪征刘集中心小学 达成<span class="progress"></span>%！
    </div>
    <div class="am-modal-footer">
      <span class="am-modal-btn">确定</span>
    </div>
  </div>
</div>


<!--[if lt IE 9]>
<script src="/i/js/jquery.1.11.1.min.js"></script>
<script src="/i/js/modernizr.js"></script>
<script src="/i/js/amazeui.ie8polyfill.min.js"></script>
<![endif]-->

<!--[if (gte IE 9)|!(IE)]><!-->
<script src="/i/js/jquery.min.js"></script>
<!--<![endif]-->
<script src="/i/js/amazeui.min.js"></script>
<script language="javascript">
var demo={"question":["\u201c\u5c71\u57ce\u201d\u662f\u6211\u56fd\u54ea\u5ea7\u57ce\u5e02\u7684\u96c5\u53f7\uff1f","\u300a\u5a01\u5c3c\u65af\u5546\u4eba\u300b\u662f\u54ea\u56fd\u4eba\u7684\u4f5c\u54c1\uff1f","\u6211\u56fd\u7b2c\u4e00\u90e8\u7eaa\u4f20\u4f53\u53f2\u4e66\u662f\uff1f","\u5b54\u5b50\u662f\u54ea\u56fd\u4eba\uff1f","\u4e16\u754c\u4e0a\u6d77\u62d4\u6700\u9ad8\u7684\u5c71\u5cf0\u662f\uff1f","\u4e0b\u5217\u54ea\u4e00\u4e2a\u6e56\u6cca\u662f\u5728\u6211\u56fd\u6c5f\u897f\u7701\u7684\u5883\u5185\uff1f","\u4e16\u754c\u56db\u5927\u6d0b\u4e2d\u9762\u79ef\u6700\u5c0f\u7684\u662f\uff1f","\u6211\u56fd\u6700\u5927\u7684\u7011\u5e03\u201c\u9ec4\u679c\u6811\u7011\u5e03\u201d\u4f4d\u4e8e\u54ea\u4e2a\u7701\uff1f","\u201c\u5929\u4e0b\u5174\u4ea1\uff0c\u5339\u592b\u6709\u8d23\u201d\u662f\u54ea\u4f4d\u601d\u60f3\u5bb6\u7684\u540d\u8a00\uff1f","\u838e\u58eb\u6bd4\u4e9a\u56db\u5927\u60b2\u5267\u4e2d\u54ea\u90e8\u53c8\u79f0\u201c\u738b\u5b50\u590d\u4ec7\u8bb0\u201d\uff1f","\u4e0b\u5217\u6211\u56fd\u540d\u8336\u4e2d\u54ea\u4e00\u79cd\u662f\u4ea7\u4e8e\u798f\u5efa\u5b89\u6eaa\uff1f"],"option1":["\u91cd\u5e86","\u4fc4\u56fd","\u300a\u540e\u6c49\u4e66\u300b","\u5b8b\u56fd","\u4e54\u6208\u91cc\u5cf0","\u6d1e\u5ead\u6e56","\u592a\u5e73\u6d0b","\u4e91\u5357","\u987e\u708e\u6b66","\u300a\u5965\u8d5b\u7f57\u300b","\u78a7\u87ba\u6625"],"option2":["\u897f\u5b89","\u6cd5\u56fd","\u300a\u53f2\u8bb0\u300b","\u79e6\u56fd","\u5343\u57ce\u7ae0\u5609\u5cf0","\u9131\u9633\u6e56","\u5317\u51b0\u6d0b","\u6c5f\u897f","\u9ec4\u5b97\u7fb2","\u300a\u674e\u5c14\u738b\u300b","\u94c1\u89c2\u97f3"],"option3":["\u6d1b\u9633","\u82f1\u56fd","\u300a\u6625\u79cb\u300b","\u536b\u56fd","\u73e0\u7a46\u6717\u739b\u5cf0","\u592a\u6e56","\u5370\u5ea6\u6d0b","\u6e56\u5317","\u738b\u592b\u4e4b","\u300a\u54c8\u59c6\u96f7\u7279\u300b","\u6b66\u5937\u5ca9\u8336"],"option4":["\u798f\u5dde","\u5fb7\u56fd","\u300a\u6c49\u4e66\u300b","\u9c81\u56fd","\u516c\u683c\u5c14\u5c71\u5cf0","\u6d2a\u6cfd\u6e56","\u5927\u897f\u6d0b","\u8d35\u5dde","\u738b\u5145","\u300a\u9ea6\u514b\u767d\u300b","\u9f99\u4e95"],"correct":["\u91cd\u5e86","\u82f1\u56fd","\u300a\u53f2\u8bb0\u300b","\u9c81\u56fd","\u73e0\u7a46\u6717\u739b\u5cf0","\u9131\u9633\u6e56","\u5317\u51b0\u6d0b","\u8d35\u5dde","\u987e\u708e\u6b66","\u300a\u54c8\u59c6\u96f7\u7279\u300b","\u94c1\u89c2\u97f3"],"class":["option1","option3","option2","option4","option3","option2","option2","option4","option1","option3","option2"]};
var current=-1;
var credit=870;
var combo=0;
var step=10;
var flag=1;
var target=5000;


////////////////////////////////////////需要自己填的
//当前金额
var progress=2143; //单位是元

//1积分对应的金额
var exchange=0.01 //单位是元，不改的话就是1积分捐助1分钱，10积分捐助0.1元

////////////////////////////////////////就这两个


var rate=progress/target*100;
$(document).ready(function(){
	$('.am-progress-bar').css("width",rate.toFixed(2) + "%");
	$('.progress').html(rate.toFixed(2));
	getquestion();
	$('.ocf-panel-options').click(function(){
		if (flag==0) {
			flag=1;
			if ($(this).html()==demo['correct'][current]) {
				combo++;
				$(this).addClass("ocf-question-correct").html("连续答对" + combo + "题！积分+" + step);
				credit += step;
				emphasize(0);
				
				if (combo>=5) step=20;
				else if (combo>=10) step=30;
				
			} else {
				$(this).addClass("ocf-question-incorrect").html("回答错误！正确答案是：" + demo['correct'][current]);
				$("." + demo['class'][current]).addClass("ocf-question-correct");
				combo=0;
				step=10;
			}
			$('.current-credit').html(credit);
			setTimeout("getquestion()",3000); 
		}
    });
	$('.go-now').on('click', function() {
      $('#my-confirm').modal({
        relatedTarget: this,
        onConfirm: function() {
		  var add=exchange*credit;
          progress+=add;
		  $('.exchange').html(add.toFixed(2));
		  credit=0;
		  rate=progress/target*100;
		  
		  $('.am-progress-bar').css("width",rate.toFixed(2) + "%");
		  $('.progress').html(rate.toFixed(2));
		  $('.current-credit').html(credit);
		  $('#alert-success').modal();
        }
      });
    });
});
function emphasize(q) {
	if (q==1) {
		if (step>10) $('.ocf-hint-left').addClass("am-text-success");
		setTimeout("$('.ocf-hint-left').removeClass('am-text-success')",1500); 
	}
	else {
		$('.ocf-hint-right').addClass("am-text-success");
		setTimeout("$('.ocf-hint-right').removeClass('am-text-success')",1500); 
	}
}
function getquestion() {
	current++;
	if (current>10) current=0;
	$('.ocf-panel-options').removeClass("ocf-question-correct").removeClass("ocf-question-incorrect");
	$('.question').html(demo['question'][current]);
	$('.option1').html(demo['option1'][current]);
	$('.option2').html(demo['option2'][current]);
	$('.option3').html(demo['option3'][current]);
	$('.option4').html(demo['option4'][current]);
	$('.combo').html(step);
	emphasize(1);
	flag=0;
}
</script>
</body>
</html>
