<!-- clone -->
<div class="ui form" id="cloneContent0" data-idx="0" style="display:none">
	<input type="hidden" name="cs_name" id="cs_name0" value=""/>
	<div class="seven fields inline">
      <a class="ui grey circular label"><span id="cloneCnt0"></span></a><?$fn->add_nbsp(5)?>
      
      <div class="field">
        <label>업체</label><br/>
         <div class="ui fluid">
			<select name="refseq" class="fluid" id="csCnt0" onchange="loadEmployee(this.id,this.value)">
				<option value="unset">선택하세요</option>
			<?	for($i = 0; $i < $cs_list_cnt; $i++) {	 //업체
					$cs = $cs_list[$i];
				?>
				<option value="<?=$cs[seq]?>"><?=$cs[title]?></option>	
			<? } ?>
			</select>
		</div>
      </div>
      
      <div class="field selectDiv error">
        <label>요청자</label><br/>
        <div class="ui fluid">
        	<select name="cs_person" class="fluid" id="csPerson0">
        		<option value="unset">업체 미선택</option>
        	</select>
        </div>
      </div>
      
      <div class="field">
        <label>업무담당자</label><br/>
        <div class="ui fluid">
        	<select name="user_name" class="fluid" id="userName0" onchange="userSelect(this.id,this.value)">
        		<option value="unset">선택하세요</option>
        		<?
        			$user_list = $fn->allowUser(); //승인된 유저
        			$max = count($user_list);
        			for ($user = 0; $user < $max; $user++) {
        		?>
        		<option value="<?=$user_list[$user][user_id]?>"><?=$user_list[$user][user_name]?></option>
        		<? } ?>
        	</select>
        </div>
      </div>
      
      <div class="field">
      	<label>등록일</label><br/>
      	<div class="ui fluid">
	      	<div class="ui calendar date">
			    <div class="ui input left icon">
			      <i class="calendar alternate outline icon purple"></i>
			      <input type="text" value="<?=date("Y-m-d")?>" name="regdate" id="regdate0" style="width:100%">
			    </div>
			  </div>
		  </div>
      </div>
      
      <div class="field">
      	<label>마감예정일</label><br/>
      	<div class="ui fluid">
	      	<div class="ui calendar date">
			    <div class="ui input left icon">
			      <i class="calendar alternate outline icon purple"></i>
			      <input type="text" value="" name="end_date" id="end_date0" style="width:100%">
			    </div>
			  </div>
		  </div>
      </div>
      
    </div>
    <br/>
    <div class="four fields inline" >
    
    <div class="field center aligned">
        <label>업무명 ▼</label><br/>
        <div class="ui">
		  <textarea type="text" name="memo" class="fluid" rows="1" style="resize:none"></textarea>
		</div>
	</div>
	
	<div class="field center aligned">
        <label>요청사항 ▼</label><br/>
        <div class="ui">
		  <textarea type="text" name="order_memo" class="fluid" rows="1" style="resize:none"></textarea>
		</div>
	</div>
	
    <div class="field left aligned">
        <label>업무라인</label><br/>
	      <div class="ui">
			<span class="blockLine">
			<div class="ui right pointing purple basic label">
				지시자
			</div><?=$_SESSION["USER_NAME"]?>
			<input type="hidden" name="order_name" value="<?=$_SESSION["USER_ID"]?>"/>
			&nbsp;
			</span>
			<div class="ui right pointing purple basic label">
				담당자
			</div>
			<span id="userView0"></span>
    	  </div>
    </div>
    
	<div class="field right aligned">
        <label>&nbsp;</label><br/>
      <button class="ui inverted red button right aligned removeRow">삭제</button>
    </div>
    
      
     </div>
     <div style="border-bottom: 2px dotted #dc73ff"></div>
     <br/>
</div>
<!-- clone -->	
<!--  이슈 수정 팝업 -->
<div id="issue_modify"class="ui basic modal">
  <div class="content">
  	<div id="issue_info">
	<div class="login header">
		<div style="text-align:right !important"><i class="user icon"></i>업 무 정 보 <span class="popup_title">수 정</span></div>
	</div>
	<br/><br/>
	<form class="ui fluid form" name="issue_modify">
  <div class="field">
  
  <div class="inline field">
    <div class="ui ribbon purple basic label">
      업무명
    </div>
   <textarea name="memo" rows="2" style="resize:none"></textarea>
  </div>
<div class="inline field">
    <div class="ui ribbon purple basic label">
      요청사항
    </div>
   <textarea name="order_memo" rows="1" style="resize:none"></textarea>
  </div>
  <div class="inline field error">
    <div class="ui ribbon  purple basic label">
      업체명
    </div>
    <input type="text" name="cs_name"readonly>
  </div>
  
  <div class="inline field">
    <div class="ui ribbon purple basic label">
      요청자
    </div>
    <select name="cs_person"></select>
  </div>
  
  <div class="inline field">
    <div class="ui ribbon purple basic label">
      등록일
    </div>
    <div class="ui calendar date">
	    <div class="ui input left icon">
	      <i class="calendar alternate outline icon purple"></i>
	      <input type="text" value="" name="regdate"/>
	    </div>
	  </div>
  </div>
  
   <div class="inline field">
    <div class="ui ribbon purple basic label">
      마감예정일
    </div>
    <div class="ui calendar date">
	    <div class="ui input left icon">
	      <i class="calendar alternate outline icon purple"></i>
	      <input type="text" value="" name="end_date"/>
	    </div>
	  </div>
  </div>
  
 <div class="inline field">
    <div class="ui ribbon purple basic label">
      담당자
    </div>
    <select name="user_name" style="width:50%">
        <option value="unset">선택하세요</option>
        	<?
        		for ($user = 0; $user < $max; $user++) {
        	?>
        	<option value="<?=$user_list[$user][user_id]?>"><?=$user_list[$user][user_name]?></option>
        	<? } ?>
   </select>
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