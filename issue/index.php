<?
session_start();

include $_SERVER["DOCUMENT_ROOT"]."/common/header.php";

$link = $fn->auto_link("cs_code","sdate","edate");
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
	
	<i class="circular purple tags icon "></i>
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
		<button class="ui button inverted purple checkall">
		  <i class="check circle icon"></i>
		  전체선택
		</button>
		<input type="checkbox" id="checkall" style="display:none;"/>
		<button class="ui button inverted red" onclick="delete_issue()">
		  <i class="check trash alternate icon"></i>
		  선택삭제
		</button>
		<? $cs_list = $fn->cs_list();
		$cs_list_cnt = count($cs_list);
		?>
	<form name="form" method="POST" style="margin:0px;float:right;padding-right:150px">
	<input type="hidden" value="1" name="page"/>
	<i class="search icon purple"></i>업체 검색 : <?=$fn->add_nbsp(3)?>
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
	<!-- 일정검색 -->
	<?=$fn->add_nbsp(3)?>
	<i class="calendar alternate outline icon purple"></i>일정 검색 : <?=$fn->add_nbsp(3)?>
	<div class="ui form"style="float: right">
	  <div class="fields">
	    <div class="field">
	       <div class="ui calendar datepicker">
		    <div class="ui input left icon">
		      <i class="calendar alternate outline icon"></i>
		      <input type="text" value="<?=$sdate?>" name="sdate">
		    </div>
		  </div>
	    </div>
	    <?=$fn->add_nbsp(2)?>~<?=$fn->add_nbsp(2)?>
	    <div class="field">
	      <div class="ui calendar datepicker">
		    <div class="ui input left icon">
		      <i class="calendar alternate outline icon"></i>
		      <input type="text" value="<?=$edate?>" name="edate">
		    </div>
		  </div>
		</div>
	    </div>
	  </div>
	  <!-- /일정검색 -->
	</div>
	</form>
	
	<table id="test" class="ui definition table fixed center aligned small">
	 <thead>
		  <tr style="background-color:#a333c8;" >
		    <th width="70px"><i class="large briefcase icon" style="color:white!important"></i></th>
			<th width="70px">No.</th>
			<th>회사명</th>
		    <th>회사코드</th>
		    <th>정보1</th>
		    <th>정보2</th>
		    <th>정보3</th>
		    <th><i class="large edit icon"></i>or <i class="large ban icon"></i></th>
		  </tr>
	  </thead>
	  <tbody>
	  <tr class="tr_hover">
	  	<td>
	  		<div class="ui toggle checkbox">
			  <input type="checkbox" id="chk" value="<?=$row[seq]?>">
			  <label></label>
			</div>
	  	</td>
	  	<td><a class="ui grey circular label">dd</a></td>
	  	<td><?=$row[cs_name]?></td>
	  	<td><?=$row[cs_code]?></td>
	  	<td></td>
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
	  </tbody>
	</table>
	</div>
<!--  -->
<!-- clone -->
<div class="ui form" id="cloneForm" data-idx="0" style="display:none">
	<div class="six fields inline">
      <a class="ui grey circular label"><span id="cloneCnt"></span></a><?$fn->add_nbsp(5)?>
      <div class="field">
        <label>업체</label><br/>
         <div class="ui fluid">
			<select name="refseq" class="fluid" id="csCnt" onchange="loadEmployee(this.id,this.value)">
				<option value="unset">선택하세요</option>
			<?	for($i = 0; $i < $cs_list_cnt; $i++) {	?>
				<option value="<?=$cs_list[$i][seq]?>"><?=$cs_list[$i][title]?></option>	
			<? } ?>
			</select>
		</div>
      </div>
      <div class="field">
        <label>업무내용</label><br/>
        <div class="ui fluid input">
		  <input type="text" name="memo">
		</div>
      </div>
      <?$fn->add_nbsp(5)?>
      <div class="field selectDiv error">
        <label>요청자</label><br/>
        <div class="ui fluid">
        	<select name="cs_person" class="fluid" id="csPerson">
        		<option value="unset">업체 미선택</option>
        	</select>
        </div>
        <!-- <input type="text" name="cs_person"> -->
      </div>
      <div class="field">
        <label>업무담당자</label><br/>
        <div class="ui fluid">
        	<select name="user_name" class="fluid">
        		<option value="unset">선택하세요</option>
        		<?
        			$user_list = $fn->UserInfo();
        			$max = count($user_list);
        			for ($user = 0; $user < $max; $user++) {
        		?>
        		<option value="<?=$user_list[$user][user_name]?>"><?=$user_list[$user][user_name]?></option>
        		<? } ?>
        	</select>
        </div>
      </div>
      <div class="field">
      	<label>등록일</label><br/>
      	<div class="ui calendar datepicker">
		    <div class="ui input left icon">
		      <i class="calendar alternate outline icon"></i>
		      <input type="text" value="<?=date("Y-m-d")?>" name="regdate">
		    </div>
		  </div>
      </div>
      <div class="field">
        <label><?$fn->add_nbsp(1)?></label><br/>
      <button class="ui inverted red button removeRow">삭제</button>
      </div>
    </div>
