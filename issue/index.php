<?
session_start();

include $_SERVER["DOCUMENT_ROOT"]."/common/header.php";
include $_SERVER["DOCUMENT_ROOT"]."/lib/fn_index.php";

$sdate = ($_REQUEST[sdate]!="") ? $_REQUEST[sdate] : date("Y-m-01",strtotime("-2 months",strtotime(date("Y-m-d"))));
$edate = ($_REQUEST[edate]!="") ? $_REQUEST[edate] : date("Y-m-t");
$_POST[state] = ($_POST[state]!="")? $fn->param_to_array2($_POST[state]) : $fn->param_to_array2("전체_grey");

if($_REQUEST[nAll] != "") {
	$_POST[state] = $fn->param_to_array2(getState($_REQUEST[nAll]));
}

?>
<style>
#issueSnackbar {
    visibility: hidden;
    min-width: 250px;
    margin-left: -125px;
    background-color: #333;
    color: #fff;
    text-align: center;
    border-radius: 2px;
    padding: 16px;
    position: fixed;
    z-index: 1;
    left: 50%;
    top: 30px;
    font-size: 17px;
}
#issueSnackbar.show {
    visibility: visible;
    -webkit-animation: fadein 0.5s, fadeout 0.5s 2.5s;
    animation: fadein 0.5s, fadeout 0.5s 2.5s;
}

@-webkit-keyframes fadein {
    from {top: 0; opacity: 0;} 
    to {top: 30px; opacity: 1;}
}

@keyframes fadein {
    from {top: 0; opacity: 0;} 
    to {top: 30px; opacity: 1;}
}

@-webkit-keyframes fadeout {
    from {top: 0; opacity: 0;} 
    to {top: 30px; opacity: 1;}
}

