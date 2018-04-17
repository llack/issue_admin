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