<?php
session_start();
header ("Content-Type: text/html; charset=UTF-8");		#다국어지원을 위한 설정

include_once($_SERVER["DOCUMENT_ROOT"]."/conf/config.db.conn.php");//디비연결
include_once($_SERVER["DOCUMENT_ROOT"]."/lib/nawoo.php");//공통라이브러리

$fn = new Simple_query();

$max = count($_REQUEST[param]);
$obj = $_REQUEST[param];
for($i = 0; $i < $max; $i++) {
	$fn->simple_delete($obj[$i][table],$obj[$i][id],$obj[$i][chk]);
}
echo json_encode("삭제되었습니다.");