@keyframes fadeout {
    from {top: 0; opacity: 0;} 
    to {top: 30px; opacity: 1;}
}
.comment {
	display : none;
}
.font_red {
	background-color : #FBEFEF !important;
}
</style>
<body>
<div class="ui container side">
<? include $_SERVER["DOCUMENT_ROOT"]."/common/company_list.php"; ?>
</div>
<!-- 메인 테이블  -->
<div class="ui container table purple segment">
	<h2 class="ui header" style="margin-top: 0px">
	
	<i class="circular purple briefcase icon "></i>
	<div class="content">업무현황<?$fn->add_nbsp(2)?>
		<button class="ui basic blue button" id="addRow">
		  <i class="icon plus square"></i>
		  업무 추가하기
		</button>
	</div>
	</h2>
	<!-- 업무입력창 -->
		<div id="cloneTarget" class="ui segment clone" style="display: none"></div>
		<div class="ui bottom attached button primary clone" style="display: none" onclick="addRow(1)">한 줄 추가하기</div>
		<div class="ui bottom attached button positive clone" style="display: none;margin-bottom:30px" onclick="saveIssue()">저장</div>
	<!-- 업무입력창 -->
	
	<div class="ui left aligned">
		<? $cs_list = $fn->cs_list();
		$cs_list_cnt = count($cs_list);
		?>
	<form name="form" method="POST" style="margin:0px;float:left;">
	<input type="hidden" value="1" name="page"/>
	<input type="hidden" value="" name="nAll"/>
	<!-- 필터 검색 -->
	<div id="state_search" class="ui floating labeled icon dropdown button basic" onchange="fn_submit(document.form)">
	  <input type="hidden" name="state" value="<?=$_POST[state][0]."_".$_POST[state][1]?>">
	  <i class="filter purple icon"></i>
	  
	  <span class="text"> 
	  <div class="ui <?=$_POST[state][1]?> empty circular label"></div><?=$_POST[state][0]?>
	  </span>
	  
	  <div class="menu">
	    <div class="header">
	      <i class="tags icon"></i>
	      Filter by tag
	    </div>
	    <div class="divider"></div>
	    <? $filter = array("전체"=>"grey","완료"=>"green","진행중"=>"blue","미완료"=>"red","보류"=>"violet");
		    foreach ($filter as $key=>$value){?>
			    <div class="item" data-value="<?=$key?>_<?=$value?>">
			    <div class="ui <?=$value?> empty circular label"></div><?=$key?></div>
		    <? } ?>
	  </div>
	</div>
	<?=$fn->add_nbsp(3)?>
	<!-- /필터검색 -->
	<i class="search icon purple"></i>업체 : <?=$fn->add_nbsp(3)?>
	<select id="cs_seq" name="cs_seq" class="ui search dropdown" onchange="fn_submit(document.form)" style="width: 200px">
		<option value="unset">선택하세요</option>
		<?
			for($i = 0; $i < $cs_list_cnt; $i++) { 
				if($_REQUEST[cs_seq]==$cs_list[$i][seq]) {
					$selected = "selected";
				} else {
					$selected = "";
				}
			?>
				<option value="<?=$cs_list[$i][seq]?>" <?=$selected?>><?=$cs_list[$i][title]?></option>	
		<? } ?>
	</select>
	<?=$fn->add_nbsp(3)?>
	<i class="user icon purple"></i>담당자 : <?=$fn->add_nbsp(3)?>
	<select id="user_id" name="user_id" class="ui search dropdown" onchange="fn_submit(document.form)" style="width: 200px">
		<option value="unset">선택하세요</option>
		<?
			$u = $fn->allowUser();
			$u_max = count($u);
			for($i = 0; $i < $u_max; $i++) { 
				$selected = ($_REQUEST[user_id]==$u[$i][user_id]) ? "selected" : "";
			?>
				<option value="<?=$u[$i][user_id]?>" <?=$selected?>><?=$u[$i][user_name]?></option>	
		<? } ?>
	</select>
	<?=$fn->add_nbsp(3)?>
	<!-- 일정검색 -->
	<i class="calendar alternate outline icon purple"></i>일정 : <?=$fn->add_nbsp(3)?>
	<div class="ui form"style="float: right">
	  <div class="fields">
	    <div class="field">
	       <div class="ui calendar datepicker">
		    <div class="ui input left icon">
		      <i class="calendar alternate outline icon"></i>
		      <input type="text" value="<?=$sdate?>" name="sdate" id="sdate" autocomplete="off">
		    </div>
		  </div>
	    </div>
	    <?=$fn->add_nbsp(2)?>~<?=$fn->add_nbsp(2)?>
	    <div class="field">
	      <div class="ui calendar datepicker">
		    <div class="ui input left icon">
		      <i class="calendar alternate outline icon"></i>
		      <input type="text" value="<?=$edate?>" name="edate" id="edate" autocomplete="off">
		    </div>
		  </div>
		</div>
	    </div>
	  </div>
	  <!-- /일정검색 -->
	</div>
	</form>
	<br/><br/><br/>
	<? 
	$where = "";
	if($_REQUEST[cs_seq]!="" && $_REQUEST[cs_seq]!="unset") {
		$where .= " and refseq = '$_REQUEST[cs_seq]' ";
	}
	if($_REQUEST[user_id]!="" && $_REQUEST[user_id]!="unset") {
		$where .= " and user_name = '$_REQUEST[user_id]' ";
	}
	
	if($_POST[state][0] == "완료") {
		$where .= " and state = 'Y' ";
	} else if($_POST[state][0] == "보류") {
		$where .= " and state = 'Z' ";
	} else if($_POST[state][0] == "미완료" || $_REQUEST[nAll]!=""){
		$where .= " and (state = 'N' or state = 'G') ";
	}	else if($_POST[state][0] == "진행중"){
		$where .= " and state = 'G' ";
	}
	
	$que = "select * from issue_list where 1=1 and (end_date between '$sdate' and '$edate') $where order by state asc,regdate desc,cs_name asc ";
	$res = mysql_query($que) or die(mysql_error());
	$cnt = mysql_num_rows($res);
	
	if($cnt > 0) { ?>
	<div class="ui left aligned">
		<button class="ui button inverted purple checkall">
		  <i class="check circle icon"></i>
		  전체선택
		</button>
		<input type="checkbox" id="checkall" style="display:none;"/>
		<button class="ui button inverted red" onclick="delete_issue()">
		  <i class="check trash alternate icon"></i>
		  선택삭제
		</button>
	</div>
	<br/>
	<table id="datatables" data-order="[]" class="ui definition table center aligned small">
		<colgroup>
			<col width="5%">
			<col width="5%">
			<col width="10%">
			<col width="24%">
			<col width="8%">
			<col width="8%">
			<col width="6%">
			<col width="6%">
			<col width="8%">
			<col width="12%">
			<col width="9%">
		</colgroup>
		<thead>
			<tr align="center" > 
				<th class="no-search no-sort" style="background-color:#a333c8;">
					<i class="large briefcase icon" style="color:white!important"></i>
				</th>
				<th class="no-search">No.</th>
				<th>업체명<br/>(요청자)</th>
			    <th class="no-sort">업무명</th>
			    <th>등록일</th>
			    <th>마감예정일</th>
			    <th>지시자</th>
			    <th>담당자</th>
			    <th>완료일</th>
			    <th class="no-sort no-search">상태변경</th>
			    <th class="no-sort no-search"><i class="large edit icon"></i>업무기록</th>
			</tr>
		</thead>
		<tbody>
			 <?
			 $i = 1;
			 while($issue = mysql_fetch_array($res)){
			  	
			  	$name = ($issue[user_name] !="") ? $fn->getName($issue[user_name]) : "";
			  	$order = ($issue[order_name] !="") ? $fn->getName($issue[order_name]) : "";
			  	
			  	/*D-day 구하기 */
			  	$today = strtotime(date("Y-m-d"));
			  	$end_date = strtotime(date($issue[end_date]));
			  	$dday = intval(($today - $end_date) / 86400);
			  	/*D-day 구하기*/
			  	$over = ($issue[state]=="N" || $issue[state] == "G") ? true : false; 
			  	$font = ($over == true && $dday > 0) ? "font_red" : "";
			  	$dDayView = ($over==true) ? $issue[end_date]."<br/>".dDay($dday) : $issue[end_date];
			  	
			  	$vObj = getView($issue[state]); # / lib/fn_index.php;
			  	
			  	$stateList = stateView($vObj->text);
	  ?>
			<tr align="center" class="<?=$font?> tr_hover">
				<td style="background:#f9fafb!important">
				<div class="ui toggle checkbox" style="width:50px">
			      <input type="checkbox" id="chk" value="<?=$issue[seq]?>"/>
			      <label></label>
			    </div>
				</td>
				<td><font color="<?=$vObj->color?>"><b><?=$i?></b></font></td>
				<td><a onclick="editIssue('<?=$issue[seq]?>')" style='cursor: pointer'><?=getCsName($issue[refseq])?><?=unSetView($issue[cs_person])?></a></td>
				<td style="text-align:left"><a onclick="editIssue('<?=$issue[seq]?>')" style='cursor: pointer'><?=$issue[memo]?></a></td>
				<td><?=$issue[regdate]?></td>
				<td><?=$dDayView?></td>
			  	<td><?=$order?></td>
			  	<td><?=$name?></td>
			  	<td><?=$fn->d($issue[finish_date]);?></td>
			  	<td>
			  		<div class="ui floating labeled icon dropdown inverted <?=$vObj->color?> button stateDiv">
					  <i class="<?=$vObj->icon?> icon"></i>
					  <span class="text"><?=$vObj->text?></span>
					  <div class="menu">
					    <div class="header">
					      <i class="sync icon"></i>
					      상태변경
					    </div>
					    <? foreach ($stateList as $key=>$value) {
					    	$val = explode("|",$value);
					    	$parseVal = $issue[state]."_".$val[1]."_".$issue[seq]; 
					    ?>
						    <div class="item" data-value='<?=$parseVal?>'>
						    <div class="ui <?=$val[0]?> empty circular label"></div><?=$key?></div>
					    <? } ?>
					    </div>
					</div>
			  	</td>
			  	<td>
				  	<div class="ui tiny buttons">
					  <button class="ui inverted brown button openRecord" onclick="openWin('<?=$issue[seq]?>')">보기</button>
					</div>
			  	</td>
			</tr>
		<? $i++;} ?>
		</tbody>
	</table>
	<? } else {?>
	<h2 class="ui icon header center aligned">
		  <i class="ban red icon"></i>
		  <div class="content">
		    검색결과 없음!
		    <div class="sub header">검색 조건을 확인 해주세요</div>
		  </div>
		</h2> 
	<? } ?>
	<br/>
	</div>
