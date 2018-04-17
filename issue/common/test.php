<?php
session_start();
header('Content-type:application/json;charset=utf-8');

$result = array("msg"=>"중복된 아이디 입니다!\n다른 아이디를 입력해주세요!","url"=>"/common/login.php","param"=>$_REQUEST);

echo json_encode($result);