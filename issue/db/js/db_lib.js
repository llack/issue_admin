function ajax(params, url, callback, data, method){
	$.ajax({
		type : method ? method:"POST"
	,   url      : url
	,   dataType : data ? data : "json"
	,   data     : params
	,   success : callback
	,   error : function(xhr, status, e) {
			console.log("ERROR : "+e);
	},
	complete  : function() {
	}
	});
}
function initDb(db,table) {
	setter("database",db);
	setter("table",table);
	var param = { db : db , table : table };
	ajax(param, "/db/mod/tableInfo.php",function(result){
		$("#contents").html(result.contents).scrollTop(0).scrollLeft(0);
		$("#resizeBar,#tabList").show();
		if(getter('tabMode') === null) {
			setter('tabMode','contents');
			$("button.contents").addClass('active');
		}
		if(result.tableSelect) {
			$("#mainTable").html(result.tableSelect).scrollTop(0).scrollLeft(0);
			$(".longtext").tooltip({
		      position: {
		        my: "center bottom-20",
		        at: "center top",
		        using: function( position, feedback ) {
		          $( this ).css( position );
		          $("<div>").addClass( "arrow" ).addClass( feedback.vertical ).addClass( feedback.horizontal ).appendTo( this );
		        }
		      }
		    });
		}
	});
}
function initTree(ele) {
	var e = $(ele);
	e.removeClass('mtree-closed').addClass('mtree-open block');
	e.find("ul").css({height : 'auto', display : 'block'});

	var table = "#d_"+getter("database")+"_t_"+getter("table");
	e.find(table).addClass("mtree-active");
	
	var offset = $(table).offset().top;
	$(".dbContainer").animate({scrollTop : offset - $(".dbContainer").height()/2}, 400);
}
function getter(key) {
	return sessionStorage.getItem(key);
}

function setter(key,value) {
	sessionStorage.setItem(key,value);
}
function tabMode(mode) {
    $(".tabcontent").hide();
    $(".tablinks").removeClass("active");
    $("#"+mode).show();
    $("."+mode).addClass("active");
    setter('tabMode', mode);
}