<!-- clone + 팝업 elements -->
<? include_once $_SERVER["DOCUMENT_ROOT"].'/sub/index_sub.php';?>
<!-- // -->
<div id="issueSnackbar"></div>
</body>
<script>
$(document).ready(function(){
	$("#state_search").dropdown(); //필터검색
	$(".stateDiv").dropdown({
		action : 'hide',
		onChange : stateModify
	});
	
	dropDown("#cs_seq,#user_id"); //select 검색
	hoverMaster("tr_hover","positive");
	<? if($cnt > 0) { ?>
		fn_table("#datatables");
	<? } ?>
});

$(document).on("click","#addRow,.addrow",function(e){
	e.preventDefault();
	addRow();
});
$(document).on("click",".copyRow",function(e){
	e.preventDefault();
	$(this).blur();
	
	var ele = $(this).closest("div[id*=cloneContent]"); //copy target
	var cnt = ele.attr("id").substr(12)*1; // copy cnt 
	var num = $("div[id*='cloneContent']:visible").length; // last div
	var next = "cloneContent" + (num+1); // next id
	var id = "#"+ele.attr("id"); // copy id 
	
	var cl = $(id).clone(); // copy start
	cl.prop("id", next ).attr("data-idx",(num+1)); //id,index값 +1 바꾸고
	sortElements(cl,(num+1),"cloneCnt","csCnt","csPerson","userName","orderName","userView","orderView","cs_name","line","regdate","end_date");

	cl.insertAfter("#cloneContent"+num);// copy end
	
	/* selects */
	var userName = $("#userName"+cnt).val();
	var orderName = $("#orderName"+cnt).val();
	var csCnt = $("#csCnt"+cnt).val();
	$("#userName"+(num+1)).val(userName);
	$("#orderName"+(num+1)).val(orderName);
	$("#csCnt"+(num+1)).val(csCnt);
	/* selects */
	calendar(cl.find(".date")); //달력 
	$("#cloneCnt" + (num+1)).text((num+1));
	$("#" + next).css("display","");
});

