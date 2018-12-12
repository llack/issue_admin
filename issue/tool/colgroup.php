	
	<div class="left aligned form">
	<h4 class="ui header">
	 colgroup 생성기
	</h4>
	<div class="ui input"> 
		<select id="maxNumber">
			<option value="unset">선택하세요</option>
			<? for($mn = 1; $mn <=20; $mn++) {?>
			<option value="<?=$mn?>"><?=$mn?></option>
			<? } ?>
		</select>
	</div>
	<button class="ui button inverted purple" onclick="makeTable()">
	  <i class="check circle icon"></i>
	  생성
	</button>
	<button class="ui button inverted purple hideContents" onclick="copyData()" style="display:none">
	  <i class="check circle icon"></i>
	  소스 복사
	</button>
	</div> <br/>
	<div class="ui center aligned" id="tableHere" style="width:100%"></div><br/>
	<div class="ui form center aligned copyWidth hideContents" style="display:none">
	소스 확인
		<textarea id="copyWidth" style="resize: none;border:1px solid #dc73ff"></textarea>
	</div>
	<!--  -->
	</div>
</body>
<script>
$(document).ready(function(){
	$("#maxNumber").dropdown();
});

$(document).on("keyup",".modifyTables",function(){
	$("#resultState").html("");
	var id = this.id;
	var value = this.value;
	if(isNaN(value)){
		$("#resultState").html("<br/><font color='red'>숫자만 입력해주세요</font>");
		setValue(id,null,null,0);
	} else if(value=="") {
		setValue(id,"0%","0%",0);
		resultWidth();
	} else {
		value = parseInt(value);
		setValue(id, value+"%", value+"%", value);
		
		if(!resultWidth()) {
			$("#resultState").html("<br/><font color='red'>합계 100이하로 입력해주세요</font>");
			setValue(id, "0%", "0%", 0);
			resultWidth();
		}
	}
	serWidth();
	setSource();
});

function resultWidth() {
	var resultWidth = 0;
	$("[id*='col_']").each(function(){
		resultWidth += this.value*1;
	});
	if(resultWidth > 100) {
		return false;
	} else {
		$("#resultWidth").html(resultWidth);
		return true;
	}
}
function setValue(id, html, prop, val) {
	if(html !== null) {
		$("[name='"+id+"']").html(html);
	}
	if(prop !== null) {
		$("."+id).prop("width",prop)
	}
	if(val !== null) {
		$("#"+id).val(val);
	}
}
function serWidth(){
	var resultWidth = 0;
	$("[id*='col_']").each(function(){
		resultWidth += this.value*1;
	});
	$("#serWidth").html("사용가능 : " + (100-resultWidth) + "%");
}
function copyData() {
	fn_copy("copyWidth");
	alert("복사되었습니다.");
}
function setSource() {
	var str = "<colgroup>\n";
	$("[id*='col_']").each(function(){
		str += "\t<col width=\""+this.value+"%\">\n";
	});
	str += "<colgroup>";
	$("#copyWidth").val(str)
}
function makeTable() {
	var num = $("#maxNumber").val()*1;
	if(isNaN(num)) {
		alert("1이상의 수를 입력해주세요");
		return;
	} else {
		var colgroup = "";
		var html = "<table class='ui celled table center aligned small'>";
		colgroup += "<colgroup>\n";
		for(var i = 0; i < num; i++) {
			colgroup += "\t<col width='0%' class='col_"+(i+1)+"'>\n";
		}
		colgroup += "</colgroup>";
		html += colgroup;
		html += "<tr><td colspan='"+num+"' class='resultTd'>합계 : <span id='resultWidth'>0</span>%";
		html += " / <span id='serWidth'>사용 가능 : 100%</span><span id='resultState'></span></td></tr>";
		html += "<tr>";
		for(var i = 0; i < num; i++) {
			html += "<td bgcolor='#E3FAFF'><a class='ui teal circular label'>"+(i+1)+"</a></td>";
		}
		html += "</tr>";
		html += "<tr>";
		for(var i = 0; i < num; i++) {
			html += "<td><span name='col_"+(i+1)+"'>0%</span><br/><div class='ui input' style='width:50px'>";
			html += "<input type='text' id='col_"+(i+1)+"' class='modifyTables' value='0' onclick='this.select()'/></div></td>";
		}
		html += "</tr>";
		html += "</table>";
		$("#tableHere").html(html);
		$(".hideContents").show();
		$("#copyWidth").prop("rows",(num+2)).val("");
		setSource();
	}
}
</script>
<style>
.resultTd {
	font-size : 20px;
}
</style>

</html>
