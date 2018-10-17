<?php
session_start();
header("Content-Type: text/html; charset=UTF-8");

include_once($_SERVER["DOCUMENT_ROOT"]."/conf/config.db.conn.php");//디비연결
include $_SERVER["DOCUMENT_ROOT"]."/lib/nawoo.php";
include $_SERVER["DOCUMENT_ROOT"]."/lib/lib.php";
$lib = new LibCode();

$memoList = array("detail_memo"=>"업무상세","order_memo"=>"요청 및 지시사항","cause_memo"=>"원인분석","result_memo"=>"해결방안 및 결과");
$memoColor = array("detail_memo"=>"blue","order_memo"=>"blue","cause_memo"=>"purple","result_memo"=>"purple");

$que = " select * from issue_history where refseq ='".$_REQUEST[seq]."' order by regdate";
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
<title>업무기록</title>
</head>
<style>
body {
	padding : 1rem;
	overflow-x : auto;
}
#datatables_wrapper {
	padding-bottom:30px;
}
.right {
	float : right;
}
</style>
<body>
<h3 class="ui block header">[<?=$row_issue[cs_name]?>]<br/><?=$lib->url_auto_link($row_issue[memo],true)?></h3>
<table style="width:100%">
<colgroup>
	<col width="15%">
	<col width="70%">
	<col width="15%">
</colgroup>
<? foreach($memoList as $memo=>$text){ ?>
<tr height="60">
	<td><div class="ui right pointing <?=$memoColor[$memo]?> basic label"><?=$text?></div></td>
	<td>
		<div class="ui form">
		<textarea rows="3" id="<?=$memo?>" style="resize: none"><?=$row_issue[$memo]?></textarea>
		<textarea style="display: none" class="<?=$memo?>"><?=$row_issue[$memo]?></textarea>
		</div>
	</td>
	<? if($text == $memoList["detail_memo"]) {?>
	<td rowspan="4" align="center">
		<div class="ui tiny buttons">
		  <button class="ui inverted blue button" onclick="memoUpdate(<?=$_REQUEST[seq]?>)">수정</button>
		</div>
	</td>
	<? } ?>
</tr>
<? } ?>
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
	<button class="ui button inverted red" style="float:right" id="closeBtn" onclick="closeWin();">
	  <i class="times icon"></i>
	  닫기
	</button>
	<div class='ui blue empty circular label'></div>수정&nbsp;&nbsp;
	<div class='ui green empty circular label'></div>완료&nbsp;&nbsp;
	<div class='ui yellow empty circular label'></div>진행중&nbsp;&nbsp;
	<div class='ui red empty circular label'></div>미완료&nbsp;&nbsp;
	<div class='ui violet empty circular label'></div>보류&nbsp;&nbsp;
</div>
<br/>
<table id="datatables" data-order="[]" class="ui table center aligned small">
	<colgroup>
		<col width="10%">
		<col width="10%">
		<col width="7%">
		<col width="43%">
		<col width="15%">
		<col width="15%">
	</colgroup>
	<thead>
		<tr>
			<th class="no-search no-sort" style="background-color:#a333c8">
				<i class="large tasks icon" style="color:white!important"></i>
			</th>
			<th class="no-search">No</th>
			<th class="no-search">구분</th>
			<th class="no-sort">수정내용</th>
			<th>수정자</th>
			<th class="no-search">수정시간</th>
		</tr>
	</thead>
	<tbody>
	<? if($cnt == 0 ) { ?>
		<tr><td colspan="6" align="center">내용이 없습니다.</td></tr>		
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
				<td>
					<span style="display:none"><?=$row[gubunColor]?></span>
					<div class="ui <?=$row[gubunColor]?> empty circular label"></div>
				</td>		
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
	$("textarea,input").prop("spellcheck",false); 
	<? if($cnt > 0) { ?>
		fn_table("#datatables");
	<? } ?>
	$("body").keydown(function(e){
		var key = e.keyCode || e.which;
		if(key == 27) {
			closeWin();
		}
	});
});
function closeWin(){
	self.close();
	$(opener.document).find(".openRecord").blur();
}
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
function memoUpdate(seq) {
	var dMemo = $("#detail_memo").val();
	var oMemo = $("#order_memo").val();
	var seq = "<?=$_REQUEST[seq]?>";
	var param = {table : "issue_list", id : ["seq"]};
	param["param"] = {"seq" : seq, 
					"detail_memo" : dMemo, 
					"order_memo" : oMemo, 
					"cause_memo" : $("#cause_memo").val(), 
					"result_memo" : $("#result_memo").val()
					};
	ajax(param,"/common/simple_update.php",function(result) {
		var str = ""; 
		var chkDif = $(".detail_memo").val() == dMemo ? true : false;
		str += (!chkDif) ? "[업무상세] " + emp($(".detail_memo").val()) + " ▶ " + emp(dMemo)+"<br/>" : "";
		chkDif = $(".order_memo").val() == oMemo ? true : false;
		str += (!chkDif) ? "[요청 및 지시사항] " + emp($(".order_memo").val()) + " ▶ " + emp(oMemo) : "";
		if(str != "") {
			var insert = {};
			insert["param"] = { "refseq" : seq , "gubunColor" : "blue", "memo" : str};
			insert["table"] = "issue_history";
			ajax(insert,"/sub/historyInsert.php",function(){ alert("수정되었습니다.");location.reload();});
		} else {
			alert("수정되었습니다.");
			location.reload();
		}
	});
}
function emp(val) {
	var result = (val=="") ? "없음" : val;
	return result;
}
</script>
</html>