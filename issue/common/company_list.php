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
   <? 
   $user_date = $_SESSION['ISSUE_DATE'];
   $que_count = " select count(*) as total, sum(state= 'Y') as yes, sum(state = 'N')+sum(state = 'G') as no, sum(state = 'Z') as pause from issue_list where end_date
					like '".$user_date."%' ";
	$res_count = mysql_query($que_count) or die(mysql_error());
	$c = mysql_fetch_array($res_count);
	$avg_issue = ( (int)$c[yes] / (int)$c[total] ) * 100;
	$avg_issue = number_format($avg_issue,1);
	?> 
   <h5 align="center" id="completeForm">
   <input type="hidden" name="hiddenDate" id="hiddenDate" value="<?=$user_date?>"/>
   <i class="ui purple caret left icon" onclick="monthChange('before')" style="cursor:pointer"></i>
   <span id="cMonth"><?=date("Y년 m",strtotime($user_date))?></span>월 완료율 
   <i class="ui purple caret right icon"  onclick="monthChange('after')" style="cursor:pointer"></i>
   <br/>( <a href="/index.php?nAll=&sdate=<?=$user_date?>-01" class="stateUrl monthTotal"><span id="cTotal"><?=number_format($c[total])?></span></a>건 )
   
   <div class="ui indicating progress" data-percent="<?=$avg_issue?>" id="progress">
	  <div class="bar">
	  	<div class="progress {{progValue}}"></div>
	  </div>
	  <div class="label"> 
		 <a href="/index.php?nAll=Y&sdate=<?=$user_date?>-01" class="ui green circular label stateUrl">완료</a><span id="cYes"><?=number_format($c[yes])?></span><?=$fn->add_nbsp(4)?>
		 <a href="/index.php?nAll=N&sdate=<?=$user_date?>-01" class="ui red circular label stateUrl">미완료</a><span id="cNo"><?=number_format($c[no])?></span><?=$fn->add_nbsp(4)?>
		 <a href="/index.php?nAll=Z&sdate=<?=$user_date?>-01" class="ui violet circular label stateUrl">보류</a><span id="cPause"><?=number_format($c[pause])?></span>
	  </div>
	</div>
	
   <i class="ui caret down inverted purple icon"></i>업체별 미완료 현황 ( <?=$fn->getNoCnt()?>건 ) 
   </h5>
  </div>
  <div class="item"></div>
  
  <!-- 사이드바 업체리스트  -->
  <div style="overflow-y:auto;height:60%;" id="_comList">
	  	<? 
	  	$cs_list = $fn->cs_list();
	  	$cnt = count($cs_list);
	  	for($i = 0; $i < $cnt; $i++ ) { 
	  		$issue = $fn->myWork($cs_list[$i][seq],"refseq");
	  		$test = ($cs_list[$i][seq] == $_REQUEST[cs_seq]) ? "active" : "";
	  	?>
	  	<a class="item <?=$test?>" href="/index.php?<?=$issue->url?>"><?=$cs_list[$i][title]?>
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
	var offset = $("#_comList").find(".active").offset().top - $("#_comList").offset().top;
	$("#_comList").animate({scrollTop : offset - $("#_comList").height()/2}, 400);
});
function monthChange(mode) {
	var d = $("#hiddenDate");
	var param = { date : d.val() , mode : mode};
	ajax(param,"/common/totalView.php",function(result){
		d.val(result.date);
		for(var key in result.text) {
			$("#"+key).text(result.text[key]);
		}
		$("#progress").progress({
			percent : result.avg
		});
		$(".stateUrl").each(function(i,e){
			var url = $(this).attr("href");
			url = url.split("&");
			$(this).prop("href",url[0] + "&sdate="+result.date+"-01");
		});
	});
}
</script>
<style>
.monthTotal,.noTotal {
	color : purple;
	text-decoration : underline;
}
.monthTotal:hover,.noTotal:hover {
	color : red;
	text-decoration : underline;
}
</style>







