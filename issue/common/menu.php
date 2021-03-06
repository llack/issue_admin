<?
$user = $fn->userInfo($_SESSION["USER_ID"]);
$row_info = $user[0];
$myWork = $fn->myWork($_SESSION["USER_ID"]);
?>

<style>
#login_form2 {
	position: absolute;
	 width: 470px;
	 height: 480px;
	 left: 50%;
	 top: 50%;
	 margin-left: -250px;
	 margin-top: -250px;
	 border: solid #a333c8 2px;
	 border-radius: 25px;
	 padding : 1rem;
} 
#modify_result {
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

#modify_result.show {
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
<div id="topmenu" class="ui menu item four">
  <a class="browse item">
    업무관리
    <i class="dropdown icon"></i>
  </a>
  <a class="browse item">
    업체관리
    <i class="dropdown icon"></i>
  </a>
  <a class="browse item">
    사원관리
    <i class="dropdown icon"></i>
  </a>
  <a class="browse item">
    내정보
    <i class="dropdown icon"></i>
  </a>
</div>
<div class="ui fluid popup bottom left transition hidden">
  <div class="ui four column relaxed equal height divided grid">
    <div class="column" align="center">
      <h4 class="ui header">업무</h4>
      <div class="ui link list">
        <a class="item" href="/index.php">업무현황</a>
        <a class="item" href="/issue/issue_chart.php">업무차트</a>
        <a class="item" href="/common/spider_calendar.php">업무달력</a>
      </div>
    </div>
    <div class="column" align="center">
      <h4 class="ui header">업체</h4>
      <div class="ui link list">
        <a class="item" href="/config/company_info.php">업체관리</a>
      </div>
    </div>
    <div class="column" align="center">
      <h4 class="ui header">사원</h4>
      <div class="ui link list">
        <a class="item" href="/config/employee_auth.php">권한관리 (관리자)</a>
        <a class="item" href="/config/company_tree.php">조직도</a>
      </div>
    </div>
    <div class="column"> <!-- 내정보 -->
		<div class="ui purple basic label">성명</div> <?=$row_info[user_name]?> 
		<div class="ui purple basic label">직책</div> <?=$row_info[position]?><br/><br/>
		<div id="copy_clip" onclick="fn_copy('user_phone')"data-tooltip="클립보드로 복사하기" data-position="left center" style="float:left;padding:0px">
		<i class="inverted phone big icon purple"></i>
		</div>
		<input type="text" value="<?=$row_info[hp]?>" style="border:none;height:30px" id="user_phone" readonly/>
		<br/>
		<div onclick="fn_copy('user_email')"data-tooltip="클립보드로 복사하기" data-position="left center" style="float:left;padding:0px">
		<i class="inverted purple big copy outline icon"></i>
		</div>
		E-mail : <input type="text" value="<?=$row_info[user_email]?>" style="border:none;height:30px" id="user_email" readonly/>
		<br/><br/>
		<a href="/index.php?<?=$myWork->url?>">미완료 업무 : <?=$myWork->cnt?>건</a>
		<button class="negative ui small button right floated" onclick="logout()"><i class="share square outline icon"></i>로그아웃</button>
		<button class="purple ui small button right floated" onclick="modify_userInfo()"><i class="user icon"></i>정보수정</button>
    </div> <!-- /내정보 -->
  </div>
</div>

<!-- 정보 수정 modal --> 
<div id="modify_userInfo" class="ui basic modal">
  <div class="content">
  	<div id="login_form2">
	<div class="login header">
		<div style="text-align:right !important"><i class="user icon"></i>내 정 보 수 정</div>
	</div>
	<br/><br/>
	<form class="ui fluid form" name="user_info">
	<input type="hidden" name="user_id" value="<?=$row_info[user_id]?>"/>
  <div class="field">
  <div class="inline field">
    <div class="ui ribbon  purple basic label">
      이름
    </div>
    <input type="text" name="user_name"onfocus="this.setSelectionRange(this.value.length, this.value.length)">
  </div>
  <div class="inline field">
    <div class="ui ribbon purple basic label">
      아이디
    </div>
    <?=$row_info[user_id]?>
  </div>
  <div class="inline field">
    <div class="ui ribbon purple basic label">
      	비밀번호
    </div>
    <input type="password" name="user_pw" autocomplete="off">
  </div>
  <div class="inline field">
    <div class="ui ribbon purple basic label">
      	비밀번호확인
    </div>
    <input type="password" name="user_pwd2" autocomplete="off">
  </div>
  <div class="inline field">
    <div class="ui ribbon purple basic label">
      	직책
    </div>
    <input type="text" name="position">
  </div>
  <div class="inline field">
    <div class="ui ribbon purple basic label">
      	이메일
    </div>
    <input type="text" name="user_email" size="30">
  </div>
  <div class="inline field">
    <div class="ui ribbon purple basic label">
      	전화번호
    </div>
    <input type="text" name="hp">
  </div>
  </div>
  <input type="hidden" name="no"/>
</form>
  <!-- /  -->
</div>
  </div>
  <div class="actions" style="width:935px">
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
<!-- / 정보 수정 modal  -->
<div id="modify_result"></div>
<script>
$(document).ready(function(){
	
	enter_afterIndex("user_info");
	
	$('#topmenu').popup({
		inline   : true,
		hoverable: true,
		position : 'bottom center',
		lastResort : 'bottom center',
		delay: {
		  show: 50,
		  hide: 50
		 }
	});
	$("[name='user_pwd2']").keyup(function(e){ 
		$(this).closest("div").removeClass("error"); 
	});
});

function modify_userInfo() {
	$('#topmenu').popup('hide');
	$('#modify_userInfo').modal({
		//closable : false,
		onShow : myInfo("<?=$_SESSION["USER_ID"]?>"),
		onDeny : popupDeny
		,onApprove : function(e) {
				if(e.hasClass('ok')) {
					return sign_submit(document.user_info);
				}
			}
		, onHide : popupDeny
		})
		.modal('show');
}
function myInfo(id) {
	var param = {};
	param["table"] = "member";
	param["where"] = " and user_id = '" + id + "'";
	ajax(param,"/common/simple_select.php",function(result){
		var data = result[0];
		var form = $("form[name='user_info']");
		for(var key in data) {
			form.find("[name='"+key+"']").val(data[key]);
		}
	});
	$("[name='user_pwd2']").val("").closest("div").removeClass("error");
}

function sign_submit(frm) {
	
	if(!trim_chk(frm.user_name.value,"user_name","이름을 입력해주세요")){
		return false;
	}
	
	if(!trim_chk(frm.user_pw.value,"user_pw","비밀번호를 입력해주세요")){
		return false;
	}

	if(!trim_chk(frm.user_pwd2.value,"user_pwd2","비밀번호확인을 입력해주세요")){
		return false;
	}
	
	if(frm.user_pw.value.trim() != frm.user_pwd2.value.trim()){
		alert("비밀번호가 일치하지 않습니다");
		var pwd2 = $("input[name='user_pwd2']");
		pwd2.val("").closest("div").addClass("error");
		pwd2.focus();
		return false;
	}
	var param = {};
	param["param"] = jsonBot("user_info",["user_pwd2"]);
	param["table"] = "member";
	param["id"] = ["no","user_id"];
	ajax(param, "/common/simple_update.php", modify_callback);
}

function modify_callback(result) {
	snackbar("modify_result","#54c8ff",result);
	popupHide();
}

function logout() {
	var param = {};
	sessionStorage.clear();
	ajax(param,"/common/logout.php",function(result){ move(result.url); });
}

</script>