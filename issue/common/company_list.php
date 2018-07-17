<div class="ui vertical menu" style="width:100%;height:100%;padding:1rem">
	<!-- 사이드바 헤더 -->
	<div class="item">
		<h4 align="center">
		<div class="ui vertical fluid animated button floated left inverted purple" tabindex="0" onclick="location.href='/' ">
		  <div class="hidden content"><i class="home icon"></i></div>
		  <div class="visible content">
		    <img src="/img/profile.png" width="100%"></img>
		  </div>
		</div></h4>
	</div>
   <div class="item" >
   <h4 align="center">
   <? $que_count = " select count(*) as total, sum(state= 'Y') as yes, sum(state = 'N') as no, sum(state = 'Z') as pause from issue_list where regdate
					like '".date("Y")."-".date("m")."%' ";
	$res_count = mysql_query($que_count) or die(mysql_error());
	$row_count = mysql_fetch_array($res_count);
	$c = $row_count;
	$avg_issue = ( (int)$c[yes] / (int)$c[total] ) * 100;
	$avg_issue = number_format($avg_issue,1);
	?> 
   <?=date("Y")?>년 <?=date("m")?>월 완료율 (총 : <?=number_format($c[total])?>건)
   <div class="ui indicating progress" data-percent="<?=$avg_issue?>" date-value="<?=$avg_issue?>"id="progress">
	  <div class="bar"><div class="progress {{progValue}}"></div></div>
	  <div class="label"> 완료 : <?=number_format($c[yes])?>, 미완료 : <?=number_format($c[no])?>, 보류: <?=number_format($c[pause])?></div>
	</div>
   <i class="ui caret down inverted purple icon"></i>업체별 미완료 현황</h4>
  </div>
  <div class="item" ></div>
  
  <!-- 사이드바 업체리스트  -->
  <div style="overflow-y:auto;height:75%;">
	  	<? 
	  	$cs_list = $fn->cs_list();
	  	$cnt = count($cs_list);
	  	for($i = 0; $i < $cnt; $i++ ) { 
	  		$issue = $fn->myWork($cs_list[$i][seq],"refseq");
	  	?>
	  	<a class="item purple" href="/index.php?<?=$issue->url?>"><?=$cs_list[$i][title]?>
	  	<? if(0 < $issue->cnt) { 
	  		$importance = ($issue->cnt>= 3) ? "red" : "green";
	  		?>
	    <div class="ui label <?=$importance?> basic left pointing"><?=$issue->cnt?></div>
	  	<? } ?>
	  	</a>
	  	<? } ?>
  </div>
  <!-- / 사이드바 업체리스트  -->
</div>
<script>
$(document).ready(function(){
	$("#progress").progress({
		text : {
			percent : '{percent}%'
		}
	});
});

</script>






