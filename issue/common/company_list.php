<div class="ui vertical menu" style="width:100%;height:100%;padding:1rem">
	<!-- 사이드바 헤더 -->
	<div class="item">
		<h4 align="center">
		<div class="ui vertical mini animated button floated left inverted purple" tabindex="0" onclick="location.href='/index.php' ">
		  <div class="hidden content">HOME</div>
		  <div class="visible content">
		    <i class="home icon"></i>
		  </div>
		</div><?=$fn->add_nbsp(2)?>업체별 미완료 현황</h4>
	</div>
	<!-- /사이드바 헤더 -->
	
	<!-- 업체추가 
    <button class="ui button basic purple" style="width:100%" id="company_add_btn">
    <i class="building outline icon"></i>업체 추가 + </button>
  /업체추가 -->
  
	<!-- 검색창 -->
   <br/>
   <div class="item" >
  <div id="com_search" class="item ui search">
    <div class="ui icon input">
    	<input class="prompt search_area" type="text" placeholder="업체 업무상세 바로가기">
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
	  	for($i = 0; $i < $cnt; $i++ ) { 
	  		$issue = $fn->myWork($cs_list[$i][seq],"refseq");
	  	?>
	  	<a class="item purple" href="/index.php?<?=$issue->url?>"><?=$cs_list[$i][title]?>
	  	<? if(0 < $issue->cnt) { 
	  		$importance = ($issue->cnt>= 3) ? "red" : "green";
	  		?>
	    <div class="ui label <?=$importance?> basic left pointing"><?=$issue->cnt?></div>
	  	</a>
	  	<? }
	  	
	  	}  ?>
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






