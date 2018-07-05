<?php
session_start();
header ("Content-Type: text/html; charset=UTF-8");		#다국어지원을 위한 설정

include_once($_SERVER["DOCUMENT_ROOT"]."/conf/config.db.conn.php");//디비연결
include_once($_SERVER["DOCUMENT_ROOT"]."/lib/nawoo.php");//공통라이브러리
$fn = new Simple_query();

$max = count($_REQUEST[issue]);
$issue = $_REQUEST[issue];
if($max >= 1 ) {
	for($i = 0; $i < $max; $i++) {
		$que = "insert into issue_list set ";
		$que_mid = "";
		foreach ($issue[$i] as $key=>$value) {
			$que_mid .= ", $key = '$value' ";
		}
		
		$que_mid = substr($que_mid,1);
		mysql_query($que.$que_mid) or die(mysql_error());
		
		$seq = mysql_insert_id();
		$que_his = " insert into issue_history set 
					refseq =".$seq."
					, user_name = '".$_SESSION["USER_NAME"]."'
					, memo = '최초등록자 : ".$_SESSION["USER_NAME"]."'
					, regdate = '".date("Y-m-d H:i:s")."'
					";
		mysql_query($que_his) or die(mysql_error());
	}
}

echo json_encode("저장되었습니다.");exit;
