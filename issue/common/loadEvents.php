<?php
session_start();
header ("Content-Type: text/html; charset=UTF-8");		#다국어지원을 위한 설정

include_once($_SERVER["DOCUMENT_ROOT"]."/conf/config.db.conn.php");//디비연결
include_once($_SERVER["DOCUMENT_ROOT"]."/lib/nawoo.php");//공통라이브러리

$que = "SELECT a.color,b.* FROM `erp_ocsinfo` a, issue_list b WHERE 1=1 and a.seq = b.refseq";
$res = mysql_query($que) or die(mysql_error());

while($row = mysql_fetch_assoc($res)) {
	if($row[regdate]!=$row[end_date]) {
		$row[customEnd] = date("Y-m-d",strtotime($row[end_date]) + 86400); //달력 실제반영 +1 day
	}
	$result[] = $row;
}
echo json_encode($result);
?>