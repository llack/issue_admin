<?php
session_start();
if($_SESSION["USER_NAME"]!="") {
	header("Location:/");
}

?>
<!DOCTYPE>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta charset="UTF-8">
<link rel="stylesheet" href="/css/semantic.min.css">
<script src="/js/jquery-3.2.1.js"></script>
<script src="/js/semantic.min.js"></script>
<script src="/js/docs.js"></script>
<script src="/js/nawoo.js"></script>
<title>스파이더</title>
</head>
<style>
#login_form { 
 position: absolute;
 width: 400px;
 height: 300px;
 left: 50%;
 top: 50%;
 margin-left: -250px;
 margin-top: -250px;
 border: solid #a333c8 2px;
 border-radius: 25px;
 padding : 1rem;
}

#login_form2 {
	position: absolute;
	 width: 400px;
	 height: 400px;
	 left: 50%;
	 top: 50%;
	 margin-left: -250px;
	 margin-top: -250px;
	 border: solid #a333c8 2px;
	 border-radius: 25px;
	 padding : 1rem;
}

.login.header {
	height: 50px;
	color:#a333c8;
	text-align:left;
	font-size:30px;
}
.ribbon {
	font-size:14px !important;
}
</style>
<body>
<div id="login_form">
	<div class="login header">
		S P I D E R<br/><div style="text-align:right !important">Login</div>
	</div>
	<br/><br/>
	<form class="ui fluid form" onsubmit="return user_check(this)" name="form" method="post">
  <div class="field">
  <div class="inline field">
    <div class="ui right pointing purple basic label">
      ID
    </div>
    <input type="text" name="id" id="id">
  </div>
  <div class="inline field">
    <div class="ui right pointing purple basic label">
      	PASSWORD
    </div>
    <input type="password" name="password" id="password">
  </div>
  </div>
  <!-- /  -->
</form>
  	<br/><br/>
  	<div class="fluid ui buttons" style="margin-bottom:0px">
		<button class="ui purple button">로그인</button>
		<div class="or"></div>
		<button class="ui positive button" onclick="modal_open()">회원가입</button>
	</div>
</div>

<!-- 회원가입 modal --> 
<div class="ui basic modal">
  <div class="content">
  	<div id="login_form2">
	<div class="login header">
		S P I D E R<br/><div style="text-align:right !important">회원가입</div>
	</div>
	<br/><br/>
	<form class="ui fluid form" name="form2">
  <div class="field">
  <div class="inline field">
    <div class="ui ribbon  purple basic label">
      이름
    </div>
    <input type="text" name="user_name" id="user_name">
  </div>
  <div class="inline field">
    <div class="ui ribbon purple basic label">
      아이디
    </div>
    <input type="text" name="user_id" id="user_id">
  </div>
  <div class="inline field">
    <div class="ui ribbon purple basic label">
      	비밀번호
    </div>
    <input type="password" name="user_pwd" id="user_pwd">
  </div>
  <div class="inline field">
    <div class="ui ribbon purple basic label">
      	비밀번호확인
    </div>
    <input type="password" name="user_pwd2" id="user_pwd2">
  </div>
  <div class="inline field">
    <div class="ui ribbon purple basic label">
      	이메일
    </div>
    <input type="text" name="user_email" id="user_email" size="30">
  </div>
  </div>
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
      가입하기
    </div>
  </div>
</div>
<!-- / 회원가입 modal  -->
</body>
<script>
$(document).ready(function(){

	$("#id").focus();
	
	$("input").keyup(function(){
		$(this).closest("div").removeClass('error');
	});
});

function modal_open() {
	$('.ui.basic.modal').modal({
		//closable : false,
		onDeny : function() { // true가 닫힘
			$("div").removeClass('error');
			$("input").val("");
			return true;
		}
		,onApprove : function(e) {
				if(e.hasClass('ok')) {
					return sign_submit(document.form2);
				}
			}
		, onHide : function () {
			$("div").removeClass('error');
			$("input").val("");
			}
		})
		.modal('show');
}
function trim_chk(value,name,msg) {
	if(value.trim()=="") {
		$("input[name='"+name+"']").closest("div").addClass("error");
		$("input[name='"+name+"']").val("");
		$("input[name='"+name+"']").focus();
		alert(msg);
		return false;
	} else {
		return true;
	}
}

function sign_submit(frm) {
	
	if(!trim_chk(frm.user_name.value,"user_name","이름을 입력해주세요")){
		return false;
	}
	
	if(!trim_chk(frm.user_id.value,"user_id","아이디를 입력해주세요")){
		return false;
	}
	
	if(!trim_chk(frm.user_pwd.value,"user_pwd","비밀번호를 입력해주세요")){
		return false;
	}

	if(!trim_chk(frm.user_pwd2.value,"user_pwd2","비밀번호확인을 입력해주세요")){
		return false;
	}
	
	if(frm.user_pwd.value.trim() != frm.user_pwd2.value.trim()){
		alert("비밀번호가 일치하지 않습니다");
		frm.user_pwd2.value="";
		$("input[name='user_pwd2']").closest("div").addClass("error");
		frm.user_pwd2.focus();
		return false;
	}
	var param = setJson(frm,"user_name","user_id","user_pwd","user_pwd2","user_email");
	ajax(param,"test.php",test_callback);
}

function test_callback(result) {
	var frm = document.form2;
	var param = result.param;
	frm.user_name.value = param.user_name;
	frm.user_id.value = "";
	frm.user_pwd.value = param.user_pwd;
	frm.user_pwd2.value = param.user_pwd2;
	frm.user_email.value = param.user_email;
	alert(result.msg);
	console.log(result);
	modal_open();
}
</script>
</html>
