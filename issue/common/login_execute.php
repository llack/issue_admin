<?
session_start();
header ("Content-Type: text/html; charset=UTF-8");		#다국어지원을 위한 설정

include_once($_SERVER["DOCUMENT_ROOT"]."/conf/config.db.conn.php");//디비연결
include_once($_SERVER["DOCUMENT_ROOT"]."/lib/lib_public.php");//공통라이브러리

$dbms = new dbms();
$result = array();
$que = "select * from member where user_id = '" . mysql_escape_string($_REQUEST[id]) . "' and user_pw = '" . mysql_escape_string(addslashes(htmlspecialchars($_REQUEST[password]))) . "'";
$res = mysql_query($que);
$row = mysql_fetch_array($res);
$total = mysql_num_rows($res);

/*
if ($row[user_id] != "" && $row[user_level]!="A") {
	if ($row[login_check]==0) {
		$js->AlertBack("로그인 불가능상태입니다.\\n관리자에게 문의하세요");
		exit;
	}
}
*/
$logtime = date("Y-m-d H:i:s");

if ($total == 0) {
	$result = array("msg"=>"아이디 또는 비밀번호를 확인해주세요.");
	echo json_encode($result);
}
else {
	if ($row[user_level]=="") {
		$result = array("msg"=>"관리자 승인후 이용가능합니다!");
		echo json_encode($result);
	}
		
	$_SESSION["USER_ID"] = $row[user_id];
	$_SESSION["USER_NAME"] = $row[user_name];
	$_SESSION["USER_GROUP"] = $row[user_dept];
	$_SESSION["USER_LEVEL"] = $row[user_level];
	$_SESSION["HOST"] = $HTTP_HOST;
	
	$dbms->execute("update member set user_login = '$logtime',lastIP='$REMOTE_ADDR' where user_id = '$row[user_id]'");
	$result = array("url"=>"/");
	echo json_encode($result);
}