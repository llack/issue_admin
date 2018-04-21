<?
session_start();

include $_SERVER["DOCUMENT_ROOT"]."/common/header.php";

?>
<body>
<div class="ui container side">
<? include $_SERVER["DOCUMENT_ROOT"]."/common/company_list.php"; ?>
</div>
<!-- 메인 테이블  -->
<div class="ui container table purple segment">
	<div class="right aligned">
		<a class="ui tag label">menu</a>
		<a class="ui red tag label">업무관리</a>
		<a class="ui teal tag label">업무현황</a>
	</div>
	<h2 class="ui header" style="margin-top: 0px">
	
	<i class="circular purple users icon icon"></i>
	<div class="content">이슈 리스트</div>
	</h2>
	<form name="form">
	<h4 class="ui header center aligned">
	음.. 이부분은 뭘로 해야될지 모르겠네~
	</h4>
	</form>
</div>
</body>
</html>