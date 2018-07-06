<?php
session_start();
header("Content-Type: text/html; charset=UTF-8");

include_once($_SERVER["DOCUMENT_ROOT"]."/conf/config.db.conn.php");//디비연결
include $_SERVER["DOCUMENT_ROOT"]."/lib/nawoo.php";

$que = " select * from issue_list";// where refseq ='".$_REQUEST[seq]."' order by regdate desc";// where seq = '".$_REQUEST[seq]."' ";
$res = mysql_query($que) or die(mysql_error());
$cnt = mysql_num_rows($res);
?>
<!DOCTYPE>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta charset="UTF-8">

<link rel="stylesheet" href="/css/semantic.min.css">
<link rel="stylesheet" href="/css/datatables.min.css">
<link rel="stylesheet" href="/css/calendar.min.css">
<script src="/js/jquery-3.2.1.js"></script>
<script src="/js/nawoo.js"></script> 
<script src="/js/semantic.min.js"></script>
<script src="/js/calendar.min.js"></script>
<script src="/js/datatables.min.js"></script>
<script src="/js/docs.js"></script>
<title>업무일지</title>
</head>
<style>
body {
	padding : 1rem;
}
#datatables_wrapper {
	padding-bottom:30px;
}
.dropdown {
min-width : unset !important;
}
</style>
<body>
<h3 class="ui block header">업무기록</h3>
<table id="datatables">
	<thead>
		<th>No</th>
		<th>수정내용</th>
		<th>수정자</th>
		<th>수정시간</th>
	</thead>
	<tbody>
	<? if($cnt == 0 ) { ?>
		<tr><td colspan="4" align="center">내용이 없습니다.</td></tr>		
	<? } else {
	$i = 1; 
	while($row = mysql_fetch_array($res)) { ?>
		<tr align="center">
			<td><?=$i?></td>		
			<td><?=$row[memo]?></td>		
			<td><?=$row[regdate]?></td>		
			<td><?=$row[end_date]?></td>		
		</tr>
	<? $i++;} 
	}?>
	</tbody>

</table>
</body>
<script>
$(document).ready(function(){
	fn_table("#datatables");
});
</script>
</html>