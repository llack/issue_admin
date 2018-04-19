<?php
session_start();
header ("Content-Type: text/html; charset=UTF-8");		#다국어지원을 위한 설정
if($_SESSION["USER_NAME"]=="") {
	exit;
}
include_once($_SERVER["DOCUMENT_ROOT"]."/conf/config.db.conn.php");//디비연결

$que = " update member set 
		user_name = '".$_REQUEST[user_name]."'
		, user_pw = '".$_REQUEST[user_pwd]."'
		, position = '".$_REQUEST[position]."'
		, user_email = '".$_REQUEST[user_email]."'
		, hp = '".$_REQUEST[hp]."'
		 where user_id = '".$_SESSION["USER_ID"]."' and seq = '".$_REQUEST[seq]."'  
		 ";
$res = mysql_query($que) or die(mysql_error()); 
if($res == 1) {
	echo json_encode("수정되었습니다.");
	exit;
} else {
	echo json_encode("수정에 실패하였습니다.");
	exit;
}
?>