<?
session_start();
if($_SESSION["USER_NAME"]=="") {
	header("Location:/common/login.php");
}
if($_SESSION["USER_LEVEL"]!="A") {
	echo "<script>alert('권한이 없습니다.');
		history.back();
		</script>";
}
include $_SERVER["DOCUMENT_ROOT"]."/common/header.php";
include $_SERVER["DOCUMENT_ROOT"]."/common/pagination.php";

$_REQUEST[auth] = ($_REQUEST[auth]!="")? $fn->param_to_array2($_REQUEST[auth]) : $fn->param_to_array2("전체_blue");
?>
<link rel="stylesheet" href="/css/snackbar.css">
<body>
<div class="ui container side" >
<? include $_SERVER["DOCUMENT_ROOT"]."/common/company_list.php"; ?>
</div>
<!-- card container start -->
<div class="ui container table purple segment" style="overflow-x:hidden">
<div class="right aligned" >
	<a class="ui tag label">menu</a>
	<a class="ui red tag label">사원관리</a>
	<a class="ui teal tag label">사원 권한관리</a>
</div>
<h2 class="ui header" style="margin-top: 0px;margin-bottom:0px">

<i class="circular purple id card outline icon"></i>
<div class="content">사원 권한관리</div>
</h2>
<form name="form" method="POST">
<input type="hidden" name="page" value="1"/>
<div class="ui center aligned" style="padding-left:0.5%">
<!-- 등급별 검색 -->
<div id="user_search" class="ui floating labeled icon dropdown button basic" onchange="fn_submit(document.form)">
<!-- <div class="ui sub header center aligned">권한등급</div>  -->
  <input type="hidden" name="auth" value="<?=$_REQUEST[auth][0]."_".$_REQUEST[auth][1]?>">
  <i class="filter purple icon"></i>
  
  <span class="text"> 
  <div class="ui <?=$_REQUEST[auth][1]?> empty circular label"></div><?=$_REQUEST[auth][0]?>
  </span>
  
  <div class="menu">
    <div class="header">
      <i class="tags icon"></i>
      Filter by tag
    </div>
    <div class="divider"></div>
    <div class="item" data-value="전체_blue">
      <div class="ui blue empty circular label"></div>
	전체
    </div>
    <div class="item" data-value="A_purple">
      <div class="ui purple empty circular label"></div>
      A
    </div>
    <div class="item" data-value="U_grey">
      <div class="ui grey empty circular label"></div>
      U
    </div>
    <div class="item" data-value="승인_green">
      <div class="ui green empty circular label"></div>
	승인
    </div>
    <div class="item" data-value="미승인_red">
      <div class="ui red empty circular label"></div>
	미승인
    </div>
  </div>
</div><?=$fn->add_nbsp(3)?>
<!-- /등급별 검색 -->
<!-- 유저 이름 검색  -->
   <?
   $user_list = $fn->userInfo();
   $user_list_cnt = count($user_list);
   ?>
<i class="user icon purple"></i>사원검색 : <?=$fn->add_nbsp(3)?>
<select id="user_name" name="user" class="ui search dropdown" onchange="fn_submit(document.form)" style="width: 200px">
	<option value="unset">선택하세요</option>
	<?
		for($i = 0; $i < $user_list_cnt; $i++) { 
			if($_REQUEST[user]==$user_list[$i][seq]) {
				$selected = "selected";
			} else {
				$selected = "";
			}
		?>
			<option value="<?=$user_list[$i][seq]?>" <?=$selected?>><?=$user_list[$i][user_name]?></option>	
	<? } ?>
