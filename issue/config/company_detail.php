<?
session_start();

include $_SERVER["DOCUMENT_ROOT"]."/common/header.php";
$simple = new Simple_query();
$row = $simple->simple_select(" erp_ocsinfo "," and seq = '$_REQUEST[seq]' ");
$row = $row[0];
$link = $fn->auto_link("seq");
?>
<style>
#employee_info {
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
#employee {
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
#employee.show {
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
<body>
<div class="ui container side">
<? include $_SERVER["DOCUMENT_ROOT"]."/common/company_list.php"; ?>
</div>
<!-- 메인 테이블  -->
<div class="ui container table purple segment">
	<div class="right aligned">
		<a class="ui tag label">업체관리</a>
		<a class="ui red tag label">업체현황</a>
		<a class="ui teal tag label"><?=$row[cs_name]?></a>
	</div>
	<h2 class="ui header" style="margin-top: 0px">
		<i class="circular purple sitemap icon icon"></i>
		<div class="content"><?=$row[cs_name]?></div>
	</h2>
	<div class="right aligned">
		<button class="ui inverted purple button" onclick="location.href='company_info.php'">목록</button>
	</div>
	<form name="form">
		<input type="hidden" name="seq" value="<?=$_REQUEST[seq]?>"/>
		<div class="ui inverted segment">
		  <div class="ui inverted form">
		    <div class="two fields">
		      <div class="field">
		        <label>업체명</label>
		        <input type="text" name="cs_name" value="<?=$row[cs_name]?>">
		      </div>
		      <div class="field">
		        <label>업체코드</label>
		        <input type="text" name="cs_code" value="<?=$row[cs_code]?>">
		      </div>
		    </div>
		    <div class="three fields">
		      <div class="field">
		        <label>정보1</label>
		        <input type="text">
		      </div>
		      <div class="field">
		        <label>정보2</label>
		        <input type="text">
		      </div>
		      <div class="field">
		        <label>정보3</label>
		        <input type="text">
		      </div>
		    </div>
		  </div>
		</div>
		</form>
		<br/>
		<h2 class="ui header" style="margin-top: 0px" id="rowStart">
			<i class="circular purple address book outline icon"></i>
			<div class="content">사원목록<?$fn->add_nbsp(2)?>
				<button class="ui basic blue button" id="addRow">
				  <i class="icon plus square"></i>
				  사원 추가하기
				</button>
			</div>
		</h2>
		<!-- 사원입력창 -->
		<div id="cloneTarget" class="ui segment clone" style="display: none"></div>
		<div class="ui bottom attached button primary clone" style="display: none" onclick="addRow(1)">한 줄 추가하기</div>
		<div class="ui bottom attached button positive clone" style="display: none;margin-bottom:30px" onclick="saveInfo()">저장</div>
		<!-- 사원입력창 -->
		<? 
		$que_emp = "select * from employee_list where refseq = '$_REQUEST[seq]' order by name" ;
		$pagenator = new Paginator($que_emp);
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
		<button class="ui button inverted red" onclick="delete_employee()">
		  <i class="check trash alternate icon"></i>
		  선택삭제
		</button>
		</div>
		<table id="test" class="ui definition table fixed center aligned small">
			 <thead>
				  <tr style="background-color:#a333c8;" >
				    <th width="70px"><i class="large user icon" style="color:white!important"></i></th>
					<th width="70px">No.</th>
					<th>성명</th>
				    <th>직책</th>
				    <th>연락처</th>
				    <th>이메일</th>
				    <th><i class="large edit icon"></i>or <i class="large ban icon"></i></th>
				  </tr>
			  </thead>
			  <tbody>
			  <? for($i = 0; $i < $max; $i++) {
			  	$employee = $results->data[$i];
			  ?>
			  <tr class="tr_hover">
			  	<td>
			  		<div class="ui toggle checkbox">
					  <input type="checkbox" id="chk" value="<?=$employee[seq]?>">
					  <label></label>
					</div>
			  	</td>
			  	<td><a class="ui grey circular label"><?=($i+1)?></a></td>
			  	<td><?=$employee[name]?></td>
			  	<td><?=$employee[level]?></td>
			  	<td><?=$employee[phone]?></td>
			  	<td><?=$employee[email]?></td>
			  	<td>
				  	<div class="ui tiny buttons">
					  <button class="ui inverted blue button" onclick="editOrRemove('<?=$employee[seq]?>','modify')">수정</button>
					  <div class="or"></div>
					  <button class="ui inverted red button" onclick="editOrRemove('<?=$employee[seq]?>','delete','<?=$employee[name]?>')">삭제</button>
					</div>
			  	</td>
			  </tr>
			  <? } ?>
			  </tbody>
			</table>
		<? }else {?>
			<h2 class="ui icon header center aligned" id="emptyMsg">
			  <i class="ban red icon"></i>
			  <div class="content">
			    검색결과 없음!
			    <div class="sub header">사원을 추가해주세요</div>
			  </div>
			</h2>
		<? } ?>
		
		<!-- 페이징 -->
		<?=$pagenator->createLinks($link); ?><br/><br/>
		<!-- /페이징 -->
		<h2 class="ui icon header right aligned">
			<button class="ui inverted purple button" onclick="location.href='company_info.php'">목록</button>
		</h2>
