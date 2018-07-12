<?
session_start();

include $_SERVER["DOCUMENT_ROOT"]."/common/header.php";
$year = ($_REQUEST[year] != "") ? $_REQUEST[year] : date("Y");
$month = ($_REQUEST[month] != "") ? $_REQUEST[month] : date("m");

$chart = workChart($year,$month);
/* chart */
foreach ($chart->year as $key=>$value) {
	$donut_year[] = "['".$key."',".$value."]";
}
foreach ($chart->month as $key=>$value) {
	$donut_month[] = "['".$key."',".$value."]";
}
@$cntYear = array_sum($chart->chart);
for($c = 0; $c < count($chart->chart); $c++) {
	$cValue = $chart->chart[$c];
	$view = ($cValue == 0) ? "null" : $cValue;
	$cAvg = number_format(($cValue / @$cntYear) *100,2);
	$view2 = ($cAvg == 0 ) ? "null" : $cAvg;
	$chartDiv[] = "['".($c+1)."월',".$cValue.",".$view.",".$cAvg.",".$view2."]";
}

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
	
	<button type="button" class="ui button inverted red" onclick="removeSetting(document.form)">
		  <i class="check trash alternate icon"></i>
		  설정 초기화
	</button>
	</form>
	<table class="ui celled table">
		<colgroup>
			<col width="50%">
			<col width="50%">
		</colgroup>
		<thead>
			<tr class="center aligned">
				<th colspan="4">업체별 업무통계</th>
			</tr>
			<tr class="center aligned">
				<th><?=$year?>년 업무통계<?=$fn->add_nbsp(3)?>
				<i class="purple sort amount down icon"></i></th>
				
				<th><?=$month?>월 업무통계<?=$fn->add_nbsp(3)?>
				<i class="purple sort amount down icon"></i></th>
			</tr>
		</thead>
		<tr class="center aligned">
		<!-- 연도별 -->
			<td>
				<div id="yearDonut" style="height:500px"></div>
			</td>
		<!-- 월별 -->
			<td>	
				<div id="monthDonut" style="height:500px"></div>
			</td>
		</tr>
		<thead>
			<tr class="center aligned" >
				<th colspan="4" style="border-top:1px solid rgba(34,36,38,.1)">월별 업무 통계</th>
			</tr>
		</thead>
		<tr>
			<td colspan="2">
				<div id="chart_div" style="height:500px"></div>
			</td>
		</tr>
	</table>
</div>
</body>
</html>
<script>
$(document).ready(function(){
});
function removeSetting(frm) {
	frm.year.value = "<?=date("Y")?>";
	frm.month.value = "<?=date("m")?>";
	frm.submit();
}
/* 년도 전체*/
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
	  pieHole: 0.4,
	  is3D : true
	};
	legendValue('yearDonut',data);
	var chart = new google.visualization.PieChart(document.getElementById('yearDonut'));
	chart.draw(data, options);
}
/* 당월 */
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
	  pieHole: 0.4,
	  is3D : true
	};
	
	legendValue('monthDonut',data);
	var chart = new google.visualization.PieChart(document.getElementById('monthDonut'));
	chart.draw(data, options);
}
/* 년도 월별 */
google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawVisualization);

      function drawVisualization() {
        // Some raw data (not necessarily accurate)
        var data = google.visualization.arrayToDataTable([
         ['월', '업무량',{type: 'number', role: 'annotation'},'점유율',{type: 'number', role:'annotation'}],
         
         <? 
			if(is_array($chartDiv)) {
				 echo implode(",",$chartDiv);
			} else {
				echo "['-',0,0]";
			}
		?>
      ]);

    var options = {
      title : '월별 업무 통계',
      vAxes: { 
		  0: { title: '업무량' },
		  1: { 
			  title: '점유율 (%)',
				gridlines: {
				  count: 6,
				  color: 'transparent'
				}
				,format : '#.#\'%\''
		  }
      },
      hAxis: {title: '월'},
      seriesType: 'bars',
      series: {
		  0: {targetAxisIndex:0,color: '#22AA99'},
		  1: {type: 'line',targetAxisIndex:1,color: '#DD4477'}
	   },//
		vAxis: { 
        viewWindow: {
            min:0
        }
		 }
    };

    var chart = new google.visualization.ComboChart(document.getElementById('chart_div'));
	var formatter = new google.visualization.NumberFormat({
			pattern: '#.#\'%\''
		});
	formatter.format(data, 3);
	formatter.format(data, 4);
    chart.draw(data, options);
  }

</script>
<? 
function init_year() { // 제일 오래된 업무 부터 검색
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
	for($i = 0; $i < 12; $i++) {
		$mon = sprintf("%02d",($i+1));
		$que_chart = " select count(*) as issue from issue_list where regdate like '$year-$mon%' ";
		$res_chart = mysql_query($que_chart) or die(mysql_error());
		$row_chart = mysql_fetch_array($res_chart);
		$chartList[] = (int)$row_chart[issue]; 
	};
	
	if($list) {
		arsort($list);
	}
	
	if($list2) {
		arsort($list2);
	}
	$return = new stdClass();
	$return->year = $list;
	$return->month = $list2;
	$return->chart = $chartList;
	return $return;
}

/*function workView($cs_name,$work,$sum) {
	$html = "<div class='ui right pointing purple basic label'>";
	$html .= $cs_name;
	$html .= "</div>";
	$html .= "<a class='ui grey circular label'>";
	$html .= $work;
	$html .= "</a> 건 (";
	$html .= number_format(($work/ $sum) * 100,1)."%)<br/><br/>";
	return $html;
}*/
?>
