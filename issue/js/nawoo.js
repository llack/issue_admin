function ajax(params, url, callback, data, method){
	$.ajax({
		type : method ? method:"POST"
	,   url      : url
	,   dataType : data ? data : "json"
	,   data     : params
	,   success : callback
	,   error : function(xhr, status, e) {
			alert("ERROR : "+e);
	},
	complete  : function() {
	}
	});
}

// datepicker 
function calendar(ele) {
	$(ele).calendar({
		  type: 'date'
		, text: {
		      days: ['일', '월', '화', '수', '목', '금', '토'],
		      months: ['1월', '2월', '3월', '4월', '5월', '6월', '7월', '8월', '9월', '10월', '11월', '12월'],
		      monthsShort: ['1월', '2월', '3월', '4월', '5월', '6월', '7월', '8월', '9월', '10월', '11월', '12월'],
		}
		,formatter: {
	    	date: function (date, settings) {
	            if (!date) return '';
	            var day = date.getDate() + '';
	            if (day.length < 2) {
	                day = '0' + day;
	            }
	            var month = (date.getMonth() + 1) + '';
	            if (month.length < 2) {
	                month = '0' + month;
	            }
	            var year = date.getFullYear();
	            return year + '-' + month + '-' + day;
	        }
	    }
		, popupOptions: {
		      position: 'bottom left',
		      lastResort: 'bottom left',
		      prefer: 'opposite',
		      hideOnScroll: true
		}
	    ,today : true
	    ,touchReadonly : false
	    ,onChange: function (date, text, mode) {
	       var id = $(this).find("input").attr("id");
	       id = "#" + id;
	       $(id).val(text);
	       if(ele == ".datepicker") {
	    	   $(this).closest("form").submit();
	       } 
	    },
	    	  
		});
}
// colorpicker
function colorPicker(button,inputId,color) {
	var hueb = new Huebee( button, {
		  notation: 'hex',
		  saturations: 2,
		  setText : false
		});
	if(color) {
		hueb.setColor(color);
	}
	hueb.on( 'change', function( color, hue, sat, lum ) {
		$("#"+inputId).val(color);
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
	var f = $("form[name='"+name+"']");
	
	f.find("input,select,textarea").each(function(i,e){
		var name = $(e).attr("name");
		if (name) {
			if(deleteEle.indexOf(name) === -1) {
				param[name] = $(e).val();
			}
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

/*팝업 메서드  */
function popupDeny() { // true가 닫힘
	location.reload();
	return true;
}

function popupHide () {
	setTimeout(function(){
		location.reload();
	},500);
	return true;
}
/*팝업 메서드*/

/* create snackbar  <div id='id'></div> */
function snackbar(id,color,text) {
 	var x = $("#" + id + "");
	x.html(text);
	x.css("background-color",color);
	x.addClass("show");
    setTimeout(function(){ x.removeClass("show"); }, 500);
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
	var c = $("input[id='chk']:checked");
	var param = {};
	if(!chk) {
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

/* mouse hover 적용  */ 
function hoverMaster(selector, apply) {
	$("."+selector+"").hover(function() {
		  $( this ).addClass(apply);
	}
	,function() {
		  $( this ).removeClass(apply);
	}
	);
}
/* 페이지 이동 */
function moveInfo(page,param) {
	alert(page);
	console.log(param);
}
/* 공백 체크가 필요할때 */
function trim_chk(value,name,msg) {
	if(value.trim()=="") {
		$("input[name='"+name+"']").closest("div").addClass("error");
		$("input[name='"+name+"']").val("");
		$("input[name='"+name+"']").focus();
		if(msg){
			alert(msg);
		}
		return false;
	} else {
		return true;
	}
}
function dropDown(ele) {
	$(ele).dropdown({
		forceSelection: false
		,message : {
			noResults     : "검색 결과 없음"
		}
		,selectOnKeydown : false
		,fullTextSearch: true
		,match : "text"
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