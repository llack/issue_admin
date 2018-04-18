<?
session_start();
if($_SESSION["USER_NAME"]=="") {
	header("Location:/common/login.php");
}
if($_SESSION["USER_ID"]!="admin") {
	echo "<script>alert('권한이 없습니다.');
		history.back();
		</script>";
}
	
include $_SERVER["DOCUMENT_ROOT"]."/common/header.php";

?>
<body>
<div class="ui container side ">
<? include $_SERVER["DOCUMENT_ROOT"]."/common/company_list.php"; ?>
</div>
<div class="ui container table purple segment">
<div class="right aligned">
	<a class="ui tag label">menu</a>
	<a class="ui red tag label">사원관리</a>
	<a class="ui teal tag label">사원 권한관리</a>
</div>
<h2 class="ui header" style="margin-top: 0px">

<i class="circular purple users icon icon"></i>
<div class="content">사원 권한관리</div>
</h2>
<!-- table start -->

<!-- /table container -->
</div>
</body>
<script>
$(document).ready(function(){
});
</script>
</html>







