<?php
class ApiController extends BaseController {

	function actionGetquestion() {
		$db=new Model("problems");
		if (arg("cat")) {
			$cat=arg("cat");
		} else {
			$cat="生活小常识";
		}
		$row=$db->find(array("cat = :cat", 
															":cat" => $cat
													),"rand()"
											);
		//dump($row);
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
			'description'=>$row['description'], //题目描述
			'opt1'=>$ans[$o[0]], //A选项
			'opt2'=>$ans[$o[1]],
			'opt3'=>$ans[$o[2]],
			'opt4'=>$ans[$o[3]],
			'ans1'=>$tid.'#'.md5($ans[$o[0]]), //A选项对应的ans代码（回答时用）
			'ans2'=>$tid.'#'.md5($ans[$o[1]]),
			'ans3'=>$tid.'#'.md5($ans[$o[2]]),
			'ans4'=>$tid.'#'.md5($ans[$o[3]])
		);
		echo json_encode($output);
	}

	function actionGetanswer() {
		$ip = getIP();
		$date = date("Y-m-d");
		$time = date("Y-m-d H:i:s");
		$user_db=new Model("users");
		$db=new Model("problems");
		$log_db=new Model("log");
		$problem=explode("#",arg("ans"));
		$rs=$db->find(array("tid = :tid",
												":tid" => $problem[0])
									);
		if ($rs['ans']!=arg("ans")) { //如果答错
			$db->update(
				array("tid = :tid",
							":tid" => $problem[0]),
				array("ans" => "ans+1")
			);
			if ($this->islogin) {
				$user_db->update(
					array("loginid = :loginid",
								":loginid" => $this->loginid),
					array("ans" => "ans+1")
				);
			}
			$log_db->create(
				array(
					"date" => $date,
					"time" => $time,
					"type" => "ans",
					"loginid" => $this->loginid,
					"tid" => $problem[0],
					"result" => 0,
					"ip" => $ip
				)
			);
			$json=array(
				'result'=>0,
				'answer'=>$rs['ans1']
			);
			$output=array(
				'status'=>1,
				'json' => $json
			);
		} else { //如果答对
			$db->update(
				array("tid = :tid",
							":tid" => $problem[0]),
				array("ans" => "ans+1",
							"cor" => "cor+1")
			);
			if ($islogin) {
				$user_db->update(
					array("loginid = :loginid",
								":loginid" => $this->loginid),
					array("ans" => "ans+1",
								"cor" => "cor+1")
				);
			}
			$log_db->create(
				array(
					"date" => $date,
					"time" => $time,
					"type" => "ans",
					"loginid" => $this->loginid,
					"tid" => $problem[0],
					"result" => floor(@$_SESSION['reward']/5)*5+10,
					"ip" => $ip
				)
			);
			$json=array(
				'result'=>1
			);
			$output=array(
				'status'=>1,
				'json' => $json
			);
		}
	}
	
	function actionVerifyaccount() {
		if($loginid=arg("loginid")) {
			$db=new Model("users");
			$result=$db->find(array("loginid=:loginid",
												":loginid"=>$loginid));
			if (empty($result)) {
				$output=array(
					'result'=>0,
					'info'=>null
				);
			}
			else {
				$json=$result;
				$output=array(
					'result'=>1,
					'info'=>$json
				);
			}
		}
		echo json_encode($output);
	}

	function actionRegister() {
		$db=new Model("users");
		if(arg("name") && arg("pass") && arg("email")) {
			$result=$db->find(array("name=:name",
															":name"=>arg("name")));
			if (!empty($result)) {
				$output=array(
					'result'=>0,
					'info'=>"username"
				);
				echo json_encode($output);
				exit;
			}
			$result=$db->find(array("email=:email",
															":email"=>arg("email")));
			if (!empty($result)) {
				$output=array(
					'result'=>0,
					'info'=>"email"
				);
				echo json_encode($output);
				exit;
			}
			$ip=getIP();
			$rtime=date("Y-m-d H:i:s");
			$loginid=sha1(arg("email")."1cf.co".arg("pass"));
			$user=array(
				'rtime'=>$rtime,
				'name'=>arg("name"),
				'pass'=>arg("pass"),
				'email'=>arg("email"),
				'ip'=>$ip,
				'loginid'=>$loginid
			);
			$json=$db->create($user);
			$output=array(
				'result'=>1,
				'uid'=>$json
			);
		}
		echo json_encode($output);
	}

	function actionCheckin() {
		if (!$this->islogin) {
			$output=array(
				'status'=>0,
				'info'=>'invalid loginid'
			);
			echo json_encode($output);
			exit;
		}
		$date=date("Y-m-d");
		$time=date("H:i:s");
		$previous=date("Y-m-d",strtotime("-1 day"));
		$db=new Model("checkin");
		$loginid=$_SESSION['loginid'];
		$reward=1;
		$result=$db->find(array("date = date=:date and loginid=:loginid",
														":date"=>$date,
														":loginid" => $loginid));
		if (!empty($result)) {
			$output=array(
				'status'=>0,
				'info'=>'already checked in'
			);
			echo json_encode($output);
			exit;
		}
		$result=$db->find(array("date=:date and loginid=:loginid",
														":date" => $previous,
														":loginid" => $loginid));
		if (!empty($result)) $reward=intval($result['reward'])+1;
		$checkin=array(
			'loginid' => $loginid,
			'date' => $date,
			'time' => $time,
			'reward' => $reward
		);
		$result=$db->create($checkin);
		$user_db=new Model("users");
		/////还没写加积分的
	}

	function actionGetranklist() {
		$db=new Model("users");
		$result=$db->findAll(null,"credit desc,name asc","uid,name,avatar,credit",20);
		$result[0]['rank']=1;
		for ($i=1;$i<count($result);$i++) {
			if ($result[$i]['credit']==$result[$i-1]['credit']) $result[$i]['rank']=$result[$i-1]['rank'];
			else $result[$i]['rank']=$i;
		}
		echo json_encode($result);
		//dump($result);
	}

	function actionGetbases() {
		$db=new Model("problems_cats");
		$result=$db->findAll(null,"bid asc");
		echo json_encode($result);
	}

	function actionGetgrantees() {
		$db=new Model("grantee");
		$result=$db->findAll(null,"gid asc","gid,name,sponsor,img,target,current,status");
		//dump($result);
		for ($i=0;$i<count($result);$i++) {
			$result[$i]['rate']=round($result[$i]['current']/$result[$i]['target']*100,2);
		}
		//dump($result);
		echo json_encode($result);
	}

	function actionGetgranteeinfo() {
		if ($gid=arg("gid")) {
			$db=new Model("grantee");
			$result=$db->find(array("gid=:gid",
															":gid"=>$gid));
			$result['rate']=round($result['current']/$result['target']*100,2);
			echo json_encode($result);
		}
	}

	function actionModifyuserinfo() {
		if (@$_SESSION['loginid']) {
			$db=new Model("users");
			$loginid=$_SESSION['loginid'];
			$result=0;
			if ($name=arg("name")) {
				$result+=$db->update(
					array("loginid=:loginid",
								":loginid"=>$loginid),
					array("name"=>$name)
				);
			}
			if ($sex=arg("sex")) {
				$result+=$db->update(
					array("loginid=:loginid",
								":loginid"=>$loginid),
					array("sex"=>$sex)
				);
			}
			if ($pass=arg("pass")) {
				$result+=$db->update(
					array("loginid=:loginid",
								":loginid"=>$loginid),
					array("pass"=>$pass)
				);
			}
			if ($real_name=arg("real_name")) {
				$result+=$db->update(
					array("loginid=:loginid",
								":loginid"=>$loginid),
					array("real_name"=>$real_name)
				);
			}
			if ($tel=arg("tel")) {
				$result+=$db->update(
					array("loginid=:loginid",
								":loginid"=>$loginid),
					array("tel"=>$tel)
				);
			}
			if ($qq=arg("qq")) {
				$result+=$db->update(
					array("loginid=:loginid",
								":loginid"=>$loginid),
					array("qq"=>$qq)
				);
			}
			if ($weibo=arg("weibo")) {
				$result+=$db->update(
					array("loginid=:loginid",
								":loginid"=>$loginid),
					array("weibo"=>$weibo)
				);
			}
			if ($intro=arg("intro")) {
				$result+=$db->update(
					array("loginid=:loginid",
								":loginid"=>$loginid),
					array("intro"=>$intro)
				);
			}
			echo json_encode($result);
		}
	}
}