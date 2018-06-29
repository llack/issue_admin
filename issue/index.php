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
	 height: 600px;
	 left: 50%;
	 top: 50%;
	 margin-left: -250px;
	 margin-top: -300px;
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
	background-color : #FBEFEF;
}
</style>
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
	    <div class="item" data-value="전체_blue">
	      <div class="ui blue empty circular label"></div>
		전체
	    </div>
	    <div class="item" data-value="완료_green">
	      <div class="ui green empty circular label"></div>
		완료
	    </div>
	    <div class="item" data-value="미완료_red">
	      <div class="ui red empty circular label"></div>
		미완료
	    </div>
	  </div>
	</div>
	<?=$fn->add_nbsp(3)?>
	<!-- /필터검색 -->
	<i class="search icon purple"></i>업체 검색 : <?=$fn->add_nbsp(3)?>
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
	<i class="user icon purple"></i>담당자 검색 : <?=$fn->add_nbsp(3)?>
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
	<i class="calendar alternate outline icon purple"></i>일정 검색 : <?=$fn->add_nbsp(3)?>
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
	<br/><br/><br/><br/>
	
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
	} else if($_POST[state][0] == "미완료" || $_REQUEST[nAll]!=""){
		$where .= " and state = 'N' ";
	}
	
	$que = "select * from issue_list where 1=1 and (regdate between '$sdate' and '$edate') $where order by state,regdate desc ";
	$pagenator = new Paginator($que);
	  $results = $pagenator->getData($page,$limit);
	  if($results->data) {
	  	$max = count($results->data);
	  ?>
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
	<table class="ui definition table fixed center aligned small">
	 <thead>
		  <tr style="background-color:#a333c8;" >
		    <th width="70px"><i class="large briefcase icon" style="color:white!important"></i></th>
			<th width="70px">No.</th>
			<th>업체명 / 요청자</th>
		    <th>업무내용</th>
		    <th>등록일</th>
		    <th>마감예정일</th>
		    <th>담당자</th>
		    <th>완료일</th>
		    <th>상태변경</th>
		    <th><i class="large edit icon"></i>or <i class="large ban icon"></i></th>
		  </tr>
	  </thead>
	  <tbody>
	  <? for($i = 0; $i < $max; $i++) {
	  	$issue = $results->data[$i];
	  	$name = $fn->userInfo($issue[user_name]);
	  	$name = $name[0][user_name];
	  	
	  	/*D-day 구하기 */
	  	$today = strtotime(date("Y-m-d"));
	  	$end_date = strtotime(date($issue[end_date]));
	  	$dday = intval(($today - $end_date) / 86400);
	  	
	  	$dDay = $issue[end_date];
	  	$circle = "green";
	  	$font = "";
	  	if($issue[state]=="N") {
	  		$dDay = $issue[end_date]." ".dDay($dday)."";
	  		$circle = "red";
	  		if($dday > 0) {
	  			$font = "font_red"; // D-day font color red
	  		}
	  	}// D-day HTML
	  ?>
	  <tr class="tr_hover <?=$font?>" ondblClick="comment('<?=$issue[seq]?>',this)">
	  	<td>
	  		<div class="ui toggle checkbox">
			  <input type="checkbox" id="chk" value="<?=$issue[seq]?>">
			  <label></label>
			</div>
	  	</td>
	  	<td><a class="ui <?=$circle?> circular label"><?=($i+1)?></a></td>
	  	<td><?=$issue[cs_name]?><?=unSetView($issue[cs_person])?></td>
	  	<td style="text-align:left"><?=$issue[memo]?></td>
	  	<td><?=$issue[regdate]?></td>
	  	<td>
	  		<?=$dDay?>
	  	</td>
	  	<td><?=$name?></td>
	  	<td><?=$fin_date = ($issue[finish_date] != "0000-00-00") ? $issue[finish_date] : "";?></td>
	  	<td>
	  		<?
		  		$finish = "positive";
		  		$incomplete = "inverted";
		  		if($issue[state] == "N") {
		  			$finish = "inverted";
		  			$incomplete = "negative";
		  		} 
	  		?>
	  		<div class="ui tiny buttons"><!--  -->
			  <button class="ui <?=$finish?> green button" onclick="stateModify('<?=$issue[state]?>','Y','<?=$issue[seq]?>')">완료</button>
			  <button class="ui <?=$incomplete?> red  button" onclick="stateModify('<?=$issue[state]?>','N','<?=$issue[seq]?>')">미완료</button>
			</div>
	  	</td>
	  	<td>
		  	<div class="ui tiny buttons">
			  <button class="ui inverted blue button" onclick="editOrRemove('<?=$issue[seq]?>','modify')">수정</button>
			  <div class="or"></div>
			  <button class="ui inverted red button" onclick="editOrRemove('<?=$issue[seq]?>','delete','<?=$issue[memo]?>')">삭제</button>
			</div>
	  	</td>
	  </tr>
	  <tr class="comment">
	  	<td align="center">RE : </td>
	  	<td align="left" colspan="8">
	  		<div class="ui form">
	  		<textarea style="width: 100%;padding:3px;resize:none" rows="3" id="bigo<?=$issue[seq]?>"><?=$issue[bigo]?></textarea><br/><br/>
	  		</div>
	  		<div class="ui tiny buttons">
	  			<button class="ui inverted purple button" onclick="comment_add('<?=$issue[seq]?>')">저장</button>
	  			<button class="ui inverted red button" onclick="comment('<?=$issue[seq]?>',this,'selfClose')">닫기</button>
	  		</div>
	  	</td>
	  </tr>
	  <? } ?>
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
	<!-- 페이징 -->
	<?=$pagenator->createLinks($link);?>
	<!-- 페이징 -->
	</div>
<!--  -->
<!-- clone -->
<div class="ui form" id="cloneContent0" data-idx="0" style="display:none">
	<input type="hidden" name="cs_name" id="cs_name0" value=""/>
	<div class="seven fields inline">
      <a class="ui grey circular label"><span id="cloneCnt0"></span></a><?$fn->add_nbsp(5)?>
      
      <div class="field">
        <label>업체</label><br/>
         <div class="ui fluid">
			<select name="refseq" class="fluid" id="csCnt0" onchange="loadEmployee(this.id,this.value)">
				<option value="unset">선택하세요</option>
			<?	for($i = 0; $i < $cs_list_cnt; $i++) {	
					$cs = $cs_list[$i];
				?>
				<option value="<?=$cs[seq]?>"><?=$cs[title]?></option>	
			<? } ?>
			</select>
		</div>
      </div>
      
      <div class="field selectDiv error">
        <label>요청자</label><br/>
        <div class="ui fluid">
        	<select name="cs_person" class="fluid" id="csPerson0">
        		<option value="unset">업체 미선택</option>
        	</select>
        </div>
      </div>
      
      <div class="field">
        <label>업무담당자</label><br/>
        <div class="ui fluid">
        	<select name="user_name" class="fluid">
        		<option value="unset">선택하세요</option>
        		<?
        			$user_list = $fn->allowUser();
        			$max = count($user_list);
        			for ($user = 0; $user < $max; $user++) {
        		?>
        		<option value="<?=$user_list[$user][user_id]?>"><?=$user_list[$user][user_name]?></option>
        		<? } ?>
        	</select>
        </div>
      </div>
      
      <div class="field">
      	<label>등록일</label><br/>
      	<div class="ui fluid">
	      	<div class="ui calendar date">
			    <div class="ui input left icon">
			      <i class="calendar alternate outline icon purple"></i>
			      <input type="text" value="<?=date("Y-m-d")?>" name="regdate" id="regdate0" style="width:100%">
			    </div>
			  </div>
		  </div>
      </div>
      
      <div class="field">
      	<label>마감예정일</label><br/>
      	<div class="ui fluid">
	      	<div class="ui calendar date">
			    <div class="ui input left icon">
			      <i class="calendar alternate outline icon purple"></i>
			      <input type="text" value="" name="end_date" id="end_date0" style="width:100%">
			    </div>
			  </div>
		  </div>
      </div>
      
    </div>
    <br/>
    <div class="two fields inline" style="border-bottom: 2px dotted #dc73ff">
    <div class="field center aligned">
        <label>업무내용 ▼</label><br/>
        <div class="ui">
		  <input type="text" name="memo" class="fluid">
		</div>
	</div>
	<div class="ui fluid">
        <label><?$fn->add_nbsp(1)?></label><br/>
      <button class="ui inverted red button removeRow">삭제</button>
      </div>
     </div>
</div>
<!-- clone -->	
<!--  이슈 수정 팝업 -->
<div id="issue_modify"class="ui basic modal">
  <div class="content">
  	<div id="issue_info">
	<div class="login header">
		<div style="text-align:right !important"><i class="user icon"></i>업 무 정 보 <span class="popup_title">수 정</span></div>
	</div>
	<br/><br/>
	<form class="ui fluid form" name="issue_modify">
  <div class="field">
  
  <div class="inline field error">
    <div class="ui ribbon  purple basic label">
      업체명
    </div>
    <input type="text" name="cs_name"readonly>
  </div>
  
  <div class="inline field">
    <div class="ui ribbon purple basic label">
      요청자
    </div>
    <select name="cs_person"></select>
  </div>
  
  <div class="inline field">
    <div class="ui ribbon purple basic label">
      업무내용
    </div>
   <textarea name="memo" rows="3" style="resize:none"></textarea>
  </div>
  
  <div class="inline field">
    <div class="ui ribbon purple basic label">
      등록일
    </div>
    <div class="ui calendar date">
	    <div class="ui input left icon">
	      <i class="calendar alternate outline icon purple"></i>
	      <input type="text" value="" name="regdate"/>
	    </div>
	  </div>
  </div>
  
   <div class="inline field">
    <div class="ui ribbon purple basic label">
      마감예정일
    </div>
    <div class="ui calendar date">
	    <div class="ui input left icon">
	      <i class="calendar alternate outline icon purple"></i>
	      <input type="text" value="" name="end_date"/>
	    </div>
	  </div>
  </div>
 
  <div class="inline field">
    <div class="ui ribbon purple basic label">
      담당자
    </div>
    <select name="user_name" style="width:50%">
        <option value="unset">선택하세요</option>
        	<?
        		for ($user = 0; $user < $max; $user++) {
        	?>
        	<option value="<?=$user_list[$user][user_id]?>"><?=$user_list[$user][user_name]?></option>
        	<? } ?>
   </select>
  </div>
 
</div>
  <input type="hidden" name="seq" value=""/>
</form>
  <!-- /  -->
</div>
  </div>
  <div class="actions">
    <div class="ui red basic cancel inverted button">
      <i class="remove icon"></i>
      취 소
    </div>
    <div class="ui green ok inverted button">
      <i class="checkmark icon"></i>
     <span class="popup_title">수 정</span>
    </div>
  </div>
</div>

<div id="issueSnackbar"></div>

</body>
<script>
$(document).ready(function(){
	$("#state_search").dropdown(); //필터검색
	dropDown("#cs_seq,#user_id"); //select 검색
	hoverMaster("tr_hover","positive");
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
		num = i+1;
		$(this).prop("id","cloneContent"+num);
		$(this).attr("data-idx",num);
		sortElements($(this),num,"regdate","cs_name","end_date","cloneCnt","csCnt","csPerson");
		$("#cloneCnt" + num).text(num);
	});
});
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
	var cnt = "cloneCnt" + (num+1);
	cl.prop("id", next ).attr("data-idx",(num+1)); //id,index값 +1 바꾸고
	cl.find("#cloneCnt" + num + "").prop("id",cnt);// 로우 넘버
	cl.find("input").val("");
	cl.find("input[id*='cs_name']").prop("id","cs_name" + (num+1));
	/* select Box */
	cl.find("#csCnt" + num + "").prop("id","csCnt"+(num+1));
	cl.find("#csPerson" + num + "").prop("id","csPerson"+(num+1));
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
	$("#" + cnt).text((num+1));
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
				save[name] = $(this).val();
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
		ajax(obj, "issue_add_ok.php"
			,function (result) {
			alert(result);
			location.reload();
		});
	}
}