</div>
<!-- clone -->
<div class="ui form" id="cloneContent0" data-idx="0" style="display:none">
	<input type="hidden" name="refseq" value="<?=$_REQUEST[seq]?>"/>
	<div class="six fields inline">
      <a class="ui grey circular label"><span id="cloneCnt0"></span></a><?$fn->add_nbsp(5)?>
      <div class="field">
        <label>성명</label><br/>
        <input type="text" name="name">
      </div>
      <div class="field">
        <label>직책</label><br/>
        <input type="text" name="level">
      </div>
      <div class="field">
        <label>연락처</label><br/>
        <input type="text" name="phone">
      </div>
      <div class="field">
        <label>이메일</label><br/>
        <input type="text" name="email">
      </div>
      <div class="field">
        <label><?$fn->add_nbsp(1)?></label><br/>
      <button class="ui inverted red button removeRow">삭제</button>
      </div>
    </div>
</div>
<!-- clone -->
<!--  업체 수정 팝업 -->
<div id="employee_modify"class="ui basic modal">
  <div class="content">
  	<div id="employee_info">
	<div class="login header">
		<div style="text-align:right !important"><i class="user icon"></i>사 원 정 보 수 정</div>
	</div>
	<br/><br/>
	<form class="ui fluid form" name="employee_form">
  <div class="field">
  <div class="inline field">
    <div class="ui ribbon  purple basic label">
      성명
    </div>
    <input type="text" name="name" value="" onfocus="this.setSelectionRange(this.value.length, this.value.length)">
  </div>
  <div class="inline field">
    <div class="ui ribbon purple basic label">
      회사코드
    </div>
   <input type="text" name="level" value="">
  </div>
  <div class="inline field">
    <div class="ui ribbon purple basic label">
      연락처
    </div>
   <input type="text" name="phone" value="">
  </div>
  <div class="inline field">
    <div class="ui ribbon purple basic label">
      이메일
    </div>
   <input type="text" name="email" value="">
  </div>
  </div>
  <input type="hidden" name="seq" value=""/>
</form>
</div>
  </div>
  <div class="actions">
    <div class="ui red basic cancel inverted button">
      <i class="remove icon"></i>
      취 소
    </div>
    <div class="ui green ok inverted button">
      <i class="checkmark icon"></i>수 정</div>
  </div>
</div>

<div id="employee"></div>

</body>
</html>
<script>
$(document).ready(function(){
	hoverMaster("tr_hover","positive");
});
$(document).on("click","#addRow,.addrow",function(e){
	e.preventDefault();
	addRow();
});

