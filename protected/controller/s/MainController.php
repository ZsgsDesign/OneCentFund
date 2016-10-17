<?php
class MainController extends BaseController {
	
	function actionIndex(){ //首页
		$this->tested=0;
		$this->school="";
		$this->name="";
		$this->time="";
		$this->score=0;
		if (arg("name") && arg("school")) {
			$_SESSION['name']=trim(arg('name'));
			$_SESSION['school']=trim(arg('school'));
			echo json_encode(array('result'=>1));
			exit;
		}
		if (arg("openid")) {
			$openid=arg("openid");
			$secret=sha1("lalala".$openid);
			if ($secret!=arg("secret")) exit("授权secret错误");
			$user_db=new Model("s");
			$rs=$user_db->find(array(
				"openid=:openid",
				":openid"=>$openid
			));
			if ($rs) {
				$this->tested=1;
				$this->school=$rs['school'];
				$this->name=$rs['name'];
				$this->score=$rs['score'];
				$this->display("s/main_index.html");
				exit;
			}
			$_SESSION['openid']=arg("openid");
		} else {
			$this->jump("https://open.weixin.qq.com/connect/oauth2/authorize?appid=wx34339a5251285069&redirect_uri=https%3a%2f%2fwww2.luogu.org%2f1cf%2fverify.php&response_type=code&scope=snsapi_base#wechat_redirect");
			exit;
		}
		$db=new Model("s_questions");
		$rs=$db->findAll(null,'rand()','tid',20);
		$tid=array();
		foreach($rs as $r) $tid[]=$r['tid'];
		//dump($tid);
		$_SESSION['tid']=json_encode($tid);
		$_SESSION['current']=0;
		$_SESSION['score']=0;

	}

	function actionResult() {
		if (arg("id")) {
			$user_db=new Model("s");
			$id=arg("id");
			$rs=$user_db->find(array(
				"id=:id",
				":id"=>$id
			));
			if (!$rs) $this->jump("/s/");
			$this->name=$rs['name'];
			$this->school=$rs['school'];
			$this->time=$rs['time'];
			$this->score=$rs['score'];
		}
	}

	function actionSubmit() {
		if (arg("ans")) {
			$score=intval($_SESSION['score']);
			$current=intval($_SESSION['current']);
			if ($current<20) {
				$db=new Model("s_questions");
				$output=array();
				$problem=explode("#",arg("ans"));
				$rs=$db->find(array("tid = :tid",
														":tid" => $problem[0])
											);
				$output['ans']=$rs['ans1'];
				if ($rs['answer']!=arg("ans")) { //如果答错
					$output['result']=0;
					$db->execute("update s_questions set ans=ans+1 where tid=:tid",
												array(":tid"=>$problem[0]));
				} else { //如果答对
					$output['result']=1;
					$db->execute("update s_questions set ans=ans+1, cor=cor+1 where tid=:tid",
												array(":tid"=>$problem[0]));
					$score+=5;
				}
				$output['score']=$score;
				$_SESSION['score']=$score;
				$_SESSION['current']=$current+1;
				echo json_encode($output);
			}
		}
	}


	function actionGetquestion() {
		$tid=json_decode($_SESSION['tid']);
		$current=$_SESSION['current'];
		if ($current<20) {
			$db=new Model("s_questions");
			$row=$db->find(array("tid = :tid", 
																":tid" => $tid[$current]
														));
			$ans=array($row['ans1'], $row['ans2'], $row['ans3'], $row['ans4']);
			$tid=$row['tid'];
			$o=array(0,1,2,3);
			for ($p = 0; $p < 4; $p++) {
				$temp1=rand(0,3);
				$temp2=rand(0,3);
				$temp3=$o[$temp1];
				$o[$temp1]=$o[$temp2];
				$o[$temp2]=$temp3;
			}
			$output=array(
				'result'=>1,
				'description'=>$row['description'],
				'opt1'=>$ans[$o[0]],
				'opt2'=>$ans[$o[1]],
				'opt3'=>$ans[$o[2]],
				'opt4'=>$ans[$o[3]],
				'ans1'=>$tid.'#'.md5($ans[$o[0]]),
				'ans2'=>$tid.'#'.md5($ans[$o[1]]),
				'ans3'=>$tid.'#'.md5($ans[$o[2]]),
				'ans4'=>$tid.'#'.md5($ans[$o[3]]),
				'current'=>$current+1
			);
			echo json_encode($output);
		} else {
			$date=date("Y-m-d");
			$time=date("Y-m-d H:i:s");
			$user_db=new Model("s");
			$row=array(
				'name'	=> $_SESSION['name'],
				'school'=> $_SESSION['school'],
				'openid'=> $_SESSION['openid'],
				'ip'=>getIP(),
				'score'	=> intval($_SESSION['score']),
				'date'	=> $date,
				'time'	=> $time
			);
			$id=$user_db->create($row);
			$output=array(
				'reuslt'=>0,
				'name'	=> $_SESSION['name'],
				'school'=> $_SESSION['school'],
				'score'	=> $_SESSION['score'],
				'time'	=> $time
			);
			echo json_encode($output);
		}
	}
	function actionExec() {
		$db=new Model("s_questions");
		$rs=$db->findAll();
		$success=0;
		for ($i=0;$i<count($rs);$i++) {
			$answer=$rs[$i]['tid']."#".md5($rs[$i]['ans1']);
			$success+=$db->update(array(
				"tid=:tid",
				":tid"=>$rs[$i]['tid']
			),array(
				"answer"=>$answer
			));
		}
		echo $success;

	}
	
}