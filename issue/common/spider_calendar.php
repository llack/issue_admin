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
	<div class="right aligned">
		<a class="ui tag label">menu</a>
		<a class="ui red tag label">업무관리</a>
		<a class="ui teal tag label">일정관리</a>
	</div>
		<div id="calendar" class="ui container"></div>
	</div>
</div>
</body>
<script>
$(document).ready(function(){
	
	$("#calendar").fullCalendar({
		header: {
		      left: 'prev,next today',
		      center: 'title',
		      right: ''
		    },
		buttonText : { prev :"저번달", next : "다음달"},
		//, prevYear : "작년" , nextYear : "내년"
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
		eventLimit : true
	});
	
	$('#calendar').fullCalendar('option', 'locale', 'ko');
	/*(function(){
		var calendar = $('#calendar').fullCalendar('getCalendar');
		calendar.on('dayClick', function(date, jsEvent, view) {
		});
	})();*/
});
function test(str) {
	alert(str);
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
						url : "javascript:test('"+r.seq+"')",
						color : r.color,
					});
				}
				callback(events);
			}		
		});	
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