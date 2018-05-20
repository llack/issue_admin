<?php
session_start();
header ("Content-Type: text/html; charset=UTF-8");		#다국어지원을 위한 설정
if($_SESSION["USER_LEVEL"]!="A") {
	exit;
}
include_once($_SERVER["DOCUMENT_ROOT"]."/conf/config.db.conn.php");//디비연결

if($_REQUEST[mode]=="approve") {
	$user_level = "U";
} else if($_REQUEST[mode]=="deny"){
	$user_level = "";
} else {
	$user_level = $_REQUEST[user_level];
}
$que = "update member set user_level = '".$user_level."' where no = '".$_REQUEST[no]."' ";
mysql_query($que) or die(mysql_error());

echo json_encode($_REQUEST[mode]);
?>