<?
session_start();

include $_SERVER["DOCUMENT_ROOT"]."/common/header.php";

$link = $fn->auto_link("cs_code","sdate","edate");
?>
<body>
<div class="ui container side">
<? include $_SERVER["DOCUMENT_ROOT"]."/common/company_list.php"; ?>
</div>
<!-- 메인 테이블  -->
<div class="ui container table purple segment">
	<div class="right aligned">
		<a class="ui tag label">menu</a>
		<a class="ui red tag label">업무관리</a>
		<a class="ui teal tag label">업무현황</a>
	</div>
	<h2 class="ui header" style="margin-top: 0px">
	
	<i class="circular purple tags icon "></i>
	<div class="content">업무현황</div>
	</h2>
	<div class="ui left aligned">
		<button class="ui button inverted purple checkall">
		  <i class="check circle icon"></i>
		  전체선택
		</button>
		<input type="checkbox" id="checkall" style="display:none;"/>
		<button class="ui button inverted red" onclick="delete_issue()">
		  <i class="check trash alternate icon"></i>
		  선택삭제
		</button>
		<? $cs_list = $fn->cs_list();
		$cs_list_cnt = count($cs_list);
		?>
	<form name="form" method="POST" style="margin:0px;float:right;padding-right:150px">
	<input type="hidden" value="1" name="page"/>
	<i class="search icon purple"></i>업체 검색 : <?=$fn->add_nbsp(3)?>
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
	<!-- 일정검색 -->
	<?=$fn->add_nbsp(3)?>
	<i class="calendar alternate outline icon purple"></i>일정 검색 : <?=$fn->add_nbsp(3)?>
	<div class="ui form"style="float: right">
	  <div class="fields">
	    <div class="field">
	       <div class="ui calendar datepicker">
		    <div class="ui input left icon">
		      <i class="calendar alternate outline icon"></i>
		      <input type="text" value="<?=$sdate?>" name="sdate">
		    </div>
		  </div>
	    </div>
	    <?=$fn->add_nbsp(2)?>~<?=$fn->add_nbsp(2)?>
	    <div class="field">
	      <div class="ui calendar datepicker">
		    <div class="ui input left icon">
		      <i class="calendar alternate outline icon"></i>
		      <input type="text" value="<?=$edate?>" name="edate">
		    </div>
		  </div>
		</div>
	    </div>
	  </div>
	  <!-- /일정검색 -->
	</div>
	</form>
	
	<table id="test" class="ui definition table fixed center aligned small">
	 <thead>
		  <tr style="background-color:#a333c8;" >
		    <th width="70px"><i class="large briefcase icon" style="color:white!important"></i></th>
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
	  <tr class="tr_hover">
	  	<td>
	  		<div class="ui toggle checkbox">
			  <input type="checkbox" id="chk" value="<?=$row[seq]?>">
			  <label></label>
			</div>
	  	</td>
	  	<td><a class="ui grey circular label">dd</a></td>
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
	  </tbody>
	</table>
	</div>
	
</body>
<script>
$(document).ready(function(){

	$("#cs_code").dropdown({
		forceSelection: false
		,message : {
			noResults     : "검색 결과 없음"
		}
		,selectOnKeydown : false
		,fullTextSearch: true
	});
})
function fn_submit(frm) {
	frm.submit();
}

function delete_issue() {
	alert(1);
}
</script>
</html>