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
	
}