function stateModify(before,after,seq) {
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
			if(after == "Y") {
				text = "완료처리 되었습니다.";
				color = "#21ba45";
			} else {
				text = "미완료처리 되었습니다.";
				color = "#db2828";
			}
			snackbar("issueSnackbar",color,text);
			popupHide();
		})
	}
}

function editOrRemove(seq,mode,memo) {
	if(mode =="modify") { // 업무정보수정
		
		$('#issue_modify').modal({
			onShow : function() {
				var param = {};
				param["table"] = "issue_list";
				param["where"] = " and seq = " + seq;
				ajax(param,"/common/simple_select.php",selectIssue);
			}
			,onDeny : popupDeny
			,onApprove : modifyIssue // 수정
			, onHide : popupHide
			}).modal('show');
		
	} else if(mode =="delete"){ 
		if(confirm("삭제한 업무는 복구할 수 없습니다.\n업무(업무내용: "+memo+")를 삭제하시겠습니까?")==true) {
			fn_delete("issue_list","seq",seq);
		} else {
			return;
		}	
	} 
}

function fn_submit(frm) {
	frm.submit();
}

function modifyIssue() {
	var param = {};
	param["param"] = jsonBot("issue_modify",["cs_name"]);
	param["table"] = "issue_list";
	param["id"] = ["seq"];
	ajax(param
		, "/common/simple_update.php"
		,function(result){ 
		snackbar("issueSnackbar","#54c8ff",result);
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
		fn_delete("issue_list","seq");
	} else {
		return;
	}
}

/*comment 관련 method*/
function comment(seq,tr,loca) {
	if(loca) {
		$(tr).closest("tr").toggleClass("comment");
		return;
	}
	$(tr).next().toggleClass("comment");
}
function comment_add(seq) {
	var bigo = $("#bigo"+seq).val();
	var param = {};
	param["param"] = {"bigo" : bigo, "seq" : seq};
	param["table"] = "issue_list";
	param["id"] = ["seq"];
	ajax(param,"/common/simple_update.php",
		function(result){ 
			alert(result); 
	});
}
/*==comment==*/
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
		return " / ".$val;
	}
}
?>