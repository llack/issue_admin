<?php
session_start();
header ("Content-Type: text/html; charset=UTF-8");		#다국어지원을 위한 설정

include_once($_SERVER["DOCUMENT_ROOT"]."/conf/config.db.conn.php");//디비연결
include_once($_SERVER["DOCUMENT_ROOT"]."/lib/nawoo.php");//공통라이브러리
$fn = new Simple_query();

$max = count($_REQUEST[employee]);
if($max >= 1 ) {
	for($i = 0; $i < $max; $i++) {
		$fn->simple_insert($_REQUEST[employee][$i],"employee_list");
	}
}
echo json_encode("저장되었습니다.");exit;
