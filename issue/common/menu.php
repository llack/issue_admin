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
        <a class="item">Cashmere</a>
        <a class="item">Linen</a>
        <a class="item">Cotton</a>
        <a class="item">Viscose</a>
      </div>
    </div>
    <div class="column" align="center">
      <h4 class="ui header">업체관리</h4>
      <div class="ui link list">
        <a class="item">Small</a>
        <a class="item">Medium</a>
        <a class="item">Large</a>
        <a class="item">Plus Sizes</a>
      </div>
    </div>
    <div class="column" align="center">
      <h4 class="ui header">환경설정</h4>
      <div class="ui link list">
        <a class="item">Neutrals</a>
        <a class="item">Brights</a>
        <a class="item">Pastels</a>
      </div>
    </div>
    <div class="column"> <!-- 내정보 -->
		<img class="ui image avatar" style="width: 50px;height:50px"src="/img/img.jpg"><span>나영우</span>
		<button class="ui purple mini button right floated"><i class="user icon"></i>정보수정</button>
		<br/><br/>
		<div id="copy_clip" onclick="copy_email()"data-tooltip="클립보드로 복사하기" style="float:left;padding:0px">
		<i class="inverted purple big copy outline icon"></i>
		</div>
		E-mail : <input type="text" value="jjoker010@gmail.com" style="border:none;height:30px" id="user_email" readonly/>
		<br/>
		<a href="">미완료 업무 : 4건</a>
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
</script>