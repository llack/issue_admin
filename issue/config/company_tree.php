<?
session_start();

include $_SERVER["DOCUMENT_ROOT"]."/common/header.php";

?>
<style>
</style>
<body>
<div class="ui container side">
<? include $_SERVER["DOCUMENT_ROOT"]."/common/company_list.php"; ?>
</div>

<!-- 메인 테이블  -->
<div class="ui container table purple segment">
		
	<div class="right aligned">
		<a class="ui tag label">menu</a>
		<a class="ui red tag label">사원관리</a>
		<a class="ui teal tag label">조직도</a>
	</div>
	<br/>
	<div class="ui center aligned" style="height:90%;overflow-y: auto" >
	<!-- <table style="height:100%;width:100%" class="ui grey segment">
	<colgroup>
		<col width="50%">
		<col width="50%">
	</colgroup>
	<tr>
	<td valign="top" align="center">
	
		<div class="ui center aligned">
			<i class="circular purple sitemap icon"></i><?=COMPANY_NAME?> 조직도<br/><br/>
		</div>
		<? 
			$que_map = " select * from sitemap where dept = 'top' ";
		  	$res_map = mysql_query($que_map) or die(mysql_error());
		  	$mapTotal = mysql_num_rows($res_map);
		  	$notice = ($mapTotal == 0) ? "등록된 내용이 없습니다." : "";
		  	echo $notice;
		?>
		<div class="ui styled accordion" id="treeView" style="width:100%">
		  <? 
		  $fn = new Json_select();
		  while($row_map = mysql_fetch_array($res_map)) {
			$adminName = ($row_map[admin] != "") ? $fn->userInfo($row_map[admin]) : "";
			getTree($row_map,$adminName,'top');
		 }?>
		</div>
		</td>
			<td valign="top" >
				<div class="ui center aligned" >
					<i class="circular purple sitemap icon"></i>조직도 관리<br/><br/>
				</div> 
				<div class="ui left aligned" style="display:none">
				<button class="ui basic blue button" onclick="editSiteMap('new');">
				  <i class="icon plus square"></i>새로 만들기</button>
				</div><br/>
				<div class="ui center aligned" id="editSiteMap" style="display:none">
					<table class="ui celled table" border="1">
						<colgroup>
							<col width="20%">
							<col width="80%">
						</colgroup>
						    <tr>
						      <td bgcolor="#f9fafb">구분</td>
						      <td>
						      <div class="ui form">
								  <div class="inline fields">
								  <?$teamArr = array("top"=>"부서","team"=>"팀","user"=>"사원");
								  foreach ($teamArr as $key=>$value) {
								  ?>
								    <div class="field">
								      <div class="ui radio checkbox gubunChk">
								        <input type="radio" name="teamMode" value="<?=$key?>" onchange="siteMode(this.value)">
								        <label><?=$value?></label>
								      </div>
								    </div>
								    <? }?>
								  </div>
							  </div>
						      </td>
						    </tr>
						    <tr>
						      <td bgcolor="#f9fafb">사원</td>
						      <td>
								<select id="user_id" name="user_id" class="ui search dropdown forced" style="width: 200px">
									<option value="unset">선택하세요</option>
									<?
										$u = $fn->allowUser();
										$u_max = count($u);
										for($i = 0; $i < $u_max; $i++) { ?>
											<option value="<?=$u[$i][user_id]?>"><?=$u[$i][user_name]?></option>	
									<? } ?>
								</select>
							</td>
						    </tr>
						    <tr>
						    	<td bgcolor="#f9fafb">사원</td>
						    </tr>
					</table>
				</div>
			</td>
		</tr>
		</table> -->
<!-- content end -->
	</div>
</div>
</body>
<script>
$(function(){
	$(".gubunChk").checkbox();
	$("#treeView").accordion({
		exclusive : false,
		selector : {
			trigger : ".title .qus_label"
		}
	});
	
});

