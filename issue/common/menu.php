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
    환경설정
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
        <a class="item">권한관리 (관리자)</a>
        <a class="item">메뉴1</a>
        <a class="item">메뉴2</a>
      </div>
    </div>
    <div class="column"> <!-- 내정보 -->
		<img class="ui image avatar" style="width: 50px;height:50px"src="/img/img.jpg"><span><?=$row_info[user_name]?></span>
		<button class="ui purple mini button right floated"><i class="user icon"></i>정보 수정</button>
		<br/><br/>
		<div id="copy_clip" onclick="copy_email()"data-tooltip="클립보드로 복사하기" style="float:left;padding:0px">
		<i class="inverted purple big copy outline icon"></i>
		</div>
		E-mail : <input type="text" value="<?=$row_info[user_email]?>" style="border:none;height:30px" id="user_email" readonly/>
		<br/>
		<a href="">미완료 업무 : 4건</a>
		<button class="negative ui small button right floated" onclick="logout()"><i class="share square outline icon"></i>로그아웃</button>
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
	  hide: 200
	 }
	 });
	 
$("#copy_clip").popup();

function copy_email() {
	var copyText = document.getElementById("user_email");
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