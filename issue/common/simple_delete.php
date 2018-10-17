 <?php
session_start();
header ("Content-Type: text/html; charset=UTF-8");		#다국어지원을 위한 설정

include_once($_SERVER["DOCUMENT_ROOT"]."/conf/config.db.conn.php");//디비연결
include_once($_SERVER["DOCUMENT_ROOT"]."/lib/nawoo.php");//공통라이브러리

$fn = new Simple_query();
$echo = $fn->simple_delete($_REQUEST[table],$_REQUEST[id],$_REQUEST[chk]);

if(is_array($_REQUEST[chk])) {
	echo json_encode("삭제되었습니다.");
	exit;
} else {
	echo json_encode($echo);
	exit;
}
