<?php if(!class_exists("View", false)) exit("no direct access allowed");?><header class="am-topbar ocf-topbar am-print-hide" id="ocf-header">
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
          <li id="index"><a href="/"><i class="am-icon-random am-icon-fw"></i> 快速模式</a></li>
          <li id="act"><a href="javascript:;"><i class="am-icon-gavel am-icon-fw"></i> 闯关模式</a></li>
          <li id="pk"><a href="javascript:;"><i class="am-icon-users am-icon-fw"></i> PK模式</a></li>
        </ul>
      </li>
	  
		<li id="base"><a href="/base">题库</a></li>
		<li id="grantee"><a href="/grantee">捐助</a></li>
    <li id="rank"><a href="/rank">排行</a></li>
    <li id="about"><a href="/about">关于</a></li>
		<li id="help"><a href="/help">帮助</a></li>
		<li id="credit"><a href="/credit">致谢</a></li>
      </ul>

      <div class="am-topbar-right">
        <?php if (@$islogin) : ?>
	  	<ul class="am-nav am-nav-pills am-topbar-nav">
		<li class="am-dropdown" data-am-dropdown="">
          <a class="am-dropdown-toggle" data-am-dropdown-toggle="" href="javascript:;">
            <img id="avatar" src="/i/img/avatar/zyj.jpg" alt="" class="am-img-thumbnail am-circle height-set"> 下午好，张佑杰！ <span class="am-icon-caret-down"></span>
          </a>
          <ul class="am-dropdown-content">
            <li class="am-dropdown-header"> 用户菜单</li>
            <li id="account"><a href="/account"><i class="am-icon-dashboard am-icon-fw"></i> 用户中心</a></li>
            <li id="profile"><a href="/profile"><i class="am-icon-info-circle am-icon-fw"></i> 我的资料</a></li>
            <li id="notifications"><a href="/notifications"><i class="am-icon-inbox am-icon-fw"></i> 通知中心</a></li>
            <li id="stat"><a href="/stat"><i class="am-icon-bar-chart am-icon-fw"></i> 数据统计</a></li>
            <li id="security"><a href="/security"><i class="am-icon-shield am-icon-fw"></i> 账户安全</a></li>
            <li id="settings"><a href="/settings"><i class="am-icon-gears am-icon-fw"></i> 高级设置</a></li>
            <li class="am-nav-divider"></li>
            <li id="logout"><a href="/logout" style="color: #dd514c; margin: 0.9em!important;"><i class="am-icon-power-off am-icon-fw"></i> 退出登录</a></li>
          </ul>
        </li>
		</ul>
    <?php else : ?>
    <a class="am-btn am-btn-secondary am-topbar-btn am-btn-sm" href="/login" style="color:#fff;">登录</a>
    <?php endif; ?>
	  </div>
    </div>
  </div>
</header>
<script>
<?php if (@$url) : ?>
$("#<?php echo htmlspecialchars($url, ENT_QUOTES, "UTF-8"); ?>").addClass("am-active");
$("#<?php echo htmlspecialchars($url, ENT_QUOTES, "UTF-8"); ?> > a").attr("href","javascript:;");
<?php endif; ?>
</script>