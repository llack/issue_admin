<!DOCTYPE>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta charset="UTF-8">
<link rel="icon" href="/img/settings.png" type="image/x-icon" />
<link rel="stylesheet" href="/css/semantic.min.css">
<link rel="stylesheet" href="/css/datatables.min.css">
<link rel="stylesheet" href="/css/calendar.min.css">
<link rel="stylesheet" media ="only screen and (max-width:1000px)" href="/css/midiaCustom.css">
<script src="/js/jquery-3.2.1.js"></script>
<script src="/js/nawoo.js"></script> 
<script src="/js/semantic.min.js"></script>
<script src="/js/calendar.min.js"></script>
<script src="/js/datatables.min.js"></script>
<script src="/js/dataTables.searchHighlight.min.js"></script>
<script src="/js/jquery.highlight.js"></script>
<?
session_start();

include $_SERVER["DOCUMENT_ROOT"]."/lib/fn_index.php";

$toolArr = array("keycode","colgroup","colorPicker");
$toolName = ($_REQUEST[toolName] != "unset" && $_REQUEST[toolName] != "") ? $_REQUEST[toolName] : "colgroup"; 
?>
<title>개발도구 - <?=$toolName?></title> 
</head>
<style>
body {
	padding : 1rem;
}
.ui.container.table {
	width: 100%;
	height:100%;
	overflow-y:auto;
	padding:1rem;
	border-bottom : 2px solid #a333c8!important;
}
</style>
<body>
<!-- 메인 테이블  -->
<div class="ui container table purple segment" style="width: 100%!important">
	<h2 class="ui header" style="margin-top: 0px">
	
	<i class="circular purple archive icon "></i>
	<div class="content">개발도구: <?=$toolName?>
	</div>
	</h2>
	<div class="ui center aligned">
		<form name="form" >
		도구 선택 :  
		  <select name="toolName" id="toolName" onchange="document.form.submit()">
		  		<?foreach($toolArr as $value) { 
		  		$selected = ($value == $toolName) ? "selected" : "";?>
		  		<option value="<?=$value?>" <?=$selected?>><?=$value?></option>
		  		<? } ?>
		  </select>
		  </form>
	</div>
	<? include $_SERVER["DOCUMENT_ROOT"]."/tool/".$toolName.".php";?>
<script>
$(document).ready(function(){
	$("#toolName").dropdown(); //필터검색
});
</script>