</select>
<!-- /유저 이름 검색  -->
</div>
</form>
<br/><br/>
<!-- card start -->
<div class="ui cards" style="padding-left:0.5%">
  <? 
  	$where = "";
  	if($_REQUEST[auth][0]!="" && $_REQUEST[auth][0]!="전체") {
  		$where .= " and user_level = '".$_REQUEST[auth][0]."' ";
  		if($_REQUEST[auth][0]=="미승인") {
  			$where = " and user_level = '' ";
  		} elseif($_REQUEST[auth][0]=="승인") {
  			$where = " and user_level <> '' ";
  		}
  	}
  	if($_REQUEST[user]!="" && $_REQUEST[user]!="unset") {
  		$where .= " and seq = '".$_REQUEST[user]."' ";
  	}
  	$que_user = " select * from member where 1=1 $where order by user_level desc ";
  	
  	$pagenator = new Paginator($que_user);
  	$results = $pagenator->getData($page,$limit);
  	
  	$max_result = count($results->data);
  	
  	for($loop = 0; $loop < $max_result; $loop++) {
  		$row_user = $results->data[$loop];
  		if($row_user[user_level]=="A") {
  			$level_color = "purple";
  		} else {
  			$level_color = "";
  		}
  ?>
  <div class="card card_content">
    <div class="content">
      <div id="delete_user" onclick="delete_user('<?=$row_user[seq]?>','<?=$row_user[user_name]?>')" data-tooltip="X" data-position="right center" data-inverted="">
	      <div class="right floated" >
	      	<i class="close red icon" style="cursor:pointer"></i>
	      </div>
      </div>
      <div class="header">
		<?=$row_user[user_name]?>
		<? if($row_user[user_level]!="") {?>
      	<button class="ui circular <?=$level_color?> icon button">
		  <i class="icon"><?=$row_user[user_level]?></i>
		</button>
		<? } ?>
      </div>
      <div class="meta">
		<?=$row_user[position]?>
      </div>
      <div class="description">
	      <div onclick="fn_copy('<?=$row_user[user_id]?>_email')"data-tooltip="복사" data-position="right center" style="float:left;padding:0px;cursor:pointer" data-inverted="">
	      <i class="envelope outline icon purple"></i>
	       <input type="text" value="<?=$row_user[user_email]?>" style="border:none;height:20px;cursor:pointer" id="<?=$row_user[user_id]?>_email" readonly/>
	       </div>
      </div>
       <div class="description">
	       <div onclick="fn_copy('<?=$row_user[user_id]?>_hp')"data-tooltip="복사" data-position="right center" style="float:left;padding:0px;cursor:pointer" data-inverted="">
	        <i class="phone icon purple"></i>
	        <input type="text" value="<?=$row_user[hp]?>" style="border:none;height:20px;cursor:pointer" id="<?=$row_user[user_id]?>_hp" readonly/>
	        </div>
      </div>
    </div>
    <div class="extra content">
      <div class="ui three buttons">
      <? 
      	if($row_user[user_level] != "") {
      		$approve = "";
      		$deny = "basic";
      	} else {
      		$approve = "basic";
      		$deny = "";
      	}
      ?>
        <div class="ui <?=$approve?> green button" onclick="fn_auth('approve','<?=$approve?>','<?=$row_user[seq]?>')">승인</div>
        <div class="ui <?=$deny?> red button" onclick="fn_auth('deny','<?=$deny?>','<?=$row_user[seq]?>')">미승인</div>
        <div class="ui basic grey button auth_popup">권한</div>
		<!-- 권한팝업 -->
        <div class="ui flowing popup top left transition hidden auth_popup_target" style="width:300px">
        	<h4 class="ui header">현재 권한 : <?=$row_user[user_level] = ($row_user[user_level]!="") ? $row_user[user_level] : "없음"?></h4>
        	<? if($row_user[user_level]=="A") {
			        $admin = "inverted purple";
			        $user = "basic grey";
        	} elseif($row_user[user_level]=="U") {
        			$admin = "basic grey";
        			$user = "inverted purple";
        	} else {
        		$admin = "basic grey";
        		$user = "basic grey";
        	}
        	?>
		  <div class="ui two column divided center aligned grid">
		    <div class="column">
		      <div class="ui <?=$admin?> button" onclick="fn_auth_change('<?=$row_user[user_level]?>','A','<?=$row_user[seq]?>')">관리자</div>
		    </div>
		    <div class="column">
		      <div class="ui <?=$user?> button" onclick="fn_auth_change('<?=$row_user[user_level]?>','U','<?=$row_user[seq]?>')">유저</div>
		    </div>
		  </div>
		</div>
		<!-- /권한팝업 -->
      </div>
    </div>
  </div>
  <? } 
  if($max_result==0) { ?>
	<br/>
	<h2 class="ui icon header center aligned">
  <i class="ban red icon"></i>
  <div class="content">
    검색결과 없음!
    <div class="sub header">검색 조건을 확인해주세요</div>
  </div>
</h2>
	<? } ?>
  <!-- /card end  -->
</div>
<br/>
<!-- 페이징  -->
<?=$pagenator->createLinks(); ?>
</div>
<!-- /페이징 -->
<div id="snackbar"></div>
<!-- /<!-- card container end -->
</div>
</body>
<script>

$(document).ready(function(){
	$('.auth_popup').popup({
	    popup: '.auth_popup_target',
	    on : 'click'
	  });
	$("#user_search").dropdown();
	$("#user_name").dropdown({
		forceSelection: false
		,message : {
			noResults     : "검색 결과 없음"
		}
		,selectOnKeydown : false
		,fullTextSearch: true
	});

	$(".card_content").on({
		mouseover : function() {
			$(this).addClass("purple segment");
		},
		mouseout : function() {
			$(this).removeClass("purple segment");
		}
	})
});
function fn_submit(frm) {
	frm.submit();
}
function fn_auth(mode,auth,seq) {
	var param = {};
	if(mode=="approve") {
		if(auth=="") {
			return;
		} else {
			param["mode"] = "approve";
			param["seq"] = seq;
			ajax(param,"employee_auth_ok.php",auth_result);
		}
	} else {
		if(auth=="") {
			return;
		} else {
			param["mode"] = "deny";
			param["seq"] = seq;
			ajax(param,"employee_auth_ok.php",auth_result);
		}
	}
}
function fn_auth_change(mAuth, cAuth, seq) {
	var param = {};
	if(mAuth=="없음") {
		$("#snackbar").html("승인되지 않은 사원입니다.");
		snackbar("snackbar");
		return;
	} else if(mAuth==cAuth){
		return;
	} else {
		param["mode"] = "modify";
		param["user_level"] = cAuth;
		param["seq"] = seq;
		ajax(param, "employee_auth_ok.php",auth_result);
	}
}
function delete_user(seq,user_name) {
	var param = {};
	if(confirm("삭제한 사원은 복구할 수 없습니다.\n사원(사원명 : "+user_name+")을 삭제하시겠습니까?")==true) {
		fn_delete("member","seq",seq);
	} else {
		return;
	}
}
/* CALLBACK METHOD */ 

function auth_result(result) {
	var str = "";
	if(result=="approve") {
		str = "승인 되었습니다.";
		$("#snackbar").css("background-color","#21ba45");
	} else if(result=="deny"){
		str = "미승인 되었습니다.";
		$("#snackbar").css("background-color","#db2828");
	} else {
		str = "권한이 변경되었습니다.";
		$("#snackbar").css("background-color","grey");
	}
	$("#snackbar").html(str);
	snackbar("snackbar");
	setTimeout(function(){
		location.reload();
	},500);
}

/* == CALLBACK METHOD  == */

</script>
</html>







