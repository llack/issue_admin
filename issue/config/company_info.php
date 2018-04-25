<?
session_start();

include $_SERVER["DOCUMENT_ROOT"]."/common/header.php";
include $_SERVER["DOCUMENT_ROOT"]."/common/pagination.php";
?>
<body>
<div class="ui container side">
<? include $_SERVER["DOCUMENT_ROOT"]."/common/company_list.php"; ?>
</div>
<!-- 메인 테이블  -->
<div class="ui container table purple segment">
	<div class="right aligned">
		<a class="ui tag label">menu</a>
		<a class="ui red tag label">업체관리</a>
		<a class="ui teal tag label">업체현황</a>
	</div>
	<h2 class="ui header" style="margin-top: 0px">
	<i class="circular purple sitemap icon"></i>
	<div class="content">업체관리</div>
	</h2>
	<h4 class="ui header left aligned">
		<button class="ui button inverted purple checkall">
		  <i class="check circle icon"></i>
		  전체선택
		</button>
		<input type="checkbox" id="checkall" style="display:none;"/>
		<button class="ui button inverted red">
		  <i class="check trash alternate icon"></i>
		  선택삭제
		</button>
	<form name="form">
	</h4>
	</form>

	<!-- 업체리스트 -->
	<table id="test" class="ui definition table fixed center aligned">
	  <thead>
		  <tr style="background-color:#a333c8">
		    <th width="70px"><i class="large building icon" style="color:white!important"></i></th>
			<th width="70px">No.</th>
			<th>회사명</th>
		    <th>회사코드</th>
		    <th>정보1</th>
		    <th>정보2</th>
		    <th>정보3</th>
		    <th><i class="large edit icon"></i>or <i class="large ban icon"></i></th>
		  </tr>
	  </thead>
	  <tbody>
	  <?
	  	$que = " select * from erp_ocsinfo order by cs_name ";
	  	$pagenator = new Paginator($que);
	  	$results = $pagenator->getData($page,$limit);
	  	$max = count($results->data);
	  	for($i = 0; $i < $max; $i++) {
	  		$row = $results->data[$i];
	  ?>
	  <tr class="tr_mouse">
	  	<td>
	  		<div class="ui toggle checkbox">
			  <input type="checkbox" name="chk[]" id="chk">
			  <label></label>
			</div>
	  	</td>
	  	<td><a class="ui grey circular label"><?=($i+1)?></a></td>
	  	<td><?=$row[cs_name]?></td>
	  	<td><?=$row[cs_code]?></td>
	  	<td></td>
	  	<td></td>
	  	<td></td>
	  	<td>
		  	<div class="ui tiny buttons">
			  <button class="ui inverted blue button" onclick="editOrRemove('<?=$row[seq]?>','modify')">수정</button>
			  <div class="or"></div>
			  <button class="ui inverted red button" onclick="editOrRemove('<?=$row[seq]?>','delete','<?=$row[cs_name]?>')">삭제</button>
			</div>
	  	</td>
	  </tr>
	  <? } ?>
	 </tbody>
	</table>
	<!-- /업체리스트 -->
<!-- 페이징  -->
<?=$pagenator->createLinks(); ?>
</div>
<!-- /페이징 -->
</body>
<script>
$(document).ready(function(){
	$(".tr_mouse").on({
		mouseover : function(){
			$(this).addClass("positive");
		},
		mouseout : function() {
			$(this).removeClass("positive");
		}
	});

	$(".checkall").click(function(){
		var a = $("#checkall");
		var c = $("input[id='chk']");
		var str = "";
		if(a.prop("checked")===false) {
			a.prop("checked",true);
			c.prop("checked",true);
			str = "선택해제";			
		} else {
			a.prop("checked",false);
			c.prop("checked",false);
			str = "전체선택";
		}
		$(this).html("<i class='check circle icon'></i>"+str);
	});  
	
});

function editOrRemove(seq,mode,cs_name) {
	if(mode =="modify") {

	} else {
		if(confirm("삭제한 업체는 복구할 수 없습니다.\n업체(업체명: "+cs_name+")를 삭제하시겠습니까?")==true) {
			
		} else {
			return;
		}	
	} 
}
</script>
</html>