$(document).on("click",".removeRow",function(e){
	e.preventDefault();
	var sort = "div[id*='cloneContent']:visible";
	$(this).closest(sort).remove(); // this는 버튼
	
	if($(sort).length==0) {
		$(".clone").css("display","none");
		return;
	}
	$(sort).each(function(i){
		var num = i+1;
		$(this).prop("id","cloneContent"+num);
		$(this).attr("data-idx",num);
		sortElements($(this),num,"regdate","cs_name","end_date","cloneCnt","csCnt","csPerson","userName","orderName","userView","orderView","line");
		$("#cloneCnt" + num).text(num);
	});
});

function stateModify(value) {
	var arr = value.split("_");
	var after = arr[1];
	var seq = arr[2];
	var modal = $("#completeModal");
	if(after == "Y") {
		$("#completeModal").modal({
			onShow : function(){
				var init = {};
				init["table"] = "issue_list";
				init["where"] = " and seq = '"+seq+"' ";
				ajax(init, "/common/simple_select.php",function(result){
					var data = result[0];
					modal.find("#modalTitle").html("["+data.cs_name+"]<br/>"+data.memo);
					for(key in data) {
						modal.find("#modal_"+key).val(data[key]);
					}
				});				
			},
			onApprove : function() {
				var param = {};
				var seq = modal.find("#modal_seq").val();
				var cause_memo = modal.find("#modal_cause_memo").val();  
				var result_memo = modal.find("#modal_result_memo").val(); 
				param["param"] = {
									"state" : after, 
									"seq" : seq, 
									"finish_date" : "<?=date('Y-m-d')?>",
									"cause_memo" : cause_memo,
									"result_memo" : result_memo,
									};
				fn_state(param,after,seq);
			}
		}).modal('show');
	} else {
		var param = {};
		param["param"] = { "state" : after, "seq" : seq, "finish_date" : "0000-00-00"}
		fn_state(param,after,seq);	
	}
}

