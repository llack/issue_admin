
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
		$(this).select();
	});
}

$(".checkall").on("click",function(){    
	$("input[id=chk]").prop("checked",true);
	//$("input[id=chk]").prop("checked",false);
});