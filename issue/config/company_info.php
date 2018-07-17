<?
session_start();

include $_SERVER["DOCUMENT_ROOT"]."/common/header.php";
?>
<style>
#company_info {
	position: absolute;
	 width: 480px;
	 height: 480px;
	 left: 50%;
	 top: 50%;
	 margin-left: -250px;
	 margin-top: -250px;
	 border: solid #a333c8 2px;
	 border-radius: 25px;
	 padding : 1rem;
}
#cs_modify {
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
#cs_modify.show {
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
</style>
<link rel="stylesheet" href="/css/huebee.css">
<script src="/js/huebee.js"></script>
<body>
<div class="ui container side">
<? include $_SERVER["DOCUMENT_ROOT"]."/common/company_list.php"; ?>
</div>
<!-- 메인 테이블  -->
<div class="ui container table purple segment">
	<div class="right aligned">
		<a class="ui tag label">menu</a>
		<a class="ui red tag label">업체관리</a>
		<a class="ui teal tag label">업체현황</a>
	</div>
	<h2 class="ui header" style="margin-top: 0px">
	<i class="circular purple sitemap icon"></i>
	<div class="content">업체관리<?$fn->add_nbsp(2)?>
		<button class="ui basic blue button" onclick="editOrRemove('','insert')">
		  <i class="icon plus square"></i>
		  업체 추가하기
		</button>
	</div>
	</h2>
	<div class="ui left aligned">
		<button class="ui button inverted purple checkall">
		  <i class="check circle icon"></i>
		  전체선택
		</button>
		<input type="checkbox" id="checkall" style="display:none;"/>
		<button class="ui button inverted red" onclick="delete_company()">
		  <i class="check trash alternate icon"></i>
		  선택삭제
		</button>
		<? $cs_list = $fn->cs_list();
		$cs_list_cnt = count($cs_list);
		?>
	<form name="form" method="POST" style="margin:0px;float:right">
	<input type="hidden" value="1" name="page"/>
	<i class="search icon purple"></i>업체검색 : <?=$fn->add_nbsp(3)?>
	<select id="cs_code" name="cs_code" class="ui search dropdown" onchange="fn_submit(document.form)" style="width: 200px">
		<option value="unset">선택하세요</option>
		<?
			for($i = 0; $i < $cs_list_cnt; $i++) { 
				if($_REQUEST[cs_code]==$cs_list[$i][description]) {
					$selected = "selected";
				} else {
					$selected = "";
				}
			?>
				<option value="<?=$cs_list[$i][description]?>" <?=$selected?>><?=$cs_list[$i][title]?></option>	
		<? } ?>
	</select>
	</div>
	</form>
	 <?
	  	$where = ""; 
	  	if($_REQUEST[cs_code] != "" && $_REQUEST[cs_code]!="unset") {
	  		$where .= " and cs_code = '".$_REQUEST[cs_code]."' ";
	  	}
	  	$que = " select * from erp_ocsinfo where 1=1 $where order by cs_name ";
	  	$res = mysql_query($que) or die(mysql_error());
	  	$max = mysql_num_rows($res);
	  	if($max > 0) { ?>
	<!-- 업체리스트 --><br/>
	<table id="datatables" class="ui definition table fixed center aligned small" data-order="[]">
	  <thead>
		  <tr>
		    <th class="no-search no-sort"width="70px" style="background-color:#a333c8;">
		    	<i class="large building icon" style="color:white!important"></i>
		    </th>
			<th width="70px" clas="no-search">No.</th>
			<th>업체명</th>
		    <th>업체코드</th>
		    <th class="no-search no-sort">업체 색상(달력)</th>
		    <th>정보2</th>
		    <th>정보3</th>
		    <th class="no-search no-sort"><i class="large edit icon"></i>or <i class="large ban icon"></i></th>
		  </tr>
	  </thead>
	  <tbody>
	 <? $i = 1;
	 while($row = mysql_fetch_array($res)) { ?>
	  <tr class="tr_hover">
	  	<td>
	  		<div class="ui toggle checkbox">
			  <input type="checkbox" id="chk" value="<?=$row[seq]?>">
			  <label></label>
			</div>
	  	</td>
	  	<td><?=$i?></td>
	  	<td><a href="javascript:move('company_detail.php?seq=<?=$row[seq]?>')"><?=$row[cs_name]?></a></td>
	  	<td><a href="javascript:move('company_detail.php?seq=<?=$row[seq]?>')"><?=$row[cs_code]?></a></td>
	  	<td>
	  	<? if($row[color] != "") {
	  		if($row[color] == "#FFFFFF") {
	  			$border = "border:1px solid purple";
	  		}
	  		?>
	  		<button class="ui mini button" style="background-color:<?=$row[color]?>;<?=$border?>"><?=$fn->add_nbsp(15)?></button>
	  	<? } ?>
	  	</td>
	  	<td></td>
	  	<td></td>
	  	<td>
		  	<div class="ui tiny buttons">
			  <button class="ui inverted blue button" onclick="editOrRemove('<?=$row[seq]?>','modify')">수정</button>
			  <div class="or"></div>
			  <button class="ui inverted red button" onclick="editOrRemove('<?=$row[seq]?>','delete','<?=$row[cs_name]?>')">삭제</button>
			</div>
	  	</td>
	  </tr>
	  <? $i++;} ?>
	 </tbody>
	</table>
	<? } else { ?>
	<h2 class="ui icon header center aligned">
	  <i class="ban red icon"></i>
	  <div class="content">
	    검색결과 없음!
	    <div class="sub header">업체를 추가해주세요</div>
	  </div>
	</h2>
	<? } ?>
	<!-- /업체리스트 -->
