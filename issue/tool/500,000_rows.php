	<table id="datatables" class="ui definition table center aligned small" style="width:100%">
		
		<thead>
			<tr align="center" > 
				<th class="no-search no-sort" style="background-color:#a333c8;">
					<i class="large briefcase icon" style="color:white!important"></i>
				</th>
				<th class="no-search no-sort">No.</th>
				<th class="no-search">업체명<br/>(요청자)</th>
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
		
	</table>
	</div>
<!-- clone + 팝업 elements -->
<? include_once $_SERVER["DOCUMENT_ROOT"].'/sub/index_sub.php';?>
<!-- // -->
</body>
<script>
$(document).ready(function(){
	$("#toolName").dropdown(); //필터검색
	$(".stateDiv").dropdown({
		action : 'hide',
		onChange : stateModify
	});
	
	dropDown("#cs_seq,#user_id"); //select 검색

	$("#datatables").addClass("row-border cell-border order-column hover");
	var param = {};
	param["where"] = " order by state asc,regdate desc,cs_name asc ";
	param["col"] = [
		 { "data": "seq" },
       	 { "data": "no" },
       	 { "data": "cs_name"},
       	 { "data": "memo" },
       	 { "data": "regdate" },
       	 { "data": "end_date" },
       	 { "data": "order_name" },
       	 { "data": "user_name" },
       	 { "data": "finish_date" },
       	 { "data": "state" },
       	 { "data": "view" }	
	];
	var sortObj = {}
	for ( key in param["col"]) {
		sortObj[key] = param["col"][key].data;
	}
	param["sort"] = sortObj;
	param["noSearch"] = [0,1,9,10];
	$("#datatables").DataTable( {
				"processing": true,
	         "serverSide": true,
	         "ajax": { 
    	      	url : "/tool/serverside.php",
    	      	type: "POST",
    	      	data : param
    			//,dataSrc : function(result){console.log(result);}
	         },
	         "columns" : param["col"],
    	     "language": {
    	            "lengthMenu": "_MENU_개씩 보기",
    	            "zeroRecords": "검색 결과 없음",
    	            "info": "_PAGE_/_PAGES_",
    	            "infoEmpty": "",
    	            "infoFiltered": "",
    	            "search" : "결과 내 검색",
    	            "processing" : "<img width='70px' src='/img/processing.gif'></img>",
    	            "paginate": {
    	     		 "previous": "<",
    	     		 "next" : ">",
    	     		 "first" : "처음",
    	     		 "last" : "마지막"
    	    		}
    	        },
    	        "columnDefs": [
        	        {"targets": 'no-sort', "orderable": false,"order" : []},
    	        	{"targets": 'no-search',"searchable": false},
    	        	{ "className": "dt-body-left", "targets" : [3]},
    	        	{"width" : "5%" , "targets" : 0},
    	        	{"width" : "5%" , "targets" : 1},
    	        	{"width" : "10%" , "targets" : 2},
    	        	{"width" : "24%" , "targets" : 3},
    	        	{"width" : "8%" , "targets" : 4},
    	        	{"width" : "8%" , "targets" : 5},
    	        	{"width" : "7%" , "targets" : 6},
    	        	{"width" : "7%" , "targets" : 7},
    	        	{"width" : "8%" , "targets" : 8},
    	        	{"width" : "10%" , "targets" : 9},
    	        	{"width" : "9%" , "targets" : 10}
    	        	
    	        ],
    	        fixedColumns: true,
    	        searchHighlight: true,
    	        pagingType: "full_numbers",
    	        drawCallback: function(settings) {
    	        	var top = $(this).closest('.dataTables_wrapper');
    	        	var select = top.find("[name='datatables_length']").dropdown();
    	        	select.closest(".dropdown").css({"min-width":"0"});
    	        	var input = top.find("label > input")
    	        	input.wrap("<div class='ui icon  input'>");
    	        	input.after("<i class='inverted circular search link purple icon'></i>");
    	        	var pagination = top.find('.dataTables_paginate,.dataTables_info');
    			    pagination.toggle(this.api().page.info().pages > 1);
    			  }
	    });
		//
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
	sortElements(cl,(num+1),"cloneCnt","csCnt","csPerson","userName","userView","cs_name","line","regdate","end_date");

	cl.insertAfter("#cloneContent"+num);// copy end
	
	/* selects */
	var userName = $("#userName"+cnt).val();
	var csCnt = $("#csCnt"+cnt).val();
	$("#userName"+(num+1)).val(userName);
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
		sortElements($(this),num,"regdate","cs_name","end_date","cloneCnt","csCnt","csPerson","userName","userView","line");
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
		var text,color,memo,userName,regdate,gubunColor;

		userName = "<?=$_SESSION["USER_NAME"]?>";
		regdate = "<?=date("Y-m-d H:i:s")?>";
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
							"user_name" : userName, 
							"regdate" : regdate,
							"gubunColor" : gubunColor};
		ajax(history,"/common/simple_insert.php");
		
		snackbar("issueSnackbar",color,text);
		popupHide();
	});
}
function userSelect(id,val) {
	// id_format userName + (num)
	var idCut = id.substr(8);
	if(val != "") {
		var param = {};
		param["table"] = "member";
		param["where"] = " and user_id = '"+val+"' ";
		ajax(param,"/common/simple_select.php",function(result){
			$("#userView" + idCut).html(result[0].user_name);
		});
		$("#line" + idCut).css("display","");
		return;
	}
	$("#line" + idCut).css("display","none");
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
	cl.find("[id*=csPerson]").val("");
	cl.find("[id*=line]").css("display","none");
	sortElements(cl,(num+1),"cloneCnt","csCnt","csPerson","userName","userView","cs_name","line");
	
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
		ajax(obj, "issue_add_ok.php",function (result) { alert(result);	location.reload(); });
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
