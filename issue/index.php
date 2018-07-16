<?
session_start();

include $_SERVER["DOCUMENT_ROOT"]."/common/header.php";
$sdate = ($_REQUEST[sdate]!="") ? $_REQUEST[sdate] : date("Y-m-01");
$edate = ($_REQUEST[edate]!="") ? $_REQUEST[edate] : date("Y-m-t",strtotime($sdate));
$_POST[state] = ($_POST[state]!="")? $fn->param_to_array2($_POST[state]) : $fn->param_to_array2("전체_blue");

if($_REQUEST[nAll] != "") {
	$_POST[state] = $fn->param_to_array2("미완료_red");
}
$link = $fn->auto_link("cs_seq","sdate","edate");
?>
<style>
#issue_info {
	position: absolute;
	 width: 480px;
	 height: 700px;
	 left: 50%;
	 top: 50%;
	 margin-left: -250px;
	 margin-top: -350px;
	 border: solid #a333c8 2px;
	 border-radius: 25px;
	 padding : 1rem;
}
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
	    <? $filter = array("전체"=>"blue","완료"=>"green","미완료"=>"red","보류"=>"violet");
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
		      <input type="text" value="<?=$sdate?>" name="sdate" id="sdate">
		    </div>
		  </div>
	    </div>
	    <?=$fn->add_nbsp(2)?>~<?=$fn->add_nbsp(2)?>
	    <div class="field">
	      <div class="ui calendar datepicker">
		    <div class="ui input left icon">
		      <i class="calendar alternate outline icon"></i>
		      <input type="text" value="<?=$edate?>" name="edate" id="edate">
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
		$where .= " and state = 'N' ";
	}
	
	$que = "select * from issue_list where 1=1 and (regdate between '$sdate' and '$edate') $where order by state asc,regdate desc,cs_name asc ";
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
			<col width="25%">
			<col width="8%">
			<col width="8%">
			<col width="6%">
			<col width="6%">
			<col width="8%">
			<col width="12%">
			<col width="8%">
		</colgroup>
		<thead>
			<tr align="center" > 
				<th class="no-search no-sort" style="background-color:#a333c8;">
					<i class="large briefcase icon" style="color:white!important"></i>
				</th>
				<th class="no-search">No.</th>
				<th>업체명<br/>(요청자)</th>
			    <th class="no-sort">업무명</th>
			    <th class="no-search">등록일</th>
			    <th class="no-search">마감예정일</th>
			    <th>지시자</th>
			    <th>담당자</th>
			    <th class="no-search">완료일</th>
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
			  	$setColor = "green";
			  	$setText = "완료";
			  	$font = "";
			  	$dDayView = $issue[end_date];
			  	$setIcon = "flag";
			  	if($issue[state]=="N") {
			  		$dDayResult = dDay($dday);
			  		$setColor = "red";
			  		$setText = "미완료";
			  		$setIcon = "times";
			  		if($dday > 0) { // 미완료 중 날짜 지난업무 
			  			$font = "font_red"; // D-day font color red = > background로
			  		}
			  		$dDayView = $issue[end_date]."<br/>".$dDayResult;
			  	} else if($issue[state] == "Z") {
			  		$setColor = "violet";
			  		$setText = "보류";
			  		$setIcon = "pause";
			  	}
			  	$stateList = stateView($setText);
	  ?>
			<tr align="center" class="<?=$font?> tr_hover">
				<td style="background:#f9fafb!important">
				<div class="ui toggle checkbox" style="width:50px">
			      <input type="checkbox" id="chk" value="<?=$issue[seq]?>"/>
			      <label></label>
			    </div>
				</td>
				<td><font color="<?=$setColor?>"><b><?=$i?></b></font></td>
				<td><?=$issue[cs_name]?><?=unSetView($issue[cs_person])?></td>
				<td style="text-align:left"><a href="javascript:editIssue('<?=$issue[seq]?>')"><?=$issue[memo]?></a></td>
				<td><?=$issue[regdate]?></td>
				<td><?=$dDayView?></td>
			  	<td><?=$order?></td>
			  	<td><?=$name?></td>
			  	<td><?=$fn->d($issue[finish_date]);?></td>
			  	<td>
			  		<div class="ui floating labeled icon dropdown inverted <?=$setColor?> button stateDiv">
					  <i class="<?=$setIcon?> icon"></i>
					  <span class="text"><?=$setText?></span>
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
					  <button class="ui inverted blue button" onclick="openWin('<?=$issue[seq]?>')">보기</button>
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
	<br/><br/><br/>
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
		sortElements($(this),num,"regdate","cs_name","end_date","cloneCnt","csCnt","csPerson","userName","userView");
		$("#cloneCnt" + num).text(num);
	});
});

