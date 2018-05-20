<!-- 정보 수정 modal --> 
<div id="modify_userInfo" class="ui basic modal">
  <div class="content">
  	<div id="login_form2">
	<div class="login header">
		<div style="text-align:right !important"><i class="user icon"></i>내 정 보 수 정</div>
	</div>
	<br/><br/>
	<form class="ui fluid form" name="user_info">
	<input type="hidden" name="user_id" value="<?=$_SESSION["USER_ID"]?>"/>
  <div class="field">
  <div class="inline field">
    <div class="ui ribbon  purple basic label">
      이름
    </div>
    <input type="text" name="user_name" value="<?=$row_info[user_name]?>" onfocus="this.setSelectionRange(this.value.length, this.value.length)">
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
    <input type="password" name="user_pw" value="<?=$row_info[user_pw]?>">
  </div>
  <div class="inline field">
    <div class="ui ribbon purple basic label">
      	비밀번호확인
    </div>
    <input type="password" name="user_pwd2" value="">
  </div>
  <div class="inline field">
    <div class="ui ribbon purple basic label">
      	직책
    </div>
    <input type="text" name="position" value="<?=$row_info[position]?>">
  </div>
  <div class="inline field">
    <div class="ui ribbon purple basic label">
      	이메일
    </div>
    <input type="text" name="user_email" size="30" value="<?=$row_info[user_email]?>">
  </div>
  <div class="inline field">
    <div class="ui ribbon purple basic label">
      	전화번호
    </div>
    <input type="text" name="hp" value="<?=$row_info[hp]?>">
  </div>
  </div>
  <input type="hidden" name="no" value="<?=$row_info[no]?>"/>
</form>
  <!-- /  -->