function siteMode(v) {
	alert(v);
}
function editSiteMap(mode,seq) {
	alert(seq);
	$("#editSiteMap").css("display","");
}

</script>
</html>
<? 
function parse_ids($ids,$title,$dept) { // 팀원 테이블 구성;
	$fn = new Json_select();
	$color = ($dept == "top") ? "#ccf0ee":"#f9fafb";
	if( $ids != "" ) {
		$str = "";
		$arr = explode(",",$ids);
		$table = "<table class='ui small table' border='1' style='text-align:center'>";
		$table .= "<colgroup>".str_repeat("<col width='25%'>",4)."</colgroup>"; 
		$table .= "<tr><td bgcolor='$color' colspan='4' >&nbsp;".$title."&nbsp;</td></tr>";
		$table .= "<tr>";
		$table .="<td bgcolor='$color'>직책</td><td bgcolor='$color'>성명</td>";
		$table .="<td bgcolor='$color'>연락처</td><td bgcolor='$color'>이메일</td>";
		$table .="</tr>";
		foreach($arr as $value) {
			$userName = $fn->userInfo($value);
			$table .= "<tr>";
			$table .= "<td>".$userName[0][position]."</td><td>".$userName[0][user_name]."</td>";
			$table .="<td>".$userName[0][hp]."</td><td>".$userName[0][user_email]."</td>";
			$table .= "</tr>";
		}
		$table .= "</table>";
		return $table;
	} else {
		return;
	}
}
function getTree($list,$adminName,$dept="") {
	$fn = new Json_select();
	if($dept == "top") {
		$color = "black";
	} else if($dept == "team") {
		$color = "Yellow";
	}
	$title = ($list[addTitle]!="") ? $list[addTitle] : $list[title];
	$html = "";
	$html .= "<div class='active title ui $color segment'>";
	$html .= "<div class='qus_label'><i class='dropdown icon'></i>".$title;
	$html .= "<span style='float:right'>";
	$html .= ($adminName) ? "<i class='user circle icon'></i> 담당자 : ".$adminName[0][user_name] : "";
	$html .= "</span><hr/></div>";
	$html .= "<div class='field' align='right'>";
	$html .= "<div class='ui green compact icon button' title='수정' onclick='editSiteMap(\"edit\",\"$list[seq]\");'>";
	$html .= "<i class='ui edit outline mini icon'></i></div>";
	
	$html .= "<div class='ui red compact icon button' title='삭제' onclick='editSiteMap(\"delete\",\"$list[seq]\");'>";
	$html .= "<i class='ui trash alternate outline mini icon'></i></div>";
	
	$html .= "<div class='ui yellow compact icon button' title='추가' onclick='editSiteMap(\"add\",\"$list[seq]\");'>";
	$html .= "<i class='ui plus mini icon'></i></div>";
	echo $html."</div></div>";
	
	getContents($list,$dept);
}
function getContents($list,$dept="") {
	$fn = new Json_select();
	$sub_chk = substr($list[sub_seq],1); 
    $sub = ($sub_chk) ? $sub_chk : "-1";
    $que = " select * from sitemap where seq in ($sub) ";
    $res = mysql_query($que) or die(mysql_error());
    $cnt = mysql_num_rows($res);
    if($cnt > 0) {
    	echo "<div class='active content'><div class='accordion'>";
    	$res = mysql_query($que) or die(mysql_error());
  	 	while($row = mysql_fetch_array($res)) {
  	 		$adminName = ($row[admin] != "") ? $fn->userInfo($row[admin]) : "";
	    	 $row[addTitle] = $list[title]." > " . $row[title];
	    	 getTree($row,$adminName,'team');
	    	 $html = "";
	    	 $html .="<div class='active content'>
		        <span class='transition'>".parse_ids(substr($row[ids],1),$row[addTitle],$dept)."$i</span></div>";
	    	 echo $html;
    	}
    	echo "</div></div>";
    }
    return $obj;
}
?>