function fn_state(param,after,seq) {
	var text = "",color = "";
	param["table"] = "issue_list";
	param["id"] = ["seq"];
	ajax(param,"/common/simple_update.php",function(result){
		var text,color,memo,gubunColor;

		if(after == "Y") {
			text = "완료처리 되었습니다.";	color = "#21ba45"; memo = "완료 처리", gubunColor = "green";
		} else if(after =="Z"){
			text = "보류처리 되었습니다."; color = "#6435c9"; memo = "보류 처리", gubunColor = "violet";
		} else if(after =="G"){
			text = "진행업무처리 되었습니다."; color = "#2185d0"; memo = "진행업무 처리", gubunColor = "yellow";
		} else {
			text = "미완료처리 되었습니다."; color = "#db2828"; memo = "미완료 처리", gubunColor = "red";
		}
		
		/* history */
		var history = {};
		history["table"] = "issue_history";
		history["param"] = { "memo" : memo, 
							"refseq" : seq, 
							"gubunColor" : gubunColor};
		ajax(history,"/sub/historyInsert.php");
		
		snackbar("issueSnackbar",color,text);
		popupHide();
	});
}
function userSelect(id,val) {
	var type = (id.indexOf("user") !== -1) ? "userView" : "orderView"; 
	var num = (type=="userView") ? 8 : 9;
	var idCut = id.substr(num);
	if(val != "") {
		var param = {};
		param["table"] = "member";
		param["where"] = " and user_id = '"+val+"' ";
		ajax(param,"/common/simple_select.php",function(result){
			$("#"+ type + idCut).html(result[0].user_name);
		});
		return;
	}
	$("#"+ type + idCut).html("");
}
function sortElements() {
	var max = arguments.length;
	var ele = arguments[0];
	var num = arguments[1];

	for(var i = 2; i < max; i++) {
		ele.find("[id*="+arguments[i]+"]").prop("id",arguments[i]+""+num);
	}
}
function addRow(addOne) {
	var num = $("div[id*='cloneContent']:visible").length;
	if(addOne) {
		makeDiv(num);
	} else {
		var popup = prompt("추가할 업무수를 입력하세요\n* 10이하 숫자만 입력할 수 있습니다.","1");
		if(popup != null && popup.trim()!=0 && isNaN(popup)===false && popup.trim() <= 10) {
			for(var i = num; i < num+(popup*1); i++) {
				makeDiv(i);
			}
			$(".clone").css("display","");
		} else if(popup ==null) {
			return;
		} else {
			alert("잘못된 값 또는 입력제한을 초과하였습니다. 다시 입력해주세요!");
			$(this).blur();
		}
	}
}
function makeDiv(num) {
	var next = "cloneContent"+(num+1);
	var id = "#cloneContent" + num;
	var cl = $(id).clone();
	cl.prop("id", next ).attr("data-idx",(num+1)); //id,index값 +1 바꾸고
	cl.find("input:visible,textarea").val("");
	cl.find("[id*=userView]").html("");
	cl.find("[id*=orderView]").html("<?=$_SESSION[USER_NAME]?>");
	cl.find("[id*=csPerson]").val("");
	sortElements(cl,(num+1),"cloneCnt","csCnt","csPerson","userName","orderName","userView","orderView","cs_name","line");
	
	/*datepicker*/
	cl.find("input[id*='regdate']").prop("id","regdate"+(num+1)).val("<?=date("Y-m-d")?>");
	cl.find("input[id*='end_date']").prop("id","end_date"+(num+1)).val("<?=date("Y-m-d")?>");
	
	if(num!=0) {
		cl.insertAfter(id);
	} else {
		cl.appendTo("#cloneTarget"); //처음
	}
	calendar(cl.find(".date")); //달력 
	$("#cloneCnt" + (num+1)).text((num+1));
	$("#" + next + "").css("display","");
}
function loadEmployee(id,refseq) {
	var i = id.substr(5);
	if(refseq != "unset") {
		/* 업체명 리스트에서 사용하려고 .. */
		var csName = {};
		csName["table"] = "erp_ocsinfo";
		csName["where"] = " and seq = " + refseq;
		ajax(csName
			,"/common/simple_select.php"
			,function(result){
			$("#cs_name" + i).val(result[0].cs_name);
			$("#csPerson" + i).focus();
		});
		
	} else {
		return;
	}
}
function setCsName(val) { //팝업에서 업체변경시 
	var param = {};
	param["table"] = "erp_ocsinfo";
	param["where"] = " and seq = '"+val+"' ";
	ajax(param,"/common/simple_select.php",function(result){
		var frm = $("form[name='issue_modify']");
		frm.find("[name='cs_name']").val(result[0].cs_name);
	});
}
function saveIssue(){
	var param = {};
	var out = true;
	$("div[id*='cloneContent']:visible").each(function(i,e){
		var save = {};
		var id = $(this).attr("id");
		
		$("#" + id).find("input,select,textarea").each(function(i,e){
				var name = $(this).attr("name");
				var value = $(this).val();
				if(name=="refseq" && value == "") {
					alert("업체 선택은 필수항목 입니다.");
					$(this).focus();
					out = false;
				}
				save[name] = value;
		});
		if(out== true) {	
			param[i] = save;
		} else {
			return out;
		}
	});
	if(out == true) { 
		var obj = {};
		obj["issue"] = param;
		obj["mode"] = "insert";
		ajax(obj, "issue_add_ok.php",function (result) { alert(result);	location.href='/'; });
	}
}

