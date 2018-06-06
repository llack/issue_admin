<?
session_start();

include $_SERVER["DOCUMENT_ROOT"]."/common/header.php";
$year = ($_REQUEST[year] != "") ? $_REQUEST[year] : date("Y");
$month = ($_REQUEST[month] != "") ? $_REQUEST[month] : date("m");

$donut = workChart($year,$month);
/* chart */
foreach ($donut->year as $key=>$value) {
	$donut_year[] = "['".$key."',".$value."]";
}
foreach ($donut->month as $key=>$value) {
	$donut_month[] = "['".$key."',".$value."]";
}

/* table */
$year_key = array_keys($donut->year);
$year_max = count($donut->year);
$year_sum = array_sum($donut->year) ? array_sum($donut->year) : 1;;

$month_key = array_keys($donut->month);
$month_max = count($donut->month);
$month_sum = array_sum($donut->month) ? array_sum($donut->month) : 1;
/* table */
?>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<body>
<div class="ui container side">
<? include $_SERVER["DOCUMENT_ROOT"]."/common/company_list.php"; ?>
</div>
<!-- 메인 테이블  -->
<div class="ui container table purple segment">
	<div class="right aligned">
		<a class="ui tag label">menu</a>
		<a class="ui red tag label">업무관리</a>
		<a class="ui teal tag label">업무차트</a>
	</div>
	<h2 class="ui header" style="margin-top: 0px">
	
	<i class="circular purple chart bar outline icon"></i>
	<div class="content">업무 차트</div>
	</h2>
	<form name="form" method="POST">
	<i class="chart pie icon purple"></i>연도 검색 : <?=$fn->add_nbsp(3)?>
	
	<select id="year" name="year" class="ui search dropdown" onchange="document.form.submit()">
		<?
		for($i = init_year(); $i <= date("Y-m-d"); $i++) { 
			$selected = ($i == $year) ? "selected" : "";
			?>
				<option value="<?=$i?>" <?=$selected?>><?=$i?>년</option>	
		<? } ?>
	</select>
	
	<?=$fn->add_nbsp(3)?>
	
	<i class="chart pie icon purple"></i>월 검색 : <?=$fn->add_nbsp(3)?>
	<select id="month" name="month" class="ui search dropdown" onchange="document.form.submit()">
		<?
		for($m = 1; $m <= 12; $m++) { 
			$mon= sprintf("%02d",$m);
			$selected = ($m== $month) ? "selected" : "";
			?>
				<option value="<?=$mon?>" <?=$selected?>><?=$mon?>월</option>	
		<? } ?>
	</select>
	
	<?=$fn->add_nbsp(3)?>
	
	<button class="ui button inverted red" onclick="removeSetting(document.form,'<?=date('Y')?>','<?=date('m')?>',event)">
		  <i class="check trash alternate icon"></i>
		  설정 초기화
	</button>
	</form>
	<table class="ui celled table" style="height:78%">
		<colgroup>
			<col width="30%">
			<col width="20%">
			<col width="30%">
			<col width="20%">
		</colgroup>
		<thead>
			<tr class="center aligned">
				<th colspan="4">업체별 업무통계</th>
			</tr>
			<tr class="center aligned">
				<th colspan="2"><?=$year?>년 업무통계<?=$fn->add_nbsp(3)?>
				<i class="purple sort amount down icon"></i></th>
				
				<th colspan="2"><?=$month?>월 업무통계<?=$fn->add_nbsp(3)?>
				<i class="purple sort amount down icon"></i></th>
			</tr>
		</thead>
		<tr class="left aligned">
		<!-- 연도별 -->
			<td>
				<div id="yearDonut" style="height:100%"></div>
			</td>
			<td>
			<? 
			for($yy = 0; $yy < $year_max; $yy++) {
				$yKey = $year_key[$yy];
				$yearWork = $donut->year[$yKey];
				echo workView($yKey,$yearWork,$year_sum);
			} ?>
			<td>
		<!-- 월별 -->
				<div id="monthDonut" style="height:100%"></div>
			</td>
			<td>
			<? 
			for($mm = 0; $mm < $month_max; $mm++) {
				$mKey = $month_key[$mm];
				$monthWork = $donut->month[$mKey];
				echo workView($mKey,$monthWork,$month_sum);
			} ?>
			</td>
		</tr>
		
	</table>
</div>
</body>
</html>
<script>
$(document).ready(function(){
});
function removeSetting(frm,y,m,e) {
	e.preventDefault();
	frm.year.value = y;
	frm.month.value = m;
	frm.submit();
}
google.charts.load("current", {packages:["corechart"]});
google.charts.setOnLoadCallback(drawChart);
function drawChart() {
	var data = google.visualization.arrayToDataTable([
	  ['업체', '업무량'],
		<?
		if (is_array($donut_year)) {
			echo implode(",",$donut_year);
		} else {
			echo "['-',0]";
		}
		?>
	]);

	var options = {
	  title: '<?=$year?>년 업체별 업무',
	  pieHole: 0.4
	};

	var chart = new google.visualization.PieChart(document.getElementById('yearDonut'));
	chart.draw(data, options);
}

google.charts.load("current", {packages:["corechart"]});
google.charts.setOnLoadCallback(drawChart2);
function drawChart2() {
	var data = google.visualization.arrayToDataTable([
	  ['업체', '업무량'],
	  <?
	  if (is_array($donut_month)) {
	  	echo implode(",",$donut_month);
		} else {
			echo "['-',0]";
		}
		?>
	
	]);

	var options = {
	  title: '<?=$month?>월 업체별 업무(<?=$year?>년)',
	  pieHole: 0.4
	};

	var chart = new google.visualization.PieChart(document.getElementById('monthDonut'));
	chart.draw(data, options);
}
</script>
<? 
function init_year() {
	$que = " select left(regdate,4) as year from issue_list order by regdate LIMIT 1";
	$res = mysql_query($que) or die(mysql_error());
	$row = mysql_fetch_array($res);
	return $row[year];
}
function workChart($year,$month) {
	$que = " select * from erp_ocsinfo " ;
	$res = mysql_query($que) or die(mysql_error());
	while($row = mysql_fetch_array($res)) {
		$que_year = " select count(*) as issue from issue_list where refseq = '$row[seq]' and regdate like '$year%' ";
		$res_year= mysql_query($que_year) or die(mysql_error());
		$row_year = mysql_fetch_array($res_year);
		if($row_year[issue]!=0) {
			$list[$row[cs_name]] = $row_year[issue];
		}
		
		$que_month = " select count(*) as issue from issue_list where refseq = '$row[seq]' and regdate like '$year-$month%' ";
		$res_month= mysql_query($que_month) or die(mysql_error());
		$row_month = mysql_fetch_array($res_month);
		if($row_month[issue]!=0) {
			$list2[$row[cs_name]] = $row_month[issue];
		}
		
	}
	if($list) {
		arsort($list);
	}
	
	if($list2) {
		arsort($list2);
	}
	$return = new stdClass();
	$return->year = $list;
	$return->month = $list2;
	return $return;
}

function workView($cs_name,$work,$sum) {
	$html = "<div class='ui right pointing purple basic label'>";
	$html .= $cs_name;
	$html .= "</div>";
	$html .= "<a class='ui grey circular label'>";
	$html .= $work;
	$html .= "</a> 건 (";
	$html .= number_format(($work/ $sum) * 100,1)."%)<br/><br/>";
	return $html;
}
?>