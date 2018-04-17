<?php
session_start();
header('Content-type:application/json;charset=utf-8');

$result = array("msg"=>"중복아이디입니다.","url"=>"/common/login.php","param"=>$_POST);

echo json_encode($result);