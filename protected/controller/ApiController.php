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
		$json=array(
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
		$output=array(
			'status' => 1,
			'json' => $json
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
			if ($islogin) {
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
	
}