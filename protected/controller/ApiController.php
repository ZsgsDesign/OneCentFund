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
		if (arg("ans")) {
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
										//dump($rs);exit;
										//dump(arg("ans"));exit;
			if ($rs['answer']!=arg("ans")) { //如果答错
				$db->execute("update problems set ans=ans+1 where tid=:tid",
											array(":tid"=>$problem[0]));
				if ($this->islogin) {
					$user_db->execute("update users set ans=ans+1 where loginid=:loginid",
											array(":loginid" => $_SESSION['loginid']));
				}
				$log_db->create(
					array(
						"date" => $date,
						"time" => $time,
						"type" => "ans",
						"uid" => $_SESSION['uid'],
						"tid" => $problem[0],
						"result" => 0,
						"ip" => $ip
					)
				);
				@$_SESSION['reward']=0;
				$output=array(
					'result'=>0,
					'answer'=>$rs['ans1'],
					'reward'=>$_SESSION['reward']
				);
			} else { //如果答对
				$rewardscore=floor(@$_SESSION['reward']/5)*5+10;
				if ($rewardscore>30) $rewardscore=30;

				$db->execute("update problems set ans=ans+1, cor=cor+1 where tid=:tid",
											array(":tid"=>$problem[0]));
				if ($this->islogin) {
					$user_db->execute("update users set ans=ans+1, cor=cor+1, score=score+:score where loginid=:loginid",
											array(":loginid" => $_SESSION['loginid'],
														":score"=>$rewardscore));
				}
				$log_db->create(
					array(
						"date" => $date,
						"time" => $time,
						"type" => "ans",
						"uid" => $_SESSION['uid'],
						"tid" => $problem[0],
						"result" => $rewardscore,
						"ip" => $ip
					)
				);
				@$_SESSION['reward']++;
				$output=array(
					'result'=>$rewardscore,
					'answer'=>$rs['ans1'],
					'reward'=>$_SESSION['reward']
				);
			}
			echo json_encode($output);
		}
	}
	
	function actionAddscore() {
		if (arg("score") && arg("action")) {
			$score=arg("score");
			$action=arg("action");
			$ip = getIP();
			$date = date("Y-m-d");
			$time = date("Y-m-d H:i:s");
			$user_db=new Model("users");
			$log_db=new Model("log");
				$output=array(
					'result'=>0
				);	
				if ($this->islogin) {
					$user_db->execute("update users set score=score+:score where loginid=:loginid",
											array(":loginid" => $_SESSION['loginid'],
														":score"=>$score));
				
					$log_db->create(
						array(
							"date" => $date,
							"time" => $time,
							"type" => $action,
							"uid" => $_SESSION['uid'],
							"result" => $score,
							"ip" => $ip
						)
					);
					$output=array(
						'result'=>$score
					);
				}
			echo json_encode($output);
		}
	}

	function actionVerifyqq() {
		if($qq_openid=arg("qq_openid")) {
			$db=new Model("users");
			$result=$db->find(array("qq_openid=:qq_openid",
												":qq_openid"=>$qq_openid));
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
				if($qq_openid=arg("qq_openid")) {
					$db->execute("update users set qq_openid=:qq_openid where loginid=:loginid",
											array(":loginid" => $loginid,
														":qq_openid"=>$qq_openid));
					
				}
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
			if(arg("qq_openid") && arg("avatar")) {
				$user=array(
					'rtime'=>$rtime,
					'name'=>arg("name"),
					'pass'=>arg("pass"),
					'email'=>arg("email"),
					'qq_openid'=>arg("qq_openid"),
					'avatar'=>arg("avatar"),
					'ip'=>$ip,
					'loginid'=>$loginid
				);				
				
			}else{
				$user=array(
					'rtime'=>$rtime,
					'name'=>arg("name"),
					'pass'=>arg("pass"),
					'email'=>arg("email"),
					'ip'=>$ip,
					'loginid'=>$loginid
				);				
			}
			$json=$db->create($user);
			$output=array(
				'result'=>1,
				'uid'=>$json
			);
		}
		echo json_encode($output);
	}

	function actionCheckinstatus() {
		if (!$this->islogin) {
			$output=array(
				'result'=>0
			);
			echo json_encode($output);
			exit;
		}
		$date=date("Y-m-d");
		$time=date("H:i:s");
		$previous=date("Y-m-d",strtotime("-1 day"));
		$db=new Model("checkin");
		$loginid=$_SESSION['loginid'];
		$reward=0;
		$checked=0;
		$result=$db->find(array("date=:date and loginid=:loginid",
														":date"=>$date,
														":loginid" => $loginid));
		if ($result) {
			$checked=1;
		}
		$result=$db->find(array("date=:date and loginid=:loginid",
														":date" => $previous,
														":loginid" => $loginid));
		if (!empty($result)) $reward=intval($result['reward'])+1;
		if ($checked==1)$reward=$reward+1;
		echo json_encode(
			array(
				"result"=>1,
				"reward"=>$reward,
				"checked"=>$checked
			)
		);
	}
	
	function actionCheckin() {
		if (!$this->islogin) {
			$output=array(
				'result'=>0,
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
		$result=$db->find(array("date=:date and loginid=:loginid",
														":date"=>$date,
														":loginid" => $loginid));
		if ($result) {
			$output=array(
				'result'=>0,
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
		//1-100 2-110 3-120 4-130 -200
		$rewardscore=($reward-1)*10+100;
		if ($rewardscore>200) $rewardscore=200;
		$user_db->execute("update users set score=score+:score where loginid=:loginid",
											array(":loginid" => $_SESSION['loginid'],
														":score"=>$rewardscore));
		echo json_encode(
			array(
				"result"=>$rewardscore,
				"reward"=>$reward
			)
		);
	}

	function actionGetranklist() {
		$db=new Model("users");
		$result=$db->findAll(array("uid<>:uid1 and uid<>:uid2","uid1"=>1,"uid2"=>59),"credit desc,name asc","uid,name,avatar,credit",20);
		$result[0]['rank']=1;
		for ($i=1;$i<count($result);$i++) {
			if ($result[$i]['credit']==$result[$i-1]['credit']) $result[$i]['rank']=$result[$i-1]['rank'];
			else $result[$i]['rank']=$i;
		}
		echo json_encode($result);
		//dump($result);
	}

	function actionGetbases() {
		$db=new Model("bases");
		$result=$db->findAll(null,"bid asc");
		echo json_encode($result);
	}

	function actionGetgrantees() {
		$db=new Model("grantee");
		$result=$db->findAll(null,"gid desc","gid,name,location,general,img,target,current,status");
		//dump($result);
		$gb=new Model("log");
		for ($i=0;$i<count($result);$i++) {
			$result[$i]['rate']=round($result[$i]['current']/$result[$i]['target']*100,2);
			$count=$gb->query("select count(distinct(ip)) as count from log where gid=:gid",
												array(":gid"=>$result[$i]['gid']));
			$result[$i]['count'] = $count[0]['count'];
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
			$gb=new Model("log");
			$count=$gb->query("select count(distinct(ip)) as count from log where gid=:gid",
												array(":gid"=>$gid));
			$result['count'] = $count[0]['count'];
			echo json_encode($result);
		}
	}
	
	function actionAddreadscore() {
		$i=0;
		$data=json_decode($_POST['data']);
		/*while(1){
			if ($data[i]['uid'] && $data[i]['count']) {
				$score=$data[i]['count']/10;
				$uid=$data[i]['uid'];
				$ip = getIP();
				$date = date("Y-m-d");
				$time = date("Y-m-d H:i:s");
				$user_db=new Model("users");
				$log_db=new Model("log");
				$result=$user_db->find(
					array(
						"uid=:uid",
						":uid"=>$uid
					)
				);
				if($result){			
					$user_db->execute(
						"update users set score=score+:score where uid=:uid",
						array(
							":score"=>$score,
							":uid"=>$uid
						)
					);
					$log_db->create(
						array(
							"date" => $date,
							"time" => $time,
							"type" => 'read',
							"uid" => $uid,
							"result" => $score,
							"ip" => $ip
						)
					);
				}	
			}else{
				break;
			}
		}*/
		//$output=array('result' => 1);
		//echo json_encode($output);
		dump($data);
	}	
	
	function actionGetuserpublicinfo() {
		if ($uid=arg("uid")) {
			$db=new Model("users");
			$result=$db->find(array("uid=:uid",
															":uid"=>$uid));
			if($result){
				$publicinfo=array(
					'result' => 1,
					'uid' => $result['uid'],
					'avatar' => $result['avatar'],
					'name' => $result['name'],
					'sex' => $result['sex']
				);
			}else{
				$publicinfo=array(
					'result' => 0
				);				
				
			}
			echo json_encode($publicinfo);
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
				$userinfo=$db->find(array("loginid=:loginid",":loginid"=>$loginid));
				$email=$userinfo['email'];
				$result+=$db->update(
					array("loginid=:loginid",
								":loginid"=>$loginid),
					array("pass"=>$pass,"loginid"=>sha1($email."1cf.co".$pass))
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
			echo json_encode(array('result'=>$result));
		}
	}

	function actionChangeavatar() {
		if (@$_SESSION['loginid']) {
			$loginid=$_SESSION['loginid'];
			$db=new Model("users");
			$rs=$db->find(array("loginid=:loginid",
													":loginid"=>$loginid),null,"uid");
			$uid=$rs['uid'];
			if ($base64_original=arg("avatar")) {
				if (preg_match('/^(data:\s*image\/(\w+);base64,)/', $base64_original, $result)){
					//dump($result);
					$type = $result[2];
					$path="/www/web/1cf_co/public_html";
					$filename = "/i/img/avatar/$uid.temp.{$type}";
					//echo $filename;
					if (file_exists($filename)) {
						$delete = @unlink ($filename);
					}
					if (file_put_contents($path.$filename, base64_decode(substr(strstr($base64_original,','),1)))){
						$tempimgurl="https://www.1cf.co".$filename;
						$data = json_encode(array('url'=>$tempimgurl));   
						list($return_code, $return_content) = get_thumbnail($data);  
						if($return_code=='200') {
							$filename2=$path."/i/img/avatar/$uid.{$type}"; // 形如1.jpg
							if (file_exists($filename2)) {
								$delete = @unlink ($filename2);
							}
							$newFile = fopen($filename2,"w"); //打开文件准备写入
							fwrite($newFile,$return_content); //写入二进制流到文件
							fclose($newFile); //关闭文件
							$delete = @unlink ($path.$filename); //删除临时文件
							$filename2=str_replace("/www/web/1cf_co/public_html/i/img/avatar/","",$filename2);
							$result=$db->update(array("loginid=:loginid",
																				":loginid"=>$loginid),
																	array("avatar"=>$filename2));
							echo json_encode(array('result'=>1,'url'=>"https://static.1cf.co/img/avatar/$filename2"));
						}
					}
				}
			}
		}
	}

	function actionDonate() {
		if (arg("gid") && arg("score") && arg("score")>0) {
			$gid=arg("gid");
			$score=arg("score");
			$score=floor($score/10)*10;
			$user_db=new Model("users");
			$grantee_db=new Model("grantee");
			$log_db=new Model("log");
			$result=$user_db->find(
				array(
					"loginid=:loginid",
					":loginid"=>@$_SESSION['loginid']
				)
			);
			if ($score>$result['score']) exit;
			$credit=floor($score/10);
			$user_db->execute(
				"update users set score=score-:score , credit=credit+:credit where loginid=:loginid",
				array(
					":score"=>$score,
					":credit"=>$credit,
					":loginid"=>@$_SESSION['loginid']
				)
			);
			$grantee_db->execute(
				"update grantee set current=current+:score where gid=:gid",
				array(
					":score"=>$score,
					":gid"=>$gid
				)
			);
			$date=date("Y-m-d");
			$time=date("Y-m-d H:i:s");
			$ip=getIP();
			$log_db->create(
				array(
					"date" => $date,
					"time" => $time,
					"type" => "donate",
					"uid" => @$_SESSION['uid'],
					"tid" => 0,
					"gid" => $gid,
					"result" => $score,
					"ip" => $ip
				)
			);
			$result=$user_db->find(
				array(
					"loginid=:loginid",
					":loginid"=>@$_SESSION['loginid']
				)
			);
			$score=$result['score'];
			$credit=$result['credit'];
			$result=$grantee_db->find(
				array(
					"gid=:gid",
					":gid"=>$gid
				)
			);
			$current=$result['current'];
			$rate=round($result['current']/$result['target']*100,2);
			echo json_encode(
				array(
					"current"=>$current,
					"rate"=>$rate,
					"score"=>$score,
					"credit"=>$credit
				)
			);
		}
	}

	function actionSendactivatemail() {
		sendactivatemail();
	}
	
	function actionFeedback() {
		if (arg("uid") && arg("name") && arg("email") && arg("content")) {
			$date=date("Y-m-d H:i:s");
			$db=new Model("feedback");
			$feedback=array(
				'uid' => arg("uid"),
				'name' => arg("name"),
				'email' => arg("email"),
				'date' => $date,
				'content' => arg("content")
			);
			$result=$db->create($feedback);
			echo json_encode(
				array(
					"result"=>1
				)
			);			
		}else{
			$output=array(
				'result'=>0
			);
			echo json_encode($output);
			exit;
		}
	}
	
}

