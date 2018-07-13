<?
session_start();

include $_SERVER["DOCUMENT_ROOT"]."/common/header.php";

?>
<link rel="stylesheet" href="/css/fullcalendar.min.css">
<link rel="stylesheet" href="/css/fullcalendar.print.min.css" type="text/css" media="print">
<link rel="stylesheet" href="/css/calendarCustom.css">
<script src="/js/moment.min.js"></script>
<script src="/js/fullcalendar.min.js"></script>
<script src="/js/locale-all.js"></script>
<body>
<div class="ui container side">
<? include $_SERVER["DOCUMENT_ROOT"]."/common/company_list.php"; ?>
</div>
<!-- 메인 테이블  -->
<div class="ui container table purple segment">
		<div id="calendar" class="ui container" style="padding-top: 5px"></div>
	</div>
</div>
</body>
<script>
$(document).ready(function(){
	
	$("#calendar").fullCalendar({
		customButtons: {
			saveBtn : {
				text: '뭐가있어야..',
				click : function() {
					
				}
			}
		},
		header: {
		      left: 'saveBtn',
		      center: 'title',
		      right: 'today prev,next'
		},
		buttonText : { prev :"저번달", next : "다음달"},
		views: {
		    month: {
		      titleFormat: 'YYYY년 MM월 업무달력'
		    }
		  },
		 windowResizeDelay : 0,
		 selectable: true,
		 select : selectDate,
		events: setData,
		editable : true,
		eventResize: modifyData,
		eventDrop : dropData,
		eventClick : clickData,
		eventLimit : true
	});
	
	$('#calendar').fullCalendar('option', 'locale', 'ko');
	
});
function test(str) {
	//alert(str);
}
function setData(start,end,timezone,callback) {
	ajax({},"/common/loadEvents.php",
		function(result){
			if(result) {
				var events = [];
				for(var i = 0; len = result.length, i < len ; i++) {
					var r = result[i];
					events.push({
						id : r.seq,
						title : r.memo,
						start : r.regdate,
						end : r.customEnd,
						color : r.color,
						textColor : r.fontColor,
						borderColor : r.borderColor
					});
				}
				callback(events);
			}		
		});	
}
function clickData(event) {
	var seq = event.id;
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

function modifyData(event, delta, revertFunc) {
	var end = event.end.subtract(1,'days').format();
    var param = {};
    param["color"] = (event.color) ? event.color : "";
    param["title"] = event.title;
    param["regdate"] = event.start.format();
    param["end_date"] = end;
    param["seq"] = event.id;
    console.log(param);
}

function dropData(event, delta, revertFunc) {
    var param = {};
    param["color"] = (event.color) ? event.color : "";
    param["title"] = event.title;
    param["regdate"] = event.start.format();
    param["end_date"] = (event.end) ? event.end.subtract(1,'days').format() : event.start.format();
    param["seq"] = event.id;
    console.log(param);
}
function selectDate(s,e) {
	var sdate = s.format();
	 var edate = e.subtract(1,'days').format();
	 console.log(sdate + " ~ " + edate);
	 $("#sdate").val(sdate);
	 $("#edate").val(edate);
}
</script>
</html>