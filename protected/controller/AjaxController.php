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
						"uid" => @$_SESSION['uid'],
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
}