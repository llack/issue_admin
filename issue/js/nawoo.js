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

//폼 name값 넣으면 input아이들을 json으로 *컬럼명만 맞추면 됨.
function jsonBot(name) { 
	var param = {};
	$("form[name='"+name+"'] input").each(function(i,e){
		var name = $(e).attr("name");
		param[name] = $(e).val();
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

function enter_afterIndex(name) {
	$("form[name='"+name+"']").on("keydown","input",function(e) {
		if(e.which==13) {
			var index = $("input").index(this)+1;
			$("input").eq(index).focus();
		}
	}).on("focus","input",function(e){
		$(this).select();//dddd
	});
};

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

$(function(){
	
	$(".tr_hover").on({
		mouseover : function(){
			$(this).addClass("positive");
		},
		mouseout : function() {
			$(this).removeClass("positive");
		}
	});
	
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