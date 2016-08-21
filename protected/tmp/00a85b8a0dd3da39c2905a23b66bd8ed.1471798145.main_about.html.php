<?php if(!class_exists("View", false)) exit("no direct access allowed");?>
  <style>
	body {
	  background: #fff;
	}
    .get {
      background:url(https://img.1cf.co/res/bg1.jpg) top center no-repeat fixed;
	  background-size:cover;
      margin-top:-16px;
      color: #fff;
      text-align: center;
      padding: 100px 0;
    }

    .get-title {
      font-size: 200%;
      border: 2px solid #fff;
      padding: 20px;
      display: inline-block;
    }

    .get-btn {
      background: #fff;
    }

    .hope {
      background:url(https://img.1cf.co/res/bg2.jpg) top center no-repeat fixed;
	  background-size:cover;
      padding: 50px 0;
    }

    .hope-img {
      text-align: center;
    }

    .hope-hr {
      border-color: #149C88;
    }

    .hope-title {
      font-size: 140%;
    }

    .about {
      background: #fff;
      padding: 40px 0;
      color: #7f8c8d;
    }

    .about-color {
      color: #34495e;
    }

    .about-title {
      font-size: 180%;
      padding: 30px 0 50px 0;
      text-align: center;
    }
    .header {
      text-align: center;
    }
    .header h1 {
      font-size: 200%;
      color: #333;
      margin-top: 30px;
    }
    .header p {
      font-size: 14px;
    }
    #vld-tooltip {
      position: absolute;
      z-index: 1000;
      padding: 5px 10px;
      background: #F37B1D;
      min-width: 150px;
      color: #fff;
      transition: all 0.15s;
      box-shadow: 0 0 5px rgba(0,0,0,.15);
      display: none;
    }

    #vld-tooltip:before {
      position: absolute;
      top: -8px;
      left: 50%;
      width: 0;
      height: 0;
      margin-left: -8px;
      content: "";
      border-width: 0 8px 8px;
      border-color: transparent transparent #F37B1D;
      border-style: none inset solid;
    }
</style>

<div class="get">
  <div class="am-g">
    <div class="am-u-lg-12">
      <h1 class="get-title">一分钱助学 - 可以玩的助学公益</h1>

      <p>
        感谢你的参与，让助学变得如此简单
      </p>

      <p>
        <a href="https://www.charity.do" class="am-btn get-btn">了解项目背后的故事</a>
      </p>
    </div>
  </div>
</div>

<div class="detail">
  <div class="am-g am-container">
    <div class="am-u-lg-12">
      <h2 class="detail-h2">助学的梦，期待和你一起去实现!</h2>

      <div class="am-g">
        <div class="am-u-lg-3 am-u-md-6 am-u-sm-12 detail-mb">

          <h3 class="detail-h3">
            <i class="am-icon-child am-icon-sm"></i>
             寓教于乐
          </h3>

          <p class="detail-p">
            答题助学网站旨在通过答题的方式来帮助贫困生，用户在这样的网站上可以获得答题的快乐。
          </p>
        </div>
        <div class="am-u-lg-3 am-u-md-6 am-u-sm-12 detail-mb">
          <h3 class="detail-h3">
            <i class="am-icon-cogs am-icon-sm"></i>
             多重功能
          </h3>

          <p class="detail-p">
            我们的答题网站集助学、答题以及爱心商家的曝光率为一体的新公益方式网站。
          </p>
        </div>
        <div class="am-u-lg-3 am-u-md-6 am-u-sm-12 detail-mb">
          <h3 class="detail-h3">
            <i class="am-icon-gavel am-icon-sm"></i>
             闯关模式
          </h3>

          <p class="detail-p">
            一分钱助学答题网站闯关模式的不断更新将给用户带来不断更新的视觉、听觉答题感受，值得期待哦！
          </p>
        </div>
        <div class="am-u-lg-3 am-u-md-6 am-u-sm-12 detail-mb">
          <h3 class="detail-h3">
            <i class="am-icon-send-o am-icon-sm"></i>
             未来发展
          </h3>

          <p class="detail-p">
            将来，我们将用更新颖的方式让您了解公益，更乐于加入公益，我们将和您一起成长。
          </p>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="hope">
  <div class="am-g am-container">
    <div class="am-u-lg-4 am-u-md-6 am-u-sm-12 hope-img">
      <img src="https://static.1cf.co/i/examples/landing.png" alt="" data-am-scrollspy="{animation:'slide-left', repeat: false}">
      <hr class="am-article-divider am-show-sm-only hope-hr">
    </div>
    <div class="am-u-lg-8 am-u-md-6 am-u-sm-12">
      <h2 class="hope-title">同我们一起，汇聚微弱，创造更多</h2>

      <p>
        在互联网的年代的年代，我们不愿成为一个过客。
      </p>
    </div>
  </div>
</div>

<div class="about" id="career">
  <div class="am-g am-container">
    <div class="am-u-lg-12">
      <h2 class="about-title about-color">现在加入我们，约吗？</h2>

      <div class="am-g">
        <div class="am-u-lg-6 am-u-md-4 am-u-sm-12">
          <form method="POST" class="am-form">
            <label for="name" class="about-color">你的姓名</label>
            <input id="name" name="name" type="text" placeholder="姓名 / Name">
            <br/>
            <label for="email" class="about-color">你的邮箱</label>
            <input id="email" name="email" type="email" placeholder="邮箱 / Email">
            <br/>
            <label for="message" class="about-color">你的简历</label>
            <textarea rows="7" name="message" id="message" placeholder="简历 / Resume"></textarea>
            <br/>
            <button type="submit" class="am-btn am-btn-primary am-btn-sm"><i class="am-icon-check"></i> 提 交</button>
          </form>
          <hr class="am-article-divider am-show-sm-only">
        </div>

        <div class="am-u-lg-6 am-u-md-8 am-u-sm-12">
          <h4 class="about-color">关于我们</h4>

          <p>一分钱助学公益—可以玩的公益。我们致力于对新的公益模式的开发开创，力图让更多的人关注公益，参与公益，让更多的贫困者通过公益得到帮助，改善他们的生活状况。作为新兴的公益网站，本网站将始终坚定地将玩的快乐和公益的宗旨结合起来。</p>
		  <h4 class="about-color">团队介绍</h4>

          <p>我们的团队由在校的高中生组成，我们希望能够通过自己的努力帮助更多陷入贫困深渊中的同龄人，给他们更多读书的机会。我们有着年轻的活力和蓬勃的朝气，我们将用创新的精神和不懈的努力来书写新的公益传奇。</p>
        </div>
      </div>
    </div>
  </div>
</div>

<script src="https://static.1cf.co/js/amazeui.min.js"></script>
<script src="https://static.1cf.co/js/ocf.js"></script>
<script>
$(function() {
  var $form = $('#form-with-tooltip');
  var $tooltip = $('<div id="vld-tooltip">提示信息！</div>');
  $tooltip.appendTo(document.body);

  $form.validator();

  var validator = $form.data('amui.validator');

  $form.on('focusin focusout', '.am-form-error input', function(e) {
    if (e.type === 'focusin') {
      var $this = $(this);
      var offset = $this.offset();
      var msg = $this.data('foolishMsg') || validator.getValidationMessage($this.data('validity'));

      $tooltip.text(msg).show().css({
        left: offset.left + 10,
        top: offset.top + $(this).outerHeight() + 10
      });
    } else {
      $tooltip.hide();
    }
  });
});
</script>