function editIssue(seq,mode) {
	$('#issue_modify').modal({
		onShow : function() {
			var param = {};
			param["table"] = "issue_list";
			param["where"] = " and seq = " + seq;
			ajax(param,"/common/simple_select.php",selectIssue);
		}
		,onDeny : popupDeny
		,onApprove : modifyIssue // 수정
		, onHide : popupDeny
		}).modal('show');
}

function fn_submit(frm) {
	frm.submit();
}

function modifyIssue() {
	var param = {};
	param["param"] = jsonBot("issue_modify");
	param["table"] = "issue_list";
	param["id"] = ["seq"];
	param["mode"] = "modify"; 
	ajax(param, "issue_add_ok.php",function(result){ 
		snackbar("issueSnackbar","#54c8ff",result); popupHide();
	});
}

function delete_issue() {
	var c = $("#chk:checked");
	if(c.length==0) {
		alert("삭제 대상이 없습니다.");
		return;
	}
	var param = {};
	if(confirm("삭제한 업무는 복구할 수 없습니다.\n총 "+c.length+"건 삭제하시겠습니까?")==true) {
		multiDelete(["issue_list*seq","issue_history*refseq"]);
	} else {
		return;
	}
}
function openWin(seq) {
	var url = "/sub/issue_history.php?seq="+seq;
	var width=900;
    var height=900;
	var posx = 0
	var posy = 0
	posx = (screen.width - width)/2-1;
	posy = (screen.height - height)/2-1;
	newwin = window.open(url,"search","width="+width+",height="+height+",toolbar=0,scrollbars=1,resizable=0,status=0");
	newwin.moveTo(posx,posy);
	newwin.focus();
}

/* CALLBACK*/ 
function selectIssue(result){
	var data = result[0];
	
	var form = $("form[name='issue_modify']");
	
	for(var key in data) {
		$("[name='"+key+"']").val(data[key]);
	}
	calendar(form.find(".date"));
	
}
/* == CALLBACK ==*/
</script>
</html>
