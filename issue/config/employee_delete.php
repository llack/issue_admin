<?php
session_start();
header ("Content-Type: text/html; charset=UTF-8");		#다국어지원을 위한 설정
if($_SESSION["USER_ID"]!="admin") {
	exit;
}
include_once($_SERVER["DOCUMENT_ROOT"]."/conf/config.db.conn.php");//디비연결
include_once($_SERVER["DOCUMENT_ROOT"]."/lib/lib_public.php");//공통라이브러리

$que = " delete from member where seq = '".$_REQUEST[seq]."' ";
mysql_query($que) or die(mysql_error());

echo json_encode("삭제되었습니다.");
?>