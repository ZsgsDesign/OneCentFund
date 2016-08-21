<?php
class MainController extends BaseController {
	
	function actionIndex(){ //首页
		$this->url="index"; //非常重要 用于导航栏
		$this->title="快速模式"; //标题
	}
	
	function actionAbout() {
		$this->url="about";
		$this->title="关于我们";
	}
	
	function actionCredit() {
		$this->url="credit";
		$this->title="致谢";
	}
}