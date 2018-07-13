<!--  업체 수정 팝업 -->
<div id="company_modify"class="ui basic modal">
  <div class="content">
  	<div id="company_info">
	<div class="login header">
		<div style="text-align:right !important"><i class="user icon"></i>업 체 정 보 <span class="popup_title">수 정</span></div>
	</div>
	<br/><br/>
	<form class="ui fluid form" name="cs_modify">
  <div class="field">
  <div class="inline field">
    <div class="ui ribbon  purple basic label">
      업체명
    </div>
    <input type="text" name="cs_name" value="" onfocus="this.setSelectionRange(this.value.length, this.value.length)" size="40">
  </div>
  <div class="inline field">
    <div class="ui ribbon purple basic label">
      업체코드
    </div>
   <input type="text" name="cs_code" value="">
  </div>
  <div class="inline field">
    <div class="ui ribbon purple basic label">
      업체색상
    </div>
   <button type="button" class="colorPicker">색상 선택</button>
   <input type="hidden" name="color" id="color"/>&nbsp;&nbsp;달력에 표시되는 색상입니다.
  </div>
  </div>
  <input type="hidden" name="seq" value=""/>
</form>
  <!-- /  -->
</div>
  </div>
  <div class="actions" style="width:935px">
    <div class="ui red basic cancel inverted button">
      <i class="remove icon"></i>
      취 소
    </div>
    <div class="ui green ok inverted button">
      <i class="checkmark icon"></i>
     <span class="popup_title">수 정</span>
    </div>
  </div>
</div>
