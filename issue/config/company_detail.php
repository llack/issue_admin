<?
session_start();

include $_SERVER["DOCUMENT_ROOT"]."/common/header.php";
$simple = new Simple_query();
$row = $simple->simple_select(" erp_ocsinfo "," and seq = '$_REQUEST[seq]' ");
$row = $row[0];
?>
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
		<div id="cloneTarget" class="ui segment clone" style="display: none">
		</div>
		<div class="ui bottom attached button primary clone" style="display: none" onclick="addRow(1)">한 줄 추가하기</div>
		<div class="ui bottom attached button positive clone" style="display: none;margin-bottom:300px" onclick="saveInfo()">저장</div>
		<? if(1==0) {?>
		<div class="ui inverted segment">
			<div class="ui inverted form">
				
			</div>
		</div>
		<? } else {?>
			<h2 class="ui icon header center aligned" id="emptyMsg">
			  <i class="ban red icon"></i>
			  <div class="content">
			    검색결과 없음!
			    <div class="sub header">사원을 추가해주세요</div>
			  </div>
			</h2>
		<? } ?>
</div>
<!-- clone -->
<div class="ui form" id="cloneForm" data-idx="0" style="display:none">
	<div class="six fields inline">
      <a class="ui grey circular label"><span id="cloneCnt"></span></a><?$fn->add_nbsp(5)?>
      <div class="field">
        <label>성명</label>
        <input type="text" name="name">
      </div>
      <div class="field">
        <label>직책</label>
        <input type="text" name="level">
      </div>
      <div class="field">
        <label>연락처</label>
        <input type="text" name="phone">
      </div>
      <div class="field">
        <label>이메일</label>
        <input type="text" name="email">
      </div>
      <div class="field">
        <label><?$fn->add_nbsp(1)?></label>
      <button class="ui inverted red button removeRow">삭제</button>
      </div>
    </div>
<!-- clone -->
</div>

</body>
</html>
<script>
$(document).on("click","#addRow,.addrow",function(e){
	e.preventDefault();
	addRow();
})

$(document).on("click",".removeRow",function(e){
	e.preventDefault();
	var sort = "div[id*='cloneContent']";
	$(this).closest(sort).remove();
	$(sort).each(function(i){
		$(this).prop("id","cloneContent"+(i+1));
		$(this).attr("data-idx",(i+1));
		$(this).find("span[id*=cloneCnt]").prop("id","cloneCnt"+(i+1));
		$("#cloneCnt" + (i+1)).text((i+1));
	});
	if($(sort).length==0) {
		$(".clone").css("display","none");
		$("#emptyMsg").css("display","");
	}
})

function addRow(addOne) {
	if(addOne) {
		var num = 0;
		$("div[id*='cloneContent']").each(function(i){
			num++;
		});
		makeDiv(num);
	} else {
		var popup = prompt("추가할 사원수를 입력하세요\n* 숫자만 입력할 수 있습니다.","1");
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
	cl.find("input").val("");
	cl.insertAfter(id);
	$("#" + cnt).text((num+1));
	$("#" + next + "").css("display","");
}

function saveInfo() {
	var param = {};
	$("div[id*='cloneContent']").each(function(i,e){
		var save = {};
		var id = $(this).attr("id");
		$("#" + id +" input").each(function(){
			var name = $(this).attr("name");
			save[name] = $(this).val();
		});
		param[i] = save;
	});
	var info = jsonBot("form");
	var obj = {};
	obj["employee"] = param;
	obj["info"] = info;
	ajax(obj, "company_detail_ok.php",function(result){ location.reload();});
}
</script>