</div>
<!-- clone -->	
</body>
<script>
$(document).on("click","#addRow,.addrow",function(e){
	e.preventDefault();
	addRow();
});

$(document).on("click",".removeRow",function(e){
	e.preventDefault();
	var sort = "div[id*='cloneContent']";
	$(this).closest(sort).remove();
	$(sort).each(function(i){
		$(this).prop("id","cloneContent"+(i+1));
		$(this).attr("data-idx",(i+1));
		$(this).find("span[id*=cloneCnt]").prop("id","cloneCnt"+(i+1));
		$(this).find("select[id*=csCnt]").prop("id","csCnt"+(i+1));
		$(this).find("select[id*=csPerson]").prop("id","csPerson"+(i+1));
		$("#cloneCnt" + (i+1)).text((i+1));
	});
	if($(sort).length==0) {
		$(".clone").css("display","none");
		$("#emptyMsg").css("display","");
	}
});

$(document).ready(function(){

	$("#cs_code").dropdown({
		forceSelection: false
		,message : {
			noResults     : "검색 결과 없음"
		}
		,selectOnKeydown : false
		,fullTextSearch: true
	});
})

function addRow(addOne) {
	if(addOne) {
		var num = 0;
		$("div[id*='cloneContent']").each(function(i){
			num++;
		});
		makeDiv(num);
	} else {
		var popup = prompt("추가할 업무수를 입력하세요\n* 숫자만 입력할 수 있습니다.","1");
		if(popup != null && popup.trim()!=0 && isNaN(popup)===false) {
			var num = 0;
			$("div[id*='cloneContent']").each(function(i){
				num++;
			});
			for(var i = num; i < num+(popup*1); i++) {
				
				var next = "cloneContent"+(i+1);
				var id = "#cloneContent" + i;
				
				if(i == 0) {
					var cl = $("#cloneForm").clone(); 
					
					cl.prop("id", next).attr("data-idx",(i+1)); //id,index값 +1 바꾸고
					cl.find("#cloneCnt").prop("id","cloneCnt1"); // 로우 넘버
					cl.find("#csCnt").prop("id","csCnt1"); 
					cl.find("#csPerson").prop("id","csPerson1");
					cl.appendTo("#cloneTarget"); //적용
					$("#" + next + "").css("display","");
					$("#cloneCnt1").text(1);
				} else {
					makeDiv(i);
				}
			}
			$(".clone").css("display","");
			$("#emptyMsg").css("display","none");
		} else if(popup ==null) {
			return;
		} else {
			alert("잘못된 값입니다. 다시 입력해주세요!");
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
	cl.find("input[type!='hidden']").val("");
	/* select Box */
	cl.find("#csCnt" + num + "").prop("id","csCnt"+(num+1));
	cl.find("#csPerson" + num + "").prop("id","csPerson"+(num+1));
	cl.find(".selectDiv").addClass("error");
	cl.find("select[id*=csPerson]").html("<option value='unset'>업체 미선택</option>");
	/* == select Box == */
	cl.insertAfter(id);
	$("#" + cnt).text((num+1));
	$("#" + next + "").css("display","");
}
function loadEmployee(id,refseq) {
	if(refseq != "unset") {
		var param = {};
		param["table"] = "employee_list";
		param["where"] = " and refseq = '" + refseq + "' order by name";
		ajax(param,"/common/simple_select.php",function(result){ makeSelect(id,result) });
	} else {
		$("#csPerson" + id.substr(5) +"").html("<option value=''>업체미선택</option>");
		$("#csPerson" + id.substr(5) +"").closest(".selectDiv").addClass("error");
	}
}
function fn_submit(frm) {
	frm.submit();
}

function delete_issue() {
	alert(1);
}
/* CALLBACK*/ 
 function makeSelect(id,result) {
	 var csPerson = $("#csPerson" + id.substr(5) +"");
	 if(result) {
		 var option = "<option value='unset'>선택하세요</option>";
		 max = result.length;
		 for (var i = 0; i < max; i++) {
			 option += "<option value='"+result[i].name+"'>"+result[i].name+"</option>";
		}
		 csPerson.html(option);
		 csPerson.closest(".selectDiv").removeClass("error");
	 } else {
		 csPerson.html("<option value=''>사원등록 수 : 0</option>");
		 csPerson.closest(".selectDiv").addClass("error");
	}
}
/* == CALLBACK ==*/
</script>
</html>