<?php
class MainController extends BaseController {
	
	function actionIndex(){ //首页
		$this->url="index"; //非常重要 用于导航栏
		$this->title="快速模式"; //标题
		$_SESSION['reward']=0;
	}
	
	function actionAbout() {
		$this->url="about";
		$this->title="关于我们";
	}
	
	function actionCredit() {
		$this->url="credit";
		$this->title="致谢";
	}

	function actionHelp() {
		$this->url="help";
		$this->title="帮助中心";
	}

	function actionBase() {
		$this->url="base";
		$this->title="题库";
		setcookie("pre", "0","86400000000","/","1cf.co");
		$db=new Model("bases");
		$this->result=$db->findAll(
			null,
			"cata ASC, bid ASC",
			"*"
		);
	}

	function actionRank() {
		$this->url="rank";
		$this->title="排行榜";
		$db=new Model("users");
		$result=$db->findAll(array("uid<>:uid1 and uid<>:uid2","uid1"=>1,"uid2"=>59),"credit desc,name asc","uid,name,avatar,credit",20);
		$result[0]['rank']=1;
		for ($i=1;$i<count($result);$i++) {
			if ($result[$i]['credit']==$result[$i-1]['credit']) $result[$i]['rank']=$result[$i-1]['rank'];
			else $result[$i]['rank']=$i;
		}
		//dump($result);
		$this->result=$result;
	}

	function actionGrantee() {
		$this->url="grantee";
		$this->title="捐助";
		$db=new Model("grantee");
		$result=$db->findAll(null,"gid asc");
		$gb=new Model("log");
		for ($i=0;$i<count($result);$i++) {
			$result[$i]['rate']=round($result[$i]['current']/$result[$i]['target']*100,2);
			$count=$gb->query("select count(distinct(ip)) as count from log where gid=:gid",
												array(":gid"=>$result[$i]['gid']));
			$result[$i]['count'] = $count[0]['count'];
		}
		//dump($result);
		$this->result=$result;
	}
}