$(document).on("click",".removeRow",function(e){
	e.preventDefault();
	var sort = "div[id*='cloneContent']:visible";
	$(this).closest(sort).remove();
	$(sort).each(function(i){
		num = i+1
		$(this).prop("id","cloneContent"+(num));
		$(this).attr("data-idx",(num));
		$(this).find("span[id*=cloneCnt]").prop("id","cloneCnt"+(num));
		$("#cloneCnt" + (num)).text((num));
	});
	if($(sort).length==0) {
		$(".clone").css("display","none");
		$("#emptyMsg").css("display","");
	}
});
function addRow(addOne) {
	var num = 0;
	$("div[id*='cloneContent']:visible").each(function(i){
		num++;
	});
	if(addOne) {
		makeDiv(num);
	} else {
		var popup = prompt("추가할 사원수를 입력하세요\n* 숫자만 입력할 수 있습니다.","1");
		if(popup != null && popup.trim()!=0 && isNaN(popup)===false) {
			for(var i = num; i < num+(popup*1); i++) {
				makeDiv(i);
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
	
	if(num != 0) {
		cl.insertAfter(id);
	} else {
		cl.appendTo("#cloneTarget");
	}
	
	$("#" + cnt).text((num+1));
	$("#" + next + "").css("display","");
}
function saveInfo() {
	var param = {};
	var out = true;
	$("div[id*='cloneContent']:visible").each(function(i,e){
		var save = {};
		var id = $(this).attr("id");
			$("#" + id +" input").each(function(){
				var name = $(this).attr("name");
				var value = $(this).val();
				if(name == "name" && value.trim().length == 0) {
					alert("성명은 필수항목입니다.");
					$(this).focus();
					out = false;
				}
				save[name] = $(this).val();
			});
		if(out==true) {
			param[i] = save;
		} else {
			return out;
		}
	});
	if(out == true) { 
		var obj = {};
		obj["employee"] = param;
		ajax(obj, "company_detail_ok.php",companyModify);
	}
}

function delete_employee() {
	var c = $("input[id='chk']:checked");
	if(c.length==0) {
		alert("삭제 대상이 없습니다.");
		return;
	}
	var param = {};
	if(confirm("삭제한 사원은 복구할 수 없습니다.\n총 "+$("#chk:checked").length+"건 삭제하시겠습니까?")==true) {
		fn_delete("employee_list","seq");
	} else {
		return;
	}
}

function editOrRemove(seq,mode,name) {
	if(mode =="modify") { 
		$('#employee_modify').modal({
			onShow : function() {
				var param = {};
				param["table"] = "employee_list";
				param["where"] = " and seq = " + seq;
				ajax(param
					,"/common/simple_select.php"
					,function(result){
						var data = result[0];
						var max = Object.keys(result[0]).length;
						for(var key in data) {
							console.log( key + "," + data[key]);
							$("form[name='employee_form'] input[name='"+key+"']").val(data[key]);
						}
					});
			}
			,onDeny : popupDeny
			,onApprove : function(e) {
					if(!trim_chk($("form[name='employee_form'] input[name='name']").val(),"name","성명을 입력해주세요")){
						return false;
					}else {
						var param = {};
						var data = {};
						param["param"] = jsonBot("employee_form");
						param["table"] = "employee_list";
						param["id"] = ["seq"];
						ajax(param
							, "/common/simple_update.php"
							,function(result){ 
							snackbar("employee","#54c8ff",result);
						});
					}
				}
			, onHide : popupHide
			})
			.modal('show');
	} else if(mode =="delete"){
		if(confirm("삭제한 사원는 복구할 수 없습니다.\n사원(사원명: "+name+")를 삭제하시겠습니까?")==true) {
			fn_delete("employee_list","seq",seq);
		} else {
			return;
		}	
	}
}
/* CALLBACK */
function companyModify(result) {
	alert(result);
	location.reload();
}
/* CALLBACK */
</script>




