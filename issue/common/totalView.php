 <?php
session_start();
header ("Content-Type: text/html; charset=UTF-8");		#다국어지원을 위한 설정

include_once($_SERVER["DOCUMENT_ROOT"]."/conf/config.db.conn.php");//디비연결
include_once($_SERVER["DOCUMENT_ROOT"]."/lib/nawoo.php");//공통라이브러리
$ymd = strtotime($_REQUEST[date]);
$date = date("Y-m",strtotime("-1 month",$ymd));
if($_REQUEST[mode] == "after") {
	$date = date("Y-m",strtotime("+1 month",$ymd));
}
$_SESSION['ISSUE_DATE'] = $date;
$que = " select count(*) as cTotal, sum(state= 'Y') as yes, sum(state = 'N')+sum(state = 'G') as no, sum(state = 'Z') as pause from issue_list where end_date
					like '".$date."%' ";
$res = mysql_query($que) or die(mysql_error());
$row = mysql_fetch_assoc($res);

$result["date"] = $date;
$avg_issue = ( (int)$row[yes] / (int)$row[cTotal] ) * 100;
$avg_issue = number_format($avg_issue,1);
$result["avg"] = $avg_issue;

$result["text"]["cMonth"] = date("Y년 m",strtotime($date));
$result["text"]["cYes"] = number_format($row[yes]);
$result["text"]["cNo"] = number_format($row[no]);
$result["text"]["cPause"] = number_format($row[pause]);
$result["text"]["cIng"] = number_format($row[ing]);
$result["text"]["cTotal"] = number_format($row[cTotal]);

echo json_encode($result);exit;
