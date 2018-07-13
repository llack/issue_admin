<?php
session_start();
header ("Content-Type: text/html; charset=UTF-8");		#다국어지원을 위한 설정

include_once($_SERVER["DOCUMENT_ROOT"]."/conf/config.db.conn.php");//디비연결
include_once($_SERVER["DOCUMENT_ROOT"]."/lib/nawoo.php");//공통라이브러리
$black = "#FFAAAA#FFD5AA#FFFFAA#D5FFAA#AAFFAA#AAFFD5#AAFFFF#AAD5FF#FFAAFF#D5AAFF#FFAAD5
			#FFAA55#FFFF55#AAFF55#55FF55#55FFAA#55FFFF#FFFF00#80FF00#00FF00#00FF80#00FFFF
			#EABFBF#EAD4BF#EAEABF#D4EABF#BFEABF#BFEAD4#BFEAEA#BFD4EA#BFBFEA#D4BFEA#EABFEA
			#EABFD4#D5D580#AAD580#80D5D5#D5D5D5#FFFFFF"; //검은색들은 이걸로 추가

$que = "SELECT a.color,b.* FROM `erp_ocsinfo` a, issue_list b WHERE 1=1 and a.seq = b.refseq";
$res = mysql_query($que) or die(mysql_error());

while($row = mysql_fetch_assoc($res)) {
	if($row[regdate]!=$row[end_date]) {
		$row[customEnd] = date("Y-m-d",strtotime($row[end_date]) + 86400); //달력 실제반영 +1 day
	}
	$row["fontColor"] = ( strpos($black,$row[color]) !== false && $row[color] !="") ? "black" : "white"; //밝은색은 검은색으로 
	if($row[color] == "#FFFFFF") { //흰색은 보더라도 있어야.. 
		$row["borderColor"] = "purple"; 
	}
	$result[] = $row;
}
echo json_encode($result);
?>