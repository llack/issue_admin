<div class="ui modal" id="fullText">
	<input type="hidden" name="modal_seq" id="modal_seq" value="<?=$_REQUEST[seq]?>"/>
  <i class="close icon"></i>
  <div class="header">
    <span id="modalTitle"><!-- title --></span>
  </div>
  <div class="image content">
    <div class="description">
    <table style="width:100%">
	<colgroup>
		<col width="85%">
		<col width="15%">
	</colgroup>
	<tr height="60">
		<td>
			<div class="ui form">
				<textarea rows="20" style="resize: none" id="modalMemo"></textarea>
			</div>
		</td>
	</tr>
	</table>
    </div>
  </div>
  <div class="actions">
    <div class="ui red deny right labeled icon button">
      	취소
		<i class="ban icon"></i>      	
    </div>
    <div class="ui positive right labeled icon button">
      	수정
      <i class="checkmark icon"></i>
    </div>
  </div>
  <br/><br/><br/>
</div>