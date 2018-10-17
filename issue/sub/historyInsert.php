<?php
session_start();
header ("Content-Type: text/html; charset=UTF-8");		#다국어지원을 위한 설정

include_once($_SERVER["DOCUMENT_ROOT"]."/conf/config.db.conn.php");//디비연결
include_once($_SERVER["DOCUMENT_ROOT"]."/lib/nawoo.php");//공통라이브러리
$data = $_REQUEST[param];
$que = " insert into issue_history set 
		memo = '".addslashes($data[memo])."'
		,refseq = '".$data[refseq]."'
		,user_name = '".$_SESSION["USER_NAME"]."'
		,gubunColor = '".$data[gubunColor]."'
		,regdate = now()
		 ";
mysql_query($que) or die(mysql_error());
echo json_encode("");
?>