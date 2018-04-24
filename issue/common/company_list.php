<div class="ui vertical menu" style="width:100%;height:100%;padding:1rem">
	<!-- 사이드바 헤더 -->
	<div class="item">
		<h4 align="center">
		<div class="ui vertical mini animated button floated left purple" tabindex="0" onclick="location.href='/' ">
		  <div class="hidden content">HOME</div>
		  <div class="visible content">
		    <i class="home icon"></i>
		  </div>
		</div>업체별 미완료 현황</h4>
	</div>
	<!-- /사이드바 헤더 -->
	
	<!-- 업체추가  -->
   <div class="item" >
    <button class="ui button basic purple" style="width:100%" id="company_add_btn">
    <i class="building outline icon"></i>업체 추가 + </button>
  <!-- /업체추가 -->
  
	<!-- 검색창 -->
  <div id="com_search" class="item ui search">
    <div class="ui icon input">
    	<input class="prompt search_area" type="text" placeholder="업체 검색">
    	<i class="search icon"></i>
    </div>
    <div class="results"></div>
  </div>
  </div>
  <!-- /검색창 -->
  
  <!-- 사이드바 업체리스트  -->
  <div style="overflow-y:auto;height:78%;">
	  	<? 
	  	$cs_list = $fn->cs_list();
	  	$cnt = count($cs_list);
	  	$issue = 6;
	  	for($i = 0; $i < $cnt; $i++ ) { ?>
	  	<a class="item purple" href="/">
	  	<?=$cs_list[$i][title]?>
	  	<? if(0 < $issue) { 
	  		if(3 <= $issue) {
	  			$importance = "red";
	  		} else {
	  			$importance = "green";
	  		}
	  		?>
	    <div class="ui label <?=$importance?> basic left pointing"><?=$issue?></div>
	  	</a>
	  	<? } ?>
	  	<? $issue--;}  ?>
  </div>
  <!-- / 사이드바 업체리스트  -->
</div>
<script>
$(document).ready(function(){
	$(".search_area").on("keyup",function(){
		if($(this).val()!="") {
			$("#com_search").addClass("loading");
		}	
	});
	
	$("#company_add_btn").on({
		mouseenter : function() {
			$(this).removeClass("basic");
		}
		,mouseleave : function() {
			$(this).addClass("basic");
		}
	});
	
	$("#com_search").search({
		source : <?=json_encode($cs_list)?>
		,error : {
			noResults   : "<font color='red'>검색결과 없음<font>",
			}
		,searchDelay : 300
		,onResultsClose : function() {
			$("#com_search").removeClass("loading");;
		}
		,selectFirstResult : true
	});
});

</script>






