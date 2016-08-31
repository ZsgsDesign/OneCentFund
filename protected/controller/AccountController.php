<?php
class AccountController extends BaseController {
	
	function actionIndex(){ //首页
		$this->url="index"; //非常重要 用于导航栏
		$this->title="快速模式"; //标题
	}
	
}