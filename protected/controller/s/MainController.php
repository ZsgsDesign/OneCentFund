<?php
class MainController extends BaseController {
	
	function actionIndex(){ //首页
		if (arg("name")) {
			$_SESSION['name']=arg('name');
			$_SESSION['school']=arg('school');
			echo json_encode(array('result'=>1));
		}
		if (arg("openid")) {
			$openid=arg("openid");
			$user_db=new Model("s");
			$rs=$user_db->findCount(array(
				"openid=:openid",
				":openid"=>$openid
			));
			if ($rs) $this->jump("/s/result");
			$_SESSION['openid']=arg("openid");
		} else {
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

	function actionLanding() {

	}
	function actionResult() {

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
	} //result, ans, score


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
				'score'	=> intval($_SESSION['score']),
				'date'	=> $date,
				'time'	=> $time
			);
			$user_db->create($row);
			$output=array(
				'reuslt'=>0,
				'name'=>$_SESSION['name'],
				'school'=>$_SESSION['school'],
				'score'=>$_SESSION['score']
			);
			echo json_encode($output);
		}
	}

	
}