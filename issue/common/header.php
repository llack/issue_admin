<? 
session_start();
if($_SESSION["USER_NAME"]=="") {
	header("Location:/common/login.php");
}
header ("Content-Type: text/html; charset=UTF-8");		#다국어지원을 위한 설정

include_once($_SERVER["DOCUMENT_ROOT"]."/conf/config.db.conn.php");//디비연결
include $_SERVER["DOCUMENT_ROOT"]."/lib/nawoo.php";
include $_SERVER["DOCUMENT_ROOT"]."/common/pagination.php";

$limit = ($_REQUEST['limit']!="") ? $_REQUEST['limit'] : 10;
$page = ($_REQUEST['page']!="") ? $_REQUEST['page'] : 1;
$sdate = ($_REQUEST[sdate]!="") ? $_REQUEST[sdate] : date("Y-m") . "-01";
$edate = ($_REQUEST[edate]!="") ? $_REQUEST[edate] : date("Y-m-t",strtotime($sdate));
$fn = new Json_select();
?>
<!DOCTYPE>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta charset="UTF-8">
<link rel="icon" href="/img/spider_web.jpg" type="image/x-icon" />

<link rel="stylesheet" href="/css/semantic.min.css">
<link rel="stylesheet" href="/css/datatables.min.css">
<link rel="stylesheet" href="/css/calendar.min.css">
<script src="/js/jquery-3.2.1.js"></script>
<script src="/js/nawoo.js"></script> 
<script src="/js/semantic.min.js"></script>
<script src="/js/calendar.min.js"></script>
<script src="/js/datatables.min.js"></script>
<script src="/js/docs.js"></script>
<title><?=TITLE?></title>
</head>
<style>
body {
	padding : 1rem;
}
.ui.container.side {
	width:17%;
	height:94%;
	overflow:hidden;
	float:left;
}
.ui.container.table {
	width: 83%;
	height:94%;
	overflow-y:auto;
	padding:1rem;
	border-bottom : 2px solid #a333c8!important;
}
#com_search {
	padding-right:0px;
	padding-left:0px;
}
.nowPage {
	background : white !important;
	color : purple !important;
	border : 2px solid;
}
.pagination a:hover:not(.nowPage){
	background : white !important;
	color : purple !important;
}
</style>
<script>
$(document).ready(function(){
	$('.datepicker').calendar({
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
       var name = $(this).find("input").attr("name");
       $("input[name='"+name+"']").val(text);
		$(this).closest("form").submit();
    },
    	  
	});
});
</script>
<? include $_SERVER['DOCUMENT_ROOT']."/common/menu.php";?>

