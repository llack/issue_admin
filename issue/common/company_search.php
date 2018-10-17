<?php
session_start();
header ("Content-Type: text/html; charset=UTF-8");		#다국어지원을 위한 설정

include_once($_SERVER["DOCUMENT_ROOT"]."/conf/config.db.conn.php");//디비연결

$que = " select * from erp_ocsinfo order by cs_name ";
$res = mysql_query($que) or die(mysql_error());
$i = 0;
while($row = mysql_fetch_array($res)) {
	$result[$i]["title"] = $row[cs_name]."";
	$result[$i]["description"] = $row[cs_code]."";
	$result[$i]["url"] = "?cs_code=".$row[cs_code]."";
	$i++;
}

echo json_encode($result); 
?>