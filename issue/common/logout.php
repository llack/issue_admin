<?
session_start();

header ("Content-Type: text/html; charset=UTF-8");		#다국어지원을 위한 설정

include_once($_SERVER["DOCUMENT_ROOT"]."/conf/config.db.conn.php");//디비연결
include_once($_SERVER["DOCUMENT_ROOT"]."/lib/lib_public.php");//공통라이브러리


$js = new javascript();
$logtime = date("Y-m-d H:i:s");

$timeout = time();
$que = "update member set user_logout = '$logtime' where user_id = '$_SESSION[USER_ID]'";
mysql_query($que) or die(mysql_error());

$_SESSION["USER_ID"] = "";
$_SESSION["USER_NAME"] = "";
$_SESSION["USER_GROUP"] = "";
$_SESSION["USER_PART"] = "";
$_SESSION["USER_INFO1"] = "";
$_SESSION["USER_INFO2"] = "";
$_SESSION["USER_LEVEL"] = "";
$_SESSION["HOST"] = "";

session_destroy();

/*
 $session_file = "sess_" . $_REQUEST[PHPSESSID];
 @unlink("/tmp/$session_file");
 */
$result = array("url"=>"/");
echo json_encode($result); 
?>