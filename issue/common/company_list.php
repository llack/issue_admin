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
    <button class="ui button floated purple" style="width:100%">
    <i class="building outline icon "></i>업체 추가 + </button>
  <!-- /업체추가 -->
  
	<!-- 검색창 -->
  <div id="com_search" class="item ui search" style="">
    <div class="ui icon input">
    	<input class="prompt" type="text" placeholder="업체 검색">
    	<i class="search icon"></i>
    </div>
    <div class="results"></div>
  </div>
  </div>
  <!-- /검색창 -->
  
  <!-- 사이드바 업체리스트  -->
  <div style="overflow-y:auto;height:78%;">
	  
	  <a class="item active purple">
	    Spam
	    <div class="ui label  left pointing purple">51</div>
	  </a>
	  <a class="item purple">
	    Updates
	    <div class="ui label left pointing purple">1</div>
	  </a>
	  <a class="item purple">
	    Updates
	    <div class="ui label left pointing purple">1</div>
	  </a>
	  <a class="item purple">
	    Updates
	    <div class="ui label left pointing purple">1</div>
	  </a>
	  <a class="item purple">
	    Updates
	    <div class="ui label left pointing purple">1</div>
	  </a>
	  <a class="item purple">
	    Updates
	    <div class="ui label left pointing purple">1</div>
	  </a>
	  <a class="item purple">
	    Updates
	    <div class="ui label left pointing purple">1</div>
	  </a>
	  <a class="item purple">
	    Updates
	    <div class="ui label left pointing purple">1</div>
	  </a>
	  <a class="item purple">
	    Updates
	    <div class="ui label left pointing purple">1</div>
	  </a>
	  <a class="item purple">
	    Updates
	    <div class="ui label left pointing purple">1</div>
	  </a>
	  <a class="item purple">
	    Updates
	    <div class="ui label left pointing purple">1</div>
	  </a>
	  <a class="item purple">
	    Updates
	    <div class="ui label left pointing purple">1</div>
	  </a>
	  <a class="item purple">
	    Updates
	    <div class="ui label left pointing purple">1</div>
	  </a>
	  <a class="item purple">
	    Updates
	    <div class="ui label left pointing purple">1</div>
	  </a>
	  <a class="item purple">
	    Updates
	    <div class="ui label left pointing purple">1</div>
	  </a>
	  <a class="item purple">
	    Updates
	    <div class="ui label left pointing purple">1</div>
	  </a>
	  <a class="item purple">
	    Updates
	    <div class="ui label left pointing purple">1</div>
	  </a>
	  <a class="item purple">
	    Updates
	    <div class="ui label left pointing purple">1</div>
	  </a>
	  <a class="item purple">
	    Updates
	    <div class="ui label left pointing purple">1</div>
	  </a>
	  <a class="item purple">
	    Updates
	    <div class="ui label left pointing purple">1</div>
	  </a>
	  <a class="item purple">
	    Updates
	    <div class="ui label left pointing purple">1</div>
	  </a>
	  <a class="item purple">
	    Updates
	    <div class="ui label left pointing purple">1</div>
	  </a>
	  <a class="item purple">
	    Updates
	    <div class="ui label left pointing purple">1</div>
	  </a>
	  <a class="item purple">
	    Updates
	    <div class="ui label left pointing purple">1</div>
	  </a>
	  <a class="item purple">
	    Updates
	    <div class="ui label left pointing purple">1</div>
	  </a>
	  <a class="item purple">
	    마지막
	    <div class="ui label left pointing purple">1</div>
	  </a>
  </div>
  <!-- / 사이드바 업체리스트  -->
</div>
<script>
$(document).ready(function(){
	var param = {};
	ajax(param, "/common/company_search.php",search_callback);
});
function search_callback(result) {
	var company_list = [];
	company_list.push(result);
	
	$("#com_search").search({
		source : company_list[0]
		,error : {
			noResults   : "<font color='red'>검색결과 없음<font>",
			}
		,searchDelay : 0
	});
}


</script>






