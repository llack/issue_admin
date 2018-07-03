<?php
session_start();
header ("Content-Type: text/html; charset=UTF-8");		#다국어지원을 위한 설정

include_once($_SERVER["DOCUMENT_ROOT"]."/conf/config.db.conn.php");//디비연결
include_once($_SERVER["DOCUMENT_ROOT"]."/lib/nawoo.php");//공통라이브러리

$que = "SELECT a.cs_code,b.* FROM `erp_ocsinfo` a, issue_list b WHERE 1=1 and a.seq = b.refseq";
$res = mysql_query($que) or die(mysql_error());

while($row = mysql_fetch_array($res)) {
	$result[] = $row;
}
echo json_encode($result);