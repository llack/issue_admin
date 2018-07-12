<?php
session_start();
header("Content-Type: text/html; charset=UTF-8");

include_once($_SERVER["DOCUMENT_ROOT"]."/conf/config.db.conn.php");//디비연결
include $_SERVER["DOCUMENT_ROOT"]."/lib/nawoo.php";

$que = " select * from issue_history where refseq ='".$_REQUEST[seq]."' order by regdate desc";
$res = mysql_query($que) or die(mysql_error());
$cnt = mysql_num_rows($res);

$que_issue = " select * from issue_list where seq = '".$_REQUEST[seq]."' ";
$res_issue = mysql_query($que_issue) or die(mysql_error());
$row_issue = mysql_fetch_array($res_issue);
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
	overflow-x : auto;
}
#datatables_wrapper {
	padding-bottom:30px;
}

</style>
<body>
<h3 class="ui block header">[<?=$row_issue[cs_name]?>]<br/><?=$row_issue[memo]?></h3>
<table>
<colgroup>
	<col width="20%">
	<col width="80%">
</colgroup>
<tr>
	<td><div class="ui right pointing purple basic label">요청 및 지시사항</div></td>
	<td><?=$row_issue[order_memo]?></td>
</tr>
<tr>
	<td><div class="ui right pointing purple basic label">원인분석</div></td>
	<td></td>
</tr>
<tr>
	<td><div class="ui right pointing purple basic label">결과</div></td>
	<td></td>
</tr>
</table>
<br/><br/>
<div class="ui left aligned">
	<button class="ui button inverted purple checkall">
	  <i class="check circle icon"></i>
	  전체선택
	</button>
	<input type="checkbox" id="checkall" style="display:none;"/>
	<button class="ui button inverted red" onclick="delete_history()">
	  <i class="check trash alternate icon"></i>
	  선택삭제
	</button>
	<button class="ui button inverted red" style="float:right" onclick="self.close();">
	  <i class="times icon"></i>
	  닫기
	</button>
</div>
<br/>
<table id="datatables" data-order="[]" class="ui table center aligned small">
	<colgroup>
		<col width="10%">
		<col width="10%">
		<col width="40%">
		<col width="20%">
		<col width="20%">
	</colgroup>
	<thead>
		<tr>
			<th class="no-search no-sort" style="background-color:#a333c8">
				<i class="large briefcase icon" style="color:white!important"></i>
			</th>
			<th class="no-search">No</th>
			<th class="no-sort">수정내용</th>
			<th>수정자</th>
			<th class="no-search">수정시간</th>
		</tr>
	</thead>
	<tbody>
	<? if($cnt == 0 ) { ?>
		<tr><td colspan="5" align="center">내용이 없습니다.</td></tr>		
	<? } else {
	$i = 1; 
	while($row = mysql_fetch_array($res)) { 
		$time = explode(" ",$row[regdate]);?>
		<tr align="center">
			<td style="background:#f9fafb!important">
			<div class="ui toggle checkbox" style="width:50px">
			      <input type="checkbox" id="chk" value="<?=$row[seq]?>"/>
			      <label></label>
			    </div>
			</td>
			<td><?=$i?></td>		
			<td style="text-align: left"><?=$row[memo]?></td>		
			<td><?=$row[user_name]?></td>		
			<td><?=$time[0] ."<br/>" . $time[1];?></td>		
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

function delete_history() {
	var c = $("#chk:checked");
	if(c.length==0) {
		alert("삭제 대상이 없습니다.");
		return;
	}
	var param = {};
	if(confirm("삭제한 수정사항은 복구할 수 없습니다.\n총 "+c.length+"건 삭제하시겠습니까?")==true) {
		fn_delete("issue_history","seq");
	} else {
		return;
	}
}
</script>
</html>