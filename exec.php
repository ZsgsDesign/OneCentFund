<?
require_once("conn.php");
$rs=$db->query("select * from users order by uid asc;");
$user=array();
while($row=$rs->fetch()) {
  $user['uid'][]=$row['uid'];
  $user['loginid'][]=sha1($row['email']."1cf.co".$row['pass']);
}
//var_dump($user);
$rs=$db->prepare("update users set loginid=? where uid=?");
for ($i=0;$i<count($user['uid']);$i++) {
  echo $rs->execute(array($user['loginid'][$i],$user['uid'][$i]));
}