<?php
session_start();
include $_SERVER["DOCUMENT_ROOT"]."/lib/nawoo.php";
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
<title><?=TITLE?></title>
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
	 height: 480px;
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
	<form class="ui fluid form" name="form">
  <div class="field">
  <div class="inline field">
    <div class="ui right pointing purple basic label">
      ID
    </div>
    <input type="text" name="id" id="id" class="login_info">
  </div>
  <div class="inline field">
    <div class="ui right pointing purple basic label">
      	PASSWORD
    </div>
    <input type="password" name="password" id="password" class="login_info">
  </div>
  </div>
  <!-- /  -->
</form>
  	<br/><br/>
  	<div class="fluid ui buttons" style="margin-bottom:0px">
		<button class="ui purple button" onclick="login_event()">로그인</button>
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
      	직책
    </div>
    <input type="text" name="position" id="position">
  </div>
  <div class="inline field">
    <div class="ui ribbon purple basic label">
      	이메일
    </div>
    <input type="text" name="user_email" id="user_email" size="30">
  </div>
  <div class="inline field">
    <div class="ui ribbon purple basic label">
      	전화번호
    </div>
    <input type="text" name="hp" id="hp">
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
	/* 붉어진 input 박스를 하얗게 */
	$("input").keyup(function(){
		$(this).closest("div").removeClass('error');
	});

	$(".login_info").keyup(function(e){
		if(e.keyCode==13) {
			login_event();
		}
	});

	$("form[name='form2']").on("keydown","input",function(e) {
		if(e.which==13) {
			var index = $("input").index(this)+1;
			$("input").eq(index).focus();
		}
	});
});

function login_event() {
	var ajax_con;
	$(".login_info").each(function(){
		var ele = $(this);
		var name = $("input[name='"+ele.attr("name")+"']");
		if(ele.val().trim()=="") {
			name.closest("div").addClass("error");
			name.val("");
			name.focus();
			alert("아이디 또는 비밀번호가 입력되지 않았습니다.");
			ajax_con = false;
			return false;
		} else {
			ajax_con = true;
		}
	});
	if(ajax_con===true) {
		var param = setJson(document.form,"id","password");
		ajax(param,"login_execute.php",login_chk);
	}
}

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
		if(msg){
			alert(msg);
		}
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
	var param = setJson(frm,"user_name","user_id","user_pwd","user_pwd2","position","hp","user_email");
	ajax(param,"member_register.php",test_callback);
}
/* CALLBACK METHOD */
function test_callback(result) {
	var frm = document.form2;
	if(result.param)  {
		var param = result.param;
		frm.user_name.value = param.user_name;
		frm.user_id.value = "";
		frm.user_pwd.value = param.user_pwd;
		frm.user_pwd2.value = param.user_pwd2;
		frm.user_email.value = param.user_email;
		modal_open();
	} 
	if(result.msg) {
		alert(result.msg);
	}
}

function login_chk(result) {
	var frm = document.form;
	if(result.msg) {
		frm.id.value="";
		frm.password.value="";
		$("#id").focus().closest("div").addClass("error");
		$("#password").closest("div").addClass("error");
		alert(result.msg);
	}
	if(result.url) {
		move(result.url);
	}
}
/* == CALLBACK METHOD == */
</script>
</html>









