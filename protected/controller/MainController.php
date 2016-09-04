<?php
class MainController extends BaseController {
	
	function actionIndex(){ //首页
		$this->url="index"; //非常重要 用于导航栏
		$this->title=""; //标题
		$_SESSION['reward']=0;
		$this->cat="";
		$str = file_get_contents('http://www.bing.com/HPImageArchive.aspx?format=js&idx=0&n=1&mkt=zh-CN');
		$array = json_decode($str);
		//dump($array);exit;
		$this->imgurl="http://s.cn.bing.net/".$array->{"images"}[0]->{"url"};
		$copyright=$array->{"images"}[0]->{"copyright"};
		$imginfo=explode(" (",$copyright);
		//dump($imginfo);exit;
		$this->imgcopyright=trim(rtrim(@$imginfo[1],")"));
		$imgname=explode("，",$imginfo[0]);
		$this->imgname=@$imgname[0];
		$this->imglocation=@$imgname[1];
		$this->imgcopyrightlink=$array->{"images"}[0]->{"copyrightlink"};
		if (arg("cat")) {
			$this->cat=arg("cat");
			$base_db=new Model("bases");
			$base=$base_db->find(
				array(
					"name=:name",
					":name"=>arg("cat")
				)
			);
			$this->imgurl="https://static.1cf.co/img/base/bg/".$base['background'];
		}
		$db=new Model("grantee");
		$result=$db->find(array("gid=:gid",
														":gid"=>2));
		$result['rate']=round($result['current']/$result['target']*100,2);
		$gb=new Model("log");
		$count=$gb->query("select count(distinct(ip)) as count from log where gid=:gid",
											array(":gid"=>2));
		$result['count'] = $count[0]['count'];
    $this->grantee=$result;
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
		$result=$db->findAll(
			array(
				"uid<>:uid1",
				"uid1"=>59
			),
			"credit desc,name asc",
			"uid,name,avatar,credit",
			20
		);
		$result[0]['rank']=1;
		$result[0]['url']="/user/".urlencode($result[0]['uid']);
		for ($i=1;$i<count($result);$i++) {
			if ($result[$i]['credit']==$result[$i-1]['credit']) $result[$i]['rank']=$result[$i-1]['rank'];
			else $result[$i]['rank']=$i+1;
			$result[$i]['url']="/user/".$result[$i]['uid'];
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
		$user_db=new Model("users");
		$result=$user_db->find(
			array(
				"loginid=:loginid",
				":loginid"=>@$_SESSION['loginid']
			)
		);
		$this->userscore=$result['score'];
	}
}