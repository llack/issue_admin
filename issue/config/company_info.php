<?
session_start();

include $_SERVER["DOCUMENT_ROOT"]."/common/header.php";
include $_SERVER["DOCUMENT_ROOT"]."/common/pagination.php";
?>
<style>
#company_info {
	position: absolute;
	 width: 480px;
	 height: 480px;
	 left: 50%;
	 top: 50%;
	 margin-left: -250px;
	 margin-top: -250px;
	 border: solid #a333c8 2px;
	 border-radius: 25px;
	 padding : 1rem;
}
#cs_modify {
    visibility: hidden;
    min-width: 250px;
    margin-left: -125px;
    background-color: #333;
    color: #fff;
    text-align: center;
    border-radius: 2px;
    padding: 16px;
    position: fixed;
    z-index: 1;
    left: 50%;
    top: 30px;
    font-size: 17px;
}
#cs_modify.show {
    visibility: visible;
    -webkit-animation: fadein 0.5s, fadeout 0.5s 2.5s;
    animation: fadein 0.5s, fadeout 0.5s 2.5s;
}

@-webkit-keyframes fadein {
    from {top: 0; opacity: 0;} 
    to {top: 30px; opacity: 1;}
}

@keyframes fadein {
    from {top: 0; opacity: 0;} 
    to {top: 30px; opacity: 1;}
}

@-webkit-keyframes fadeout {
    from {top: 0; opacity: 0;} 
    to {top: 30px; opacity: 1;}
}

@keyframes fadeout {
    from {top: 0; opacity: 0;} 
    to {top: 30px; opacity: 1;}
}
</style>
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
		<button class="ui button inverted red" onclick="delete_company()">
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
	<table id="test" class="ui definition table fixed center aligned small">
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
			  <input type="checkbox" id="chk" value="<?=$row[seq]?>">
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
<!--  업체 수정 팝업 -->
<div id="company_modify"class="ui basic modal">
  <div class="content">
  	<div id="company_info">
	<div class="login header">
		<div style="text-align:right !important"><i class="user icon"></i>업 체 정 보 수 정</div>
	</div>
	<br/><br/>
	<form class="ui fluid form" name="cs_modify">
  <div class="field">
  <div class="inline field">
    <div class="ui ribbon  purple basic label">
      회사명
    </div>
    <input type="text" name="cs_name" value="" onfocus="this.setSelectionRange(this.value.length, this.value.length)" size="40">
  </div>
  <div class="inline field">
    <div class="ui ribbon purple basic label">
      회사코드
    </div>
   <input type="text" name="cs_code" value="">
  </div>
  </div>
  <input type="hidden" name="seq" value=""/>
</form>
  <!-- /  -->
</div>
  </div>
  <div class="actions">
    <div class="ui red basic cancel inverted button">
      <i class="remove icon"></i>
      취소
    </div>
    <div class="ui green ok inverted button">
      <i class="checkmark icon"></i>
      수정
    </div>
  </div>
</div>
<!-- 페이징  -->
<?=$pagenator->createLinks(); ?>
</div>
<!-- /페이징 -->
<div id="cs_modify"></div>
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

	hoverMaster("tr_hover","positive");
	enter_afterIndex("cs_modify");
});
function delete_company(seq,user_name) {
	var param = {};
	if(confirm("삭제한 업체는 복구할 수 없습니다.\n총 "+$("#chk:checked").length+"건 삭제하시겠습니까?")==true) {
		fn_delete("erp_ocsinfo","seq");
	} else {
		return;
	}
}
function fn_submit(frm) {
	frm.submit();
}
function editOrRemove(seq,mode,cs_name) {
	if(mode =="modify") {
		$('#company_modify').modal({
			//closable : false,
			onShow : function() {
				var param = {};
				param["table"] = "erp_ocsinfo";
				param["where"] = " and seq = " + seq;
				ajax(param
					,"/common/simple_select.php"
					,function(result){
						var data = result[0];
						var max = Object.keys(result[0]).length;
						for(var key in data) {
							$("input[name='"+key+"']").val(data[key]);
						}
					});
			}
			,onDeny : function() { // true가 닫힘
				location.reload();
				return true;
			}
			,onApprove : function(e) {
					if(e.hasClass('ok')) {
						var param = {};
						var data = {};
						param["param"] = jsonBot("cs_modify");
						param["table"] = "erp_ocsinfo";
						param["id"] = ["seq"];
						ajax(param
							, "/common/simple_update.php"
							,function(result){ 
							$("#cs_modify").html(result);
							$("#cs_modify").css("background-color","#54c8ff");
							snackbar("cs_modify");
						});
					}
				}
			, onHide : function () {
				setTimeout(function(){
					location.reload();
				},500);
				return true;
				}
			})
			.modal('show');
	} else {
		if(confirm("삭제한 업체는 복구할 수 없습니다.\n업체(업체명: "+cs_name+")를 삭제하시겠습니까?")==true) {
			fn_delete("erp_ocsinfo","seq",seq);
		} else {
			return;
		}	
	} 
}
</script>
</html>






