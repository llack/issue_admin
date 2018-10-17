<!-- clone -->
<div class="ui form" id="cloneContent0" data-idx="0" style="display:none">
	<input type="hidden" name="cs_name" id="cs_name0" value=""/>
	<div class="seven fields inline">
      <a class="ui grey circular label"><span id="cloneCnt0"></span></a><?$fn->add_nbsp(5)?>
      
      <div class="field">
        <label>업체</label><br/>
         <div class="ui fluid">
			<select name="refseq" class="fluid" id="csCnt0" onchange="loadEmployee(this.id,this.value)">
				<option value="">선택하세요</option>
			<?	for($i = 0; $i < $cs_list_cnt; $i++) {	 //업체
					$cs = $cs_list[$i];
				?>
				<option value="<?=$cs[seq]?>"><?=$cs[title]?></option>	
			<? } ?>
			</select>
		</div>
      </div>
      
      <div class="field selectDiv">
        <label>요청자</label><br/>
        <div class="ui fluid">
        	<input type="text" name="cs_person" class="fluid" id="csPerson0"/>
        	<!-- <select name="cs_person" class="fluid" id="csPerson0">
        		<option value="unset">업체 미선택</option>
        	</select> -->
        </div>
      </div>
      
      <div class="field">
        <label>업무담당자</label><br/>
        <div class="ui fluid">
        	<select name="user_name" class="fluid" id="userName0" onchange="userSelect(this.id,this.value)">
        		<option value="">선택하세요</option>
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
    <div class="five fields inline" >
    
    <div class="field center aligned">
        <label>업무명 ▼</label><br/>
        <div class="ui">
		  <textarea name="memo" class="fluid" rows="3" style="resize:none"></textarea>
		</div>
	</div>
	
	<div class="field center aligned">
        <label>업무상세▼</label><br/>
        <div class="ui">
		  <textarea name="detail_memo" class="fluid" rows="3" style="resize:none"></textarea>
		</div>
	</div>
	
	<div class="field center aligned">
        <label>요청 및  지시사항 ▼</label><br/>
        <div class="ui">
		  <textarea name="order_memo" class="fluid" rows="3" style="resize:none"></textarea>
		</div>
	</div>
	
    <div class="field left aligned">
	      <div class="ui" style="display:none" id="line0">
	      	<br/>
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
      <button class="ui inverted brown button right aligned copyRow"><i class="ui copy outline icon"></i>복사</button>
      <button class="ui inverted red button right aligned removeRow"><i class="ui trash alternate outline icon"></i>삭제</button>
    </div>
    
      
     </div>
     <div style="border-bottom: 2px dotted #dc73ff"></div>
     <br/>
