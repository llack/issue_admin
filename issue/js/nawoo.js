window.undefined ="";
function ajax(params, url, callback, method){
	//var params = JSON.stringify(pParams);
	$.ajax({
		type : method ? method:"POST"
	,   url      : url
	,   dataType : "json"
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