<?php
class AccountController extends BaseController {
	
	function actionLogin(){
		$this->url="login";
		$this->title="注册/登录";
		$this->msg1=$this->msg2="";
		if ($_SERVER['REQUEST_METHOD']=="POST") { //如果提交
			if (@$_GET['register']==1) { //如果是注册
				$db=new Model("users");
				$error=0;
				if(arg("name") && arg("pass") && arg("email")) {
					$result=$db->find(array("name=:name",
																	":name"=>arg("name")));
					if (!empty($result)) {
						$this->msg2="用户名已被使用";
						$error=1;
					}
					$result=$db->find(array("email=:email",
																	":email"=>arg("email")));
					if (!empty($result)) {
						$this->msg1="邮箱已被使用";
						$error=1;
					}
					if (!$error) {
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
						$_SESSION['loginid']=$loginid;
						sendactivatemail();
						$this->jump("/");
					}
				}
				//echo json_encode($output);
			} else { //如果是登录
				if ($email=arg("email") && $pass=arg("pass")) {
					$loginid=sha1(arg("email")."1cf.co".md5(arg("pass")));
					$db=new Model("users");
					$result=$db->find(array("loginid=:loginid",":loginid"=>$loginid));
					if (empty($result)) {
						$this->msg1="邮箱或密码错误";
					} else {
						$_SESSION['loginid']=$loginid;
						$this->jump("/");
					}
				}
			}
		}
	}

	function actionLogout() {
		session_unset();
		session_destroy();
		$this->jump("/");
	}

	function actionActivate() {
		if (arg("id") && arg("act")) {
			$uid=arg("id");
			$act=arg("act");
			$db=new Model("users");
			$result=$db->find(
				array(
					"uid=:uid",
					":uid"=>$uid
				)
			);
			$email=$result['email'];
			if(md5(md5($email))==$act){
				$result=$db->update(
					array(
						"uid=:uid",
						":uid"=>$uid
					),
					array(
						"emailok"=>1
					)
				);
			}
		}
	}

	function actionStat() {
		$this->title="数据统计";
		$user_db=new Model("users");
		$result=$user_db->find(
			array(
				"loginid=:loginid",
				":loginid"=>$_SESSION['loginid']
			)
		);
		$uid=$result['uid'];
		$this->correct=$result['cor'];
		$this->score=$result['score'];
		$this->credit=$result['credit'];
		$this->total=$result['ans'];
		$this->rate=round($this->correct/$this->total*100,2);
		
		$log_db=new Model("log");
		$result=$log_db->findAll(
			array(
				"uid=:uid and (type='ans' or type='donate')",
				":uid"=>$uid
			),null,"8",20
		);
		$this->log=$result;
		$result=$log_db->query(
			"SELECT date,count(result) 'total',sum(case when result > 9 then 1 else 0 end) 'correct' FROM `log` where uid=:uid group by date order by date ASC",
			array(
				":uid"=>$uid
			)
		);
		$cnt_date="";
		$cnt_num="";
		$cnt_correct="";
		foreach ($result as $row) {
			$cnt_date.="'".$row['date']."',";
			$cnt_num.=$row['total'].",";
			$cnt_correct.=$row['correct'].",";
		}
		$this->cnt_date = rtrim($cnt_date,','); 
		$this->cnt_num = rtrim($cnt_num,','); 
		$this->cnt_correct = rtrim($cnt_correct,','); 

	}
	
}