<? include_once $_SERVER["DOCUMENT_ROOT"].'/sub/company_info_sub.php';?>
</div>
<div id="cs_modify"></div>
</body>
<script>
$(document).ready(function(){
	$("#cs_code").dropdown({
		forceSelection: false
		,message : {
			noResults     : "검색 결과 없음"
		}
		,selectOnKeydown : false
		,fullTextSearch: true
	});

	hoverMaster("tr_hover","positive");
	enter_afterIndex("cs_modify");
	fn_table("#datatables");
});
function delete_company(seq,user_name) {
	var c = $("#chk:checked");
	if(c.length==0) {
		alert("삭제 대상이 없습니다.");
		return;
	}
	var param = {};
	if(confirm("삭제한 업체는 복구할 수 없습니다.\n총 "+c.length+"건 삭제하시겠습니까?")==true) {
		multiDelete(["erp_ocsinfo*seq","employee_list*refseq"]);
	} else {
		return;
	}
}

function fn_submit(frm) {
	frm.submit();
}

function editOrRemove(seq,mode,cs_name) {
	if(mode =="modify") { // 업체수정
		$('#company_modify').modal({
			onShow : selectCompany(seq)
			,onDeny : popupDeny
			,onApprove : modifyCompany
			, onHide : popupDeny
			})
			.modal('show');
	} else if(mode =="delete"){ // 업체삭제
		if(confirm("삭제한 업체는 복구할 수 없습니다.\n업체(업체명: "+cs_name+")를 삭제하시겠습니까?")==true) {
			fn_delete("erp_ocsinfo","seq",seq);
		} else {
			return;
		}	
	} else { // 업체등록 
		$('#company_modify').modal({
			onShow : function() {
				$(".popup_title").text("등 록");
				$('#company_modify').find("input").val("");
				colorPicker(".colorPicker","color","#e9e9e9");
			}
			,onDeny : popupDeny
			,onApprove : insertCompany
			, onHide : popupDeny
			})
			.modal('show');
	}
}
function selectCompany(seq) {
	var param = {};
	param["table"] = "erp_ocsinfo";
	param["where"] = " and seq = " + seq;
	ajax(param
		,"/common/simple_select.php"
		,function(result){
			var data = result[0];
			for(var key in data) {
				$("input[name='"+key+"']").val(data[key]);
			}
			colorPicker(".colorPicker","color",data.color);
		});
} 

function modifyCompany(e) {
	if(!trim_chk($("input[name='cs_name']").val(),"cs_name","회사명을 입력해주세요")){
		return false;
	}else {
		var param = {};
		var data = {};
		param["param"] = jsonBot("cs_modify");
		param["table"] = "erp_ocsinfo";
		param["id"] = ["seq"];
		ajax(param
			, "/common/simple_update.php"
			,function(result){ 
			snackbar("cs_modify","#54c8ff",result);
			popupHide();
		});
	}
}

function insertCompany() {
	if(!trim_chk($("input[name='cs_name']").val(),"cs_name","회사명을 입력해주세요")){
		return false;
	} else {
		var param = {};
		param["param"] = jsonBot("cs_modify",["seq"]);
		param["table"] = "erp_ocsinfo";
		ajax(param
			,"/common/simple_insert.php"
			,function(result){ 
			snackbar("cs_modify","#21ba45",result);
			popupHide();
		});
		
		}
}
</script>
</html>






