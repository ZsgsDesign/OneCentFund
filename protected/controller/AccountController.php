<?php
class AccountController extends BaseController {
	function actionIndex() {
		$this->title="资料卡";
		$this->url="ucenter";
		$log_db=new Model("log");
		$result=$log_db->query(
			"select count(distinct(gid)) 'cnt' from log where uid=:uid and gid<>0",
			array(":uid"=>@$_SESSION['uid'])
		);
		$this->donatecount=$result[0]['cnt'];
	}

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
						$loginid=sha1(arg("email")."1cf.co".md5(arg("pass")));
						$user=array(
							'rtime'=>$rtime,
							'name'=>arg("name"),
							'pass'=>md5(arg("pass")),
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
		$this->url="stat";
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
			),"time desc","*",20
		);
		for ($i=0; $i<count($result); $i++) {
			$result[$i]['ip_e']=explode(".",$result[$i]['ip']);
			if (count($result[$i]['ip_e'])<4) $result[$i]['ip_e'][0]=$result[$i]['ip_e'][1]=$result[$i]['ip_e'][2]=$result[$i]['ip_e'][3]=0;
		}
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
	
	function actionProfile() {
		$this->title="我的资料";
		$this->url="profile";
		$user_db=new Model("users");
		if ($_SERVER["REQUEST_METHOD"] == "POST" && @$_SESSION['uid']!=59) {
			$real_name=$sex=$qq=$tel=$weibo=$intro="";
			$real_name=arg('real_name');
			$sex=intval(arg('sex'));
			$qq=intval(arg('qq'));
			$tel=intval(arg('tel'));
			$weibo=arg('weibo');
			$intro=arg('intro');
			$info=array(
				"real_name"=>$real_name,
				"sex"=>$sex,
				"qq"=>$qq,
				"tel"=>$tel,
				"weibo"=>$weibo,
				"intro"=>$intro
			);
			$user_db->update(
				array("loginid=:loginid",":loginid"=>@$_SESSION['loginid']),
				$info
			);
			$this->jump("/account/profile");
		}
	}

	function actionUploadavatar() {
		if ($_SERVER["REQUEST_METHOD"] == "POST") {
		$allow_file = explode("|","jpg|png|bmp");
		$new_upload_file_ext=explode(".", $_FILES['file']['name']);
		$new_upload_file_ext = strtolower(end($new_upload_file_ext));
		if (!in_array($new_upload_file_ext,$allow_file)) exit("<center style=\"margin-top:10px;\"><span class=\"am-icon-lg am-icon-warning\" style=\"color:#F37B1D;font-size: xx-large;\"></span><br>$new_upload_file_ext: 图片格式不符合, <a href=\"#\" onclick=\"location.replace(location.href);\">重试</a></center>");
		if ($_FILES["file"]["error"] > 0) {
				exit("<center style=\"margin-top:10px;\"><span class=\"am-icon-lg am-icon-warning\" style=\"color:#F37B1D;font-size: xx-large;\"></span><br>上传失败 错误: " . $_FILES["file"]["error"] . "<br><a href=\"#\" onclick=\"location.replace(location.href);\">重试</a></center>");
		} 
		if ($_FILES["file"]["size"] / 1024 > 2048) exit("<center style=\"margin-top:10px;\"><span class=\"am-icon-lg am-icon-warning\" style=\"color:#F37B1D;font-size: xx-large;\"></span><br>超过大小限制, <a href=\"#\" onclick=\"location.replace(location.href);\">重试</a></center>");
		$path=APP_DIR."/i/img/avatar/";
		$filename=@$_SESSION['uid']."temp.".$new_upload_file_ext; // 形如1temp.jpg
		if (file_exists($path.$filename)) {
			$delete = @unlink ($path.$filename);
		}
		if(move_uploaded_file($_FILES["file"]["tmp_name"],$path.$filename)==1) {
			//开始连接微软认知服务 
			$tempimgurl="https://static.1cf.co/img/avatar/".$filename;
			$data = json_encode(array('url'=>$tempimgurl));   
			//echo $tempimgurl;
			list($return_code, $return_content) = get_thumbnail($data);  
			if($return_code=='200') {
				//获取后处理$return_content;
				$filename2=$_SESSION['uid'].".".$new_upload_file_ext; // 形如1.jpg
				if (file_exists($path.$filename2)) {
					$delete = @unlink ($path.$filename2);
				}
				//写入1.jpg
				//move_uploaded_file($_FILES["file"]["tmp_name"],$filename2);
				$newFile = fopen($path.$filename2,"w"); //打开文件准备写入
				fwrite($newFile,$return_content); //写入二进制流到文件
				fclose($newFile); //关闭文件
				$db=new Model("users");
				$result=$db->update(array("loginid=:loginid",
																	":loginid"=>@$_SESSION['loginid']),
														array("avatar"=>$filename2));
				if (!$result) exit("<center style=\"margin-top:10px;\"><span class=\"am-icon-lg am-icon-warning\" style=\"color:#F37B1D;font-size: xx-large;\"></span><br>上传失败, <a href=\"#\" onclick=\"location.replace(location.href);\">重试</a></center>");
				else if (file_exists($path.$filename)) {
					$delete = @unlink ($path.$filename);
					exit("<script>window.location.href='/account/uploadavatar';</script>");
				}
			} else {
				//echo $return_code;
				//echo $return_content;
				exit ("<center style=\"margin-top:10px;\"><span class=\"am-icon-lg am-icon-warning\" style=\"color:#F37B1D;font-size: xx-large;\"></span><br>上传裁剪失败, <a href=\"#\" onclick=\"location.replace(location.href);\">重试</a></center>");
			}
		}else {
			exit ("<center style=\"margin-top:10px;\"><span class=\"am-icon-lg am-icon-warning\" style=\"color:#F37B1D;font-size: xx-large;\"></span><br>上传失败, <a href=\"#\" onclick=\"location.replace(location.href);\">重试</a></center>");
		}
	}

		echo '<html>
						<head lang="zh-cn">
							<meta charset="UTF-8">
							<title>头像上传</title>
							<meta http-equiv="X-UA-Compatible" content="IE=edge">
							<meta name="viewport"
										content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
							<meta name="format-detection" content="telephone=no">
							<meta name="renderer" content="webkit">
							<meta http-equiv="Cache-Control" content="no-siteapp"/>
							<link rel="alternate icon" type="image/png" href="https://static.1cf.co/i/favicon.png">
							<link rel="stylesheet" href="https://static.1cf.co/css/amazeui.min.css"/>
						</head>
						<body style="background-color:transparent; margin-top:15px;">
							<div class="am-g">
								<div class="am-u-sm-4">
									<img class="am-img-thumbnail am-img-responsive" src="https://static.1cf.co/img/avatar/'.$this->userinfo['avatar'].'" alt="">
								</div>

								<div class="am-u-sm-8">
									<p>上传本地头像</p>
									<form method="post" class="am-form" enctype="multipart/form-data">
										<div class="am-form-group am-text-truncate am-form-file">
											<button type="button" class="am-btn am-btn-default am-btn-sm am-radius">
											<i class="am-icon-cloud-upload"></i> 选取图片</button>
											<input id="user-pic" name="file" type="file">
										</div>
										<p class="am-form-help" id="pic-name">jpg/png/bmp格式，2MB内</p>
										<button type="submit" class="am-btn am-btn-primary am-btn-xs">上传</button>

									</form>
								</div>
							</div>
						</body>
					</html>';
		exit;
	}

	function actionSecurity() {
		$this->title="账户安全";
		$this->url="security";
		if ($_SERVER["REQUEST_METHOD"] == "POST") {
			if (arg("old_pass") && arg("new_pass")) {
				$old=md5(arg("old_pass"));
				$new=md5(arg("new_pass"));
				$db=new Model("users");
				$result=$db->find(
					array(
						"loginid=:loginid",
						":loginid"=>@$_SESSION['loginid']
					)
				);
				if ($old==$result['pass']) {
					$email=$result['email'];
					$loginid=sha1($email."1cf.co".$new);
					$result=$db->update(
						array(
							"loginid=:loginid",
							":loginid"=>@$_SESSION['loginid']
						),
						array(
							"pass"=>$new,
							"loginid"=>$loginid
						)
					);
					if ($result) $this->jump("/account/login");
					else exit("An error occured. Please contact the administrator.");
				}
			}
		}
	}

	function actionSettings() {
		$this->url="settings";
		$this->title="高级设置";

	}
}