function stateModify(value) {
	var arr = value.split("_");
	var before = arr[0];
	var after = arr[1];
	var seq = arr[2];
	
	if(before == after) {
		return;
	} else {
		var param = {};
		var text = "",color = "";
		param["param"] = {"state" : after, "seq" : seq};
		param["param"].finish_date = (after == "Y") ? "<?=date('Y-m-d')?>" : "0000-00-00"; //실제 완료일 
		param["table"] = "issue_list";
		param["id"] = ["seq"];
		ajax(param,"/common/simple_update.php",function(result){
			var text,color,memo,userName,regdate,gubunColor;

			userName = "<?=$_SESSION["USER_NAME"]?>";
			regdate = "<?=date("Y-m-d H:i:s")?>";
			if(after == "Y") {
				text = "완료처리 되었습니다.";	color = "#21ba45"; memo = "완료처리", gubunColor = "green";
			} else if(after =="Z"){
				text = "보류처리 되었습니다."; color = "#6435c9"; memo = "보류처리", gubunColor = "violet";
			} else {
				text = "미완료처리 되었습니다."; color = "#db2828"; memo = "미완료처리", gubunColor = "red";
			}
			
			/* history */
			var history = {};
			history["table"] = "issue_history";
			history["param"] = { "memo" : memo, 
								"refseq" : seq, 
								"user_name" : userName, 
								"regdate" : regdate,
								"gubunColor" : gubunColor};
			ajax(history,"/common/simple_insert.php");
			
			snackbar("issueSnackbar",color,text);
			popupHide();
		})
	}
}

function userSelect(id,val) {
	// id_format userName + (num)
	var idCut = id.substr(8);
	if(val != "unset") {
		var param = {};
		param["table"] = "member";
		param["where"] = " and user_id = '"+val+"' ";
		ajax(param,"/common/simple_select.php",function(result){
			$("#userView" + idCut).html(result[0].user_name);
		});
		return;
	}
	$("#userView" + idCut).html("");
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

	sortElements(cl,(num+1),"cloneCnt","csCnt","csPerson","userName","userView","cs_name");
	
	cl.find(".selectDiv").addClass("error");
	cl.find("select[id*=csPerson]").html("<option value='unset'>업체 미선택</option>");

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
		/* 사원 불러오기 */
		var param = {};
		param["table"] = "employee_list";
		param["where"] = " and refseq = '" + refseq + "' order by name";
		ajax(param,"/common/simple_select.php",function(result){ makeSelect(id,result) });

		/* 업체명 리스트에서 사용하려고 .. */
		var csName = {};
		csName["table"] = "erp_ocsinfo";
		csName["where"] = " and seq = " + refseq;
		ajax(csName
			,"/common/simple_select.php"
			,function(result){
			$("#cs_name" + i +"").val(result[0].cs_name);
		});
		
	} else {
		$("#csPerson" + i +"").html("<option value=''>업체미선택</option>");
		$("#csPerson" + i +"").closest(".selectDiv").addClass("error");
		$("#cs_name" + i +"").val("");
	}
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
				if(name=="refseq" && value == "unset") {
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
		ajax(obj, "issue_add_ok.php",function (result) { alert(result);	location.reload();	});
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
	param["param"] = jsonBot("issue_modify",["cs_name"]);
	param["table"] = "issue_list";
	param["id"] = ["seq"];
	param["mode"] = "modify"; 
	ajax(param, "issue_add_ok.php",function(result){ snackbar("issueSnackbar","#54c8ff",result); popupHide(); });
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
	/* 요청자 셋팅 */
	var param = {};
	param["table"] = "employee_list";
	param["where"] = " and refseq = '" + data.refseq + "' order by name";
	ajax(param,"/common/simple_select.php",function(val){
		 var option = "";
		 var select = form.find($("select[name='cs_person']"));
		 if(val) {
		 max = val.length;
			option = "<option value='unset'>선택하세요</option>";
			 for (var i = 0; i < max; i++) {
				 var selected = (val[i].name == data.cs_person) ? "selected" : "";
				 option += "<option value='"+val[i].name+"' "+selected+">"+val[i].name+"</option>";
			}
		 } else {
			 option = "<option value='unset'>사원등록수 : 0</option>";
			 select.closest("div").addClass("error");
		}
		 select.html(option);
	});
	/* == 요청자 셋팅 == */
}
function makeSelect(id,result) {
	 var id = id.substr(5); 
	 var csPerson = $("#csPerson" + id +"");
	 if(result) {
		 var option = "<option value='unset'>선택하세요</option>";
		 max = result.length;
		 for (var i = 0; i < max; i++) {
			 option += "<option value='"+result[i].name+"'>"+result[i].name+"</option>";
		}
		 csPerson.html(option);
		 csPerson.closest(".selectDiv").removeClass("error");
	 } else {
		 csPerson.html("<option value='unset'>사원등록 수 : 0</option>");
		 csPerson.closest(".selectDiv").addClass("error");
	}
}
/* == CALLBACK ==*/
</script>
</html>
<?
function dDay($dday) {
	if($dday >0) {
		return "<font color='red'><strong>(D+" .$dday . ")</strong></font>";
	} else if($dday < 0) {
		return "<font color='green'><strong>(D" .$dday . ")</strong></font>";
	} else {
		return "<font color='red'>오늘 마감</font>";
	}
}
function unSetView($val) {
	if($val == "unset"||$val == "") {
		return "";
	} else {
		return "<br/>(".$val.")";
	}
}
function stateView($text) {
	$stateList = array("완료"=>"green|Y","미완료"=>"red|N","보류"=>"violet|Z");
  	unset($stateList[$text]);
  	return $stateList;
}
?> 