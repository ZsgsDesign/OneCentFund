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
      $this->newuserinfo=$result;
    }
  }

}