<? 
session_start();

header ("Content-Type: text/html; charset=UTF-8");		#다국어지원을 위한 설정

include_once($_SERVER["DOCUMENT_ROOT"]."/conf/config.db.conn.php");//디비연결
include $_SERVER["DOCUMENT_ROOT"]."/lib/nawoo.php";
?>
<!DOCTYPE>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta charset="UTF-8">
<link rel="stylesheet" href="/css/semantic.min.css">
<link rel="stylesheet" href="/css/datatables.min.css">
<script src="/js/jquery-3.2.1.js"></script>
<script src="/js/semantic.min.js"></script>
<script src="/js/datatables.min.js"></script>
<script src="/js/docs.js"></script>
<script src="/js/nawoo.js"></script> 
<title><?=TITLE?></title>
</head>
<style>
body {
	padding : 1rem;
}
.ui.container.side {
	width:15%;
	height:94%;
	overflow:hidden;
	float:left;
}
.ui.container.table {
	width: 85%;
	height:94%;
	overflow-y:auto;
/* 	border:1px solid; */
	padding:1rem;
}
</style>

<? include $_SERVER['DOCUMENT_ROOT']."/common/menu.php";?>

