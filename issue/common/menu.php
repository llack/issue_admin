<? 
	$que_info = " select * from member where user_id = '".$_SESSION["USER_ID"]."' ";
	$res_info = mysql_query($que_info) or die(mysql_error());
	$row_info = mysql_fetch_array($res_info);
?>
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
      <h4 class="ui header">업무관리</h4>
      <div class="ui link list">
        <a class="item">업무현황</a>
        <a class="item">메뉴2</a>
        <a class="item">메뉴3</a>
      </div>
    </div>
    <div class="column" align="center">
      <h4 class="ui header">업체관리</h4>
      <div class="ui link list">
        <a class="item">업체추가</a>
        <a class="item">메뉴1</a>
        <a class="item">메뉴2</a>
        <a class="item">메뉴3</a>
      </div>
    </div>
    <div class="column" align="center">
      <h4 class="ui header">사원관리</h4>
      <div class="ui link list">
        <a class="item" href="/config/employee_auth.php">권한관리 (관리자)</a>
        <a class="item">메뉴1</a>
        <a class="item">메뉴2</a>
      </div>
    </div>
    <div class="column"> <!-- 내정보 -->
		성명 : <?=$row_info[user_name]?> / 
		직책 : <?=$row_info[position]?><br/><br/>
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
		<a href="">미완료 업무 : 4건</a>
		<button class="negative ui small button right floated" onclick="logout()"><i class="share square outline icon"></i>로그아웃</button>
		<button class="purple ui small button right floated" onclick="modify_userInfo()"><i class="user icon"></i></i>정보수정</button>
    </div> <!-- /내정보 -->
  </div>
</div>
<script>
$('#topmenu').popup({
	inline   : true,
	hoverable: true,
	position : 'bottom center',
	lastResort : 'bottom center',
	delay: {
	  show: 100,
	  hide: 100
	 }
	 });
	 
//$("#copy_clip").popup();
function modify_userInfo() {
	alert("정보수정");
}
function fn_copy(id) {
	var copyText = document.getElementById(id);
	  copyText.select();
	  document.execCommand("Copy");
} 
function logout() {
	var param = {};
	ajax(param,"/common/logout.php",logout_callback);
}
function logout_callback(result) {
	move(result.url);
}
</script>