<?php
session_start();
header ("Content-Type: text/html; charset=UTF-8");		#다국어지원을 위한 설정
if($_SESSION["USER_LEVEL"]!="A") {
	exit;
}
include_once($_SERVER["DOCUMENT_ROOT"]."/conf/config.db.conn.php");//디비연결
include_once($_SERVER["DOCUMENT_ROOT"]."/lib/lib_public.php");//공통라이브러리
if($_REQUEST[mode]=="approve") {
	$user_level = "U";
} else if($_REQUEST[mode]=="deny"){
	$user_level = "";
} else {
	$user_level = $_REQUEST[user_level];
}
$que = "update member set user_level = '".$user_level."' where seq = '".$_REQUEST[seq]."' ";
mysql_query($que) or die(mysql_error());

echo json_encode($_REQUEST[mode]);
?>