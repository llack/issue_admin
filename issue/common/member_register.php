<?php
session_start();
header ("Content-Type: text/html; charset=UTF-8");		#다국어지원을 위한 설정

include_once($_SERVER["DOCUMENT_ROOT"]."/conf/config.db.conn.php");//디비연결

$que = "select * from member where user_id = '" . $_REQUEST[user_id] . "'";
$res = mysql_query($que);
$total = mysql_num_rows($res);
if ($total > 0) {
	$result = array("msg"=>"중복된 아이디 입니다!\n다른 아이디를 입력해주세요!"
					,"url"=>"/common/login.php"
					,"param"=>$_REQUEST);

	echo json_encode($result);
	exit;
}

$que = "insert into member set user_id = '$_REQUEST[user_id]', user_pw = '$_REQUEST[user_pwd]' , user_name = '$_REQUEST[user_name]' , user_email = '$_REQUEST[user_email]', hp = '$_REQUEST[hp]',user_dept = '$_REQUEST[user_dept]', user_part = '$_REQUEST[user_part]', user_info1 = '$_REQUEST[user_info1]',user_info2 = '$_REQUEST[user_info2]',  lastpass = DATE_ADD(now(), INTERVAL 1 MONTH), position = '$_REQUEST[position]',user_level = '',regdate = '".date("Y-m-d")."';";
mysql_query($que) or die(mysql_error());
$result = array("msg"=>"등록되었습니다.\n관리자 승인후 사용가능합니다.","url"=>"/");

echo json_encode($result);
exit;
?>