</div>
<!-- clone -->	
<!--  이슈 수정 팝업  -->
<div class="ui small modal" id="issue_modify">
  <i class="close icon"></i>
  <div class="header">
    업 무 정 보 수 정
  </div>
  <div class="image content">
    <div class="description">
    <form class="ui fluid form" name="issue_modify">
    <input type="hidden" name="seq"/>
    <table style="width:100%">
	<colgroup>
		<col width="20%">
		<col width="30%">
		<col width="20%">
		<col width="30%">
	</colgroup>
	<tr height="60">
		<td><div class="ui right pointing purple basic label">업무명</div></td>
		<td colspan="3">
			<div class="ui form">
				<textarea rows="3" name="memo" style="resize: none"></textarea>
			</div>
		</td>
	</tr>
	<tr height="60">
		<td><div class="ui right pointing purple basic label">업무상세</div></td>
		<td colspan="3">
			<div class="ui form">
			<textarea rows="3" name="detail_memo" style="resize: none"></textarea>
			</div>
		</td>
	</tr>
	<tr height="60">
		<td><div class="ui right pointing purple basic label">요청 및 지시사항</div></td>
		<td colspan="3">
			<div class="ui form">
				<textarea rows="3" name="order_memo" style="resize: none"></textarea>
			</div>
		</td>
	</tr>
	<tr height="60">
		<td><div class="ui right pointing purple basic label">업체명</div></td>
		<td colspan="3">
			<div class="ui form">
				<select name="refseq" onchange="setCsName(this.value)">
			    <?	for($ii = 0; $ii < $cs_list_cnt; $ii++) {	 //업체
			    		$cs = $cs_list[$ii];
					?>
					<option value="<?=$cs[seq]?>"><?=$cs[title]?></option>	
				<? } ?>
			    </select>
			</div>
			<input type="hidden" name="cs_name">
		</td>
	</tr>
	<tr height="60">
		<td><div class="ui right pointing purple basic label">요청자</div></td>
		<td colspan="3"><div class="ui fluid input"><input type="text" name="cs_person" style="font-size: 14px;"/></div></td>
	</tr>
	<tr height="60">
		<td><div class="ui right pointing purple basic label">등록일</div></td>
		<td>
			<div class="ui form">
				<div class="ui calendar date">
				    <div class="ui input left icon">
				      <i class="calendar alternate outline icon purple"></i>
				      <input type="text" name="regdate"/>
				    </div>
				 </div>
			 </div>
		</td>
		<td align="center"><div class="ui right pointing purple basic label">마감예정일</div></td>
		<td>
			<div class="ui form">
				<div class="ui calendar date">
				    <div class="ui input left icon">
				      <i class="calendar alternate outline icon purple"></i>
				      <input type="text" name="end_date"/>
				    </div>
				 </div>
			</div>
		</td>
	</tr>
	<tr height="60">
		<td><div class="ui right pointing purple basic label">지시자</div></td>
		<td colspan="3">
			<div class="ui form">
			<select name="order_name">
		        <option value="">선택하세요</option>
		        	<?
		        		for ($user = 0; $user < $max; $user++) {
		        	?>
		        	<option value="<?=$user_list[$user][user_id]?>"><?=$user_list[$user][user_name]?></option>
		        	<? } ?>
		   </select>
		   </div>
		</td>
	</tr>
	<tr height="60">
		<td><div class="ui right pointing purple basic label">담당자</div></td>
		<td colspan="3"><div class="ui form">
			<select name="user_name">
        		<option value="">선택하세요</option>
		        	<?
		        		for ($user = 0; $user < $max; $user++) {
		        	?>
		        	<option value="<?=$user_list[$user][user_id]?>"><?=$user_list[$user][user_name]?></option>
		        	<? } ?>
		   </select></div>
		</td>
	</tr>
	</table>
	</form>
    </div>
  </div>
  <div class="actions">
    <div class="ui positive right labeled icon button ok">
      	수정
      <i class="checkmark icon"></i>
    </div>
    <div class="ui red deny right labeled icon button cancel">
      	닫기
      <i class="ban icon"></i>
    </div>
  </div>
</div>
<!-- 완료 시 modal -->
<div class="ui modal" id="completeModal">
	<input type="hidden" name="modal_seq" id="modal_seq"/>
  <i class="close icon"></i>
  <div class="header">
    <span id="modalTitle"></span>
  </div>
  <div class="image content">
    <div class="description">
    <table style="width:100%">
	<colgroup>
		<col width="15%">
		<col width="70%">
		<col width="15%">
	</colgroup>
	<tr height="60">
		<td><div class="ui right pointing blue basic label">업무상세</div></td>
		<td>
			<div class="ui form">
				<textarea rows="3" id="modal_detail_memo" style="resize: none"  readonly></textarea>
			</div>
		</td>
	</tr>
	<tr height="60">
		<td><div class="ui right pointing blue basic label">요청 및 지시사항</div></td>
		<td>
			<div class="ui form">
			<textarea rows="3" id="modal_order_memo" style="resize: none" readonly></textarea>
			</div>
		</td>
	</tr>
	<tr height="60">
		<td><div class="ui right pointing purple basic label">원인분석</div></td>
		<td>
			<div class="ui form">
				<textarea rows="3" id="modal_cause_memo" style="resize: none"></textarea>
			</div>
		</td>
	</tr>
	<tr height="60">
		<td><div class="ui right pointing purple basic label">해결방안 및 결과</div></td>
		<td>
			<div class="ui form">
				<textarea rows="3" id="modal_result_memo" style="resize: none"></textarea>
			</div>
		</td>
	</tr>
	</table>
    </div>
  </div>
  <div class="actions">
    <div class="ui positive right labeled icon button">
      	완료처리
      <i class="checkmark icon"></i>
    </div>
    <div class="ui red deny right labeled icon button">
      	닫기
		<i class="ban icon"></i>      	
    </div>
  </div>
</div>