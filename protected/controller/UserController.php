<?php
class UserController extends BaseController {
  function actionInfo() {
    if (arg("username")) {
      $name=arg("username");
      $db=new Model("users");
      $result=$db->find(
        array(
          "name=:name",
          ":name"=>$name
        )
      );
      @$result['rate']=round($result['cor']/$result['ans']*100,2);
      $this->newuserinfo=$result;
    }
  }

}