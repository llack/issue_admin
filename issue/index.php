<?
session_start();
if($_SESSION["USER_NAME"]=="") {
	header("Location:/common/login.php");
}
include $_SERVER["DOCUMENT_ROOT"]."/common/header.php";

?>
<body>
<div class="ui container side">
<? include $_SERVER["DOCUMENT_ROOT"]."/common/company_list.php"; ?>
</div>
<div class="ui container table">
이슈관리자인데...
</div>
</body>
</html>