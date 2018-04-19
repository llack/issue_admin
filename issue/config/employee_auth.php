<?
session_start();
if($_SESSION["USER_NAME"]=="") {
	header("Location:/common/login.php");
}
if($_SESSION["USER_ID"]!="admin") {
	echo "<script>alert('권한이 없습니다.');
		history.back();
		</script>";
}
	
include $_SERVER["DOCUMENT_ROOT"]."/common/header.php";

?>
<link rel="stylesheet" href="/css/snackbar.css">
<body>
<div class="ui container side ">
<? include $_SERVER["DOCUMENT_ROOT"]."/common/company_list.php"; ?>
</div>
<!-- card container start -->
<div class="ui container table purple segment">
<div class="right aligned">
	<a class="ui tag label">menu</a>
	<a class="ui red tag label">사원관리</a>
	<a class="ui teal tag label">사원 권한관리</a>
</div>
<h2 class="ui header" style="margin-top: 0px">

<i class="circular purple users icon icon"></i>
<div class="content">사원 권한관리</div>
</h2>
<form name="form">
<h4 class="ui header center aligned">
음.. 이부분은 뭘로 해야될지 모르겠네~
</h4>
</form>
<!-- card start -->
<div class="ui cards" style="padding-left:7%">
  <? 
  	$que_user = " select * from member order by user_level desc";
  	$res_user = mysql_query($que_user) or die(mysql_error());
  	while($row_user = mysql_fetch_array($res_user)) {
  		if($row_user[user_level]=="A") {
  			$level_color = "purple";
  		} else {
  			$level_color = "";
  		}
  ?>
  <div class="card">
    <div class="content">
      <div class="right floated" onclick="delete_user('<?=$row_user[seq]?>')"><i class="close red icon" style="cursor:pointer"></i></div>
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
      </div><br/>
      <div class="description">
      <i class="envelope outline icon purple"></i>
       <?=$row_user[user_email]?>
      </div>
       <div class="description">
        <i class="phone icon purple"></i>
        <?=$row_user[hp]?>
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
  <? } ?>
  <!-- /card end  -->
</div>
<div id="snackbar">Some text some message..</div>
<!-- /<!-- card container end -->
</div>
</body>
<script>
$(document).ready(function(){
	$('.auth_popup')
	  .popup({
	    popup: '.auth_popup_target',
	    on : 'click'
	  })
	;
});

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
		myFunction();
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
function delete_user(seq) {
	var param = {};
	if(confirm("삭제한 사원은 복구할 수 없습니다.\n삭제하시겠습니까?")==true) {
		param["mode"] = "delete";
		param["seq"] = seq;
		ajax(param
			,	"employee_delete.php"
			,	function(result){ 
			alert(result); 
			location.reload();
			});
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
	myFunction();
	setTimeout(function(){
		location.reload();
	},500);
}

/* == CALLBACK METHOD  == */
function myFunction() {
    var x = document.getElementById("snackbar");
    x.className = "show";
    setTimeout(function(){ x.className = x.className.replace("show", ""); }, 500);
}
</script>
</html>







