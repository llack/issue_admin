<?php
session_start();
header ("Content-Type: text/html; charset=UTF-8");		#다국어지원을 위한 설정
include_once($_SERVER["DOCUMENT_ROOT"]."/db/fn/config.php");//디비연결

$que = " select 
		column_name as `name`, 
		data_type as `type`, 
		IFNULL(character_maximum_length,'') as `length`,
		IFNULL(COLLATION_NAME,'') as `col`, 
		case when COLUMN_KEY = 'PRI' then '<img src=\"/db/img/key-icon.png\" width=\"13\" />' else '' end as `id`, 
		case when EXTRA = 'auto_increment' then '<img src=\"/db/img/ai.png\" width=\"13\" />' else '' end as `ai`, 
		IFNULL(COLUMN_DEFAULT,'') as `def`,
		COLUMN_COMMENT as `comment` 
		from INFORMATION_SCHEMA.columns where 
		table_name='".$_REQUEST[table]."' and table_schema='".$_REQUEST[db]."' order by ordinal_position ";
$res = mysql_query($que) or die(mysql_error());
$cnt = mysql_num_rows($res);
while($row = mysql_fetch_assoc($res)) {
	if($row["type"] == "varchar") {
		$row["type"] .= "(".$row["length"].")";
	}
	$list[] = $row;	
}
$html = "<table width='100%' style='text-align:center;border-collapse: collapse' border='1' class='topTable'>";
$html .="<colgroup>";
$html .= "<col width='15%'><col width='15%'><col width='15%'>";
$html .= "<col width='10%'>";
$html .= "<col width='15%'><col width='15%'><col width='15%'>";
$html .= "</colgroup>";
$html .= "<tr><th colspan='7' class='tableName'>".getLocation($_REQUEST[db],$_REQUEST[table])."</th></tr>";
$html .= "<tr class='thead'>";
$html .= "<th>이름</th><th>종류</th><th>데이터 정렬방식</th><th>기본값</th><th>PRIMARY KEY</th><th>AUTO INCREMENT</th><th>코멘트</th>";
$html .= "</tr></table>";

$html .= "<table width='100%' style='text-align:center;border-collapse: collapse' border='1'>";
$html .="<colgroup>";
$html .= "<col width='15%'><col width='15%'><col width='15%'>";
$html .= "<col width='10%'>";
$html .= "<col width='15%'><col width='15%'><col width='15%'>";
$html .= "</colgroup>";
for($i = 0; $i < $cnt; $i++) {
	$r = $list[$i];
	$html .="<tr class='tr_hover'>";
	$html .= "<td>".$r[name]."</td><td>".$r[type]."</td><td>".$r[col]."</td><td>".$r[def]."</td><td>".$r[id]."</td><td>".$r[ai]."</td><td>".$r[comment]."</td>";
	$html .="</tr>";
}
$html .= "</table>";
echo json_encode(array("contents"=>$html,"tableSelect"=>tableInfo($_REQUEST[db],$_REQUEST[table])));exit;
?>

<?
###########function###########
function getLocation($db,$table) {
	$result = "<img src='/db/img/db_icon.png' width='20'/> 데이터베이스 : ".$db;
	$result .= "&nbsp;&nbsp;&nbsp;<img src='/db/img/forward-double-right.png' width='10'/>";
	$result .= "&nbsp;&nbsp;&nbsp;<img src='/db/img/table_icon.png'  width='20'/> 테이블 : ".$table;
	return $result;
}

function tableInfo($db,$table) {
	mysql_query(" use `".$db."` ") or die(mysql_error());
	$que = " select * from `".$table."` LIMIT 0,30 ";
	$res = mysql_query($que) or die(mysql_error());
	$cnt = mysql_num_rows($res);
	$i = 0;
	while($row = mysql_fetch_assoc($res)) {
		$list[] = $row;
		if($i == 0 ) {
			$keys = array_keys($row);
		}
		$i++;
	}
	$html = "<table width='100%' style='text-align:center;border-collapse: collapse' border='1' class='topTable'>";
	$html .= "<tr class='thead'>";
	foreach($keys as $value) {
		$html .= "<th width='150px'>".$value."</th>";
	}
	$html .= "</tr></table>";
	$html .= "<table width='100%' style='text-align:left;border-collapse: collapse' border='1'>";
	for($i = 0; $i < $cnt; $i++) {
		$html .= "<tr class='tr_hover'>";
		for($j = 0; $j < count($keys); $j++) {
			$text = longText($list[$i][$keys[$j]]);
			$html .= "<td width='150px' ".h($text->popup).">".h($text->text)."</td>";
		}
		$html .= "</tr>";
	}
	if($cnt == 0) {
		$html .= "<tr class='blink'><th align='center'>empty table...</th></tr>";
	}
	$html .="</table>";
	return $html;
}

function longText($str) {
	$text = $str;
	$popup = "";
	if(mb_strlen($str,'UTF-8') > 40) {
		$text =  mb_substr($str,0,40,'UTF-8')."...";
		$popup = " class='longtext' title='".mb_substr($str,0,700,'UTF-8')."' ";
	}
	
	$result = new stdClass();
	$result->text = $text;
	$result->popup = $popup;
	return $result;
}
function h($str){
	return htmlspecialchars($str);
}
?>






