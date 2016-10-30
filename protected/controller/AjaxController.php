<?php
class AjaxController extends BaseController {
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

  function actionSubmit() {
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
						"uid" => @$_SESSION['uid'],
						"tid" => $problem[0],
						"gid" => 2,
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
				} else {
					$grantee_db=new Model("grantee");
					$grantee_db->execute("update grantee set current=current+10 where gid=:gid",
											array(":gid" => 2));
				}
				$log_db->create(
					array(
						"date" => $date,
						"time" => $time,
						"type" => "ans",
						"uid" => @$_SESSION['uid'],
						"tid" => $problem[0],
						"gid" => 2,
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
			if ($this->islogin) {
				$score=$user_db->find(
					array(
						"loginid=:loginid",
						":loginid"=>@$_SESSION['loginid']
					)
				);
				$output['score']=$score['score'];
				}
			echo json_encode($output);
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

	function actionUsersettings() {
		$key=arg("name");
		$db=new Model("users");
		$result=$db->find(
			array(
				"loginid=:loginid",
				":loginid"=>@$_SESSION['loginid']
			)
		);
		$uid=$result['uid'];
		$db=new Model("user_setting");
		$value=arg('value');
		$db->update(
			array(
				"uid=:uid",
				":uid"=>$uid
			),
			array(
				$key=>$value
			)
		);
	}

	function actionGetimmortalwork() {
		$file=file_get_contents("http://immortal.work/api/restful/posts/hottest/10");
		if ($file) {
			$list=json_decode($file);
			$db=new Model("read");
			//dump($list);
			//$db->delete(null);
			$id=1;
			foreach ($list->Posts as $p) {
				$link="http://immortal.work/p/".$p->_id;
				$title=$p->title;
				$timetemp=explode("T",$p->postedAt);
				$timetemp[1]=rtrim($timetemp[1],"Z");
				$time=$timetemp[0]." ".$timetemp[1];
				$count=$p->viewCount;
				$db->create(
					array(
						"id"=>$id,
						"link" => $link,
						"time" => $time,
						"title" => $title,
						"count" => $count
					)
				);
				$id++;
			}
		}
	}
}