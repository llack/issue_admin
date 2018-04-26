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
	<div class="ui left aligned">
		<button class="ui button inverted purple checkall">
		  <i class="check circle icon"></i>
		  전체선택
		</button>
		<input type="checkbox" id="checkall" style="display:none;"/>
		<button class="ui button inverted red">
		  <i class="check trash alternate icon"></i>
		  선택삭제
		</button>
		<? $cs_list = $fn->cs_list();
		$cs_list_cnt = count($cs_list);
		?>
	<form name="form" method="POST" style="margin:0px;float:right">
	<input type="hidden" value="1" name="page"/>
	<i class="search icon purple"></i>업체검색 : <?=$fn->add_nbsp(3)?>
	<select id="cs_code" name="cs_code" class="ui search dropdown" onchange="fn_submit(document.form)" style="width: 200px">
		<option value="unset">선택하세요</option>
		<?
			for($i = 0; $i < $cs_list_cnt; $i++) { 
				if($_REQUEST[cs_code]==$cs_list[$i][description]) {
					$selected = "selected";
				} else {
					$selected = "";
				}
			?>
				<option value="<?=$cs_list[$i][description]?>" <?=$selected?>><?=$cs_list[$i][title]?></option>	
		<? } ?>
	</select>
	</div>
	</form>

	<!-- 업체리스트 -->
	<table id="test" class="ui definition table fixed center aligned">
	  <thead>
		  <tr style="background-color:#a333c8;" >
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
	  	$where = ""; 
	  	if($_REQUEST[cs_code] != "" && $_REQUEST[cs_code]!="unset") {
	  		$where .= " and cs_code = '".$_REQUEST[cs_code]."' ";
	  	}
	  	$que = " select * from erp_ocsinfo where 1=1 $where order by cs_name ";
	  	$pagenator = new Paginator($que);
	  	$results = $pagenator->getData($page,$limit);
	  	$max = count($results->data);
	  	for($i = 0; $i < $max; $i++) {
	  		$row = $results->data[$i];
	  ?>
	  <tr class="tr_hover">
	  	<td>
	  		<div class="ui toggle checkbox">
			  <input type="checkbox" name="chk[]" id="chk" value="<?=$row[seq]?>">
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
$("#cs_code").dropdown({
	forceSelection: false
	,message : {
		noResults     : "검색 결과 없음"
	}
	,selectOnKeydown : false
	,fullTextSearch: true
});

function fn_submit(frm) {
	frm.submit();
}
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






