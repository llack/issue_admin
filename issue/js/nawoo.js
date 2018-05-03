function ajax(params, url, callback, data, method){
	//var params = JSON.stringify(pParams);
	$.ajax({
		type : method ? method:"POST"
	,   url      : url
	,   dataType : data ? data : "json"
	,   data     : params
	,   success : callback
	,   error : function(xhr, status, e) {
			console.log("에러 : "+e);
	},
	complete  : function() {
	}
	});
}

function setJson() {
	var frm = arguments[0];
	var param = {};
	for(var i = 1; max=arguments.length, i < max; i++) {
		param[arguments[i]] = frm[arguments[i]].value;
	}
	return param;
}

// (폼 name값, 미전송 type=array) *컬럼명만 맞추면 됨.
function jsonBot(name,deleteEle) { 
	var param = {};
	if(!deleteEle) {
		deleteEle = [];
	}
	$("form[name='"+name+"'] input").each(function(i,e){
		var name = $(e).attr("name");
		if(deleteEle.indexOf(name) === -1) {
			param[name] = $(e).val();
		}
	});
	return param;
}

function move(url) {
	location.href= url;
}
/*클립보드 fn_copy(input's id)*/
function fn_copy(id) {
	var copyText = document.getElementById(id);
	  copyText.select();
	  document.execCommand("Copy");
} 

/* create snackbar  <div id='id'></div>  + html,css self */
function snackbar(id) {
    var x = document.getElementById(id);
    x.className = "show";
    setTimeout(function(){ x.className = x.className.replace("show", ""); }, 500);
}
/* 간편 인덱스 */
function enter_afterIndex(name) {
	$("form[name='"+name+"']").on("keydown","input",function(e) {
		if(e.which==13) {
			var index = $("input").index(this)+1;
			$("input").eq(index).focus();
		}
	}).on("focus","input",function(e){
		this.setSelectionRange(this.value.length, this.value.length);

	});
};

/* 간편 삭제 */
function fn_delete(table,id,chk) {
	var param = {};
	
	if(!chk) {
		var c = $("input[id='chk']:checked");
		if(c.length==0) {
			alert("삭제 대상이 없습니다.");
			return;
		}
		var a = []
		c.each(function(i,e){
			a.push($(e).val());
		});
		param["chk"] = a;
	} else {
		param["chk"] = chk;
	} 
	param["table"] = table;
	param["id"] = id;
	ajax(param
		,	"/common/simple_delete.php"
		,	function(result){ 
		alert(result); 
		location.reload();
	});
}

/* mouse hover 효과 간단적용  */ 
function hoverMaster(selector, apply) {
	$("."+selector+"").on({
		mouseover : function(){
			$(this).addClass(apply);
		},
		mouseout : function() {
			$(this).removeClass(apply);
		}
	});
}

$(function(){
	
	$(".checkall").click(function(){
		
		var a = $("#checkall");
		var c = $("input[id='chk']");
		var i = "";
		var str = "";
		if(a.prop("checked")===false) {
			a.prop("checked",true);
			c.prop("checked",true);
			str = "선택해제";
			i = "<i class='ban icon'></i>";
		} else {
			a.prop("checked",false);
			c.prop("checked",false);
			str = "전체선택";
			i = "<i class='check circle icon'></i>";
		}
		$(this).html(i+str);
	}); 
});