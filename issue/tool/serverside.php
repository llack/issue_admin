<?php
session_start();
header ("Content-Type: text/html; charset=UTF-8");		#다국어지원을 위한 설정

include_once($_SERVER["DOCUMENT_ROOT"]."/conf/config.db.conn.php");//디비연결
include_once($_SERVER["DOCUMENT_ROOT"]."/lib/nawoo.php");//공통라이브러리
include $_SERVER["DOCUMENT_ROOT"]."/lib/fn_index.php";
	$fn = new Json_select();
	$params = $columns = $totalRecords = $data = array();
 
	$params = $_REQUEST;
	$columns = $_REQUEST[sort];
	$noSearch = $_REQUEST[noSearch];
	$text = $params['search']['value'];
 	$order =  $columns[$params['order'][0]['column']]." ".$params['order'][0]['dir']; // auto sort    
 
	$where_condition = $que = $queTotal = $limit = "";
	/* query */
	$que = " SELECT * FROM row_test where 1=1 ";
	$queTotal = $que;
	/* where */
	if( !empty($params['search']['value']) ) {
		$where_condition .= " and ";
		$where_condition .= getSearchText($columns,$noSearch);    
	}
	if(isset($where_condition) && $where_condition != '') {
		$que .= $where_condition;
		$queTotal .= $where_condition;
	}
 	/* order by and limit */
 	if($order == $_REQUEST[sort][0]." asc") {
 		$limit .= $_REQUEST[where]." LIMIT ".$params['start']." ,".$params['length']." ";
 	} else {
	 	$limit .=  " ORDER BY ". $order."  LIMIT ".$params['start']." ,".$params['length']." ";
 	}
 	/* get Total */
	$total = mysql_query($queTotal) or die("Database Error:". mysql_error());
	$totalRecords = mysql_num_rows($total); //Total
 	
	$queryRecords = mysql_query($que.$limit) or die("Error to Get the Post details.");
 	$i = 1;
	while( $row = mysql_fetch_array($queryRecords) ) {
		$name = ($row[user_name] !="") ? $fn->getName($row[user_name]) : "";
		$order = ($row[order_name] !="") ? $fn->getName($row[order_name]) : "";
		$vObj = getView($row[state]);
		/*dday*/
		$today = strtotime(date("Y-m-d"));
	  	$end_date = strtotime(date($row[end_date]));
	  	$dday = intval(($today - $end_date) / 86400);
		$over = ($row[state]=="N" || $row[state] == "G") ? true : false;
		$dDayView = ($over==true) ? $row[end_date]."<br/>".dDay($dday) : $row[end_date];
		/*dday*/
		$seq = $row["seq"];
		$row["seq"] = "<div class='ui toggle checkbox' style='width:50px'>
			      <input type='checkbox' id='chk' value='".$seq."'/><label></label></div>";
		$row["no"] = "<font color='".$vObj->color."'><b>".number_format($i+$params['start'])."</b></font>";
		$row["cs_name"] = addTag($row["cs_name"],$seq,$row["cs_person"]);
		$row["memo"] = addTag($row["memo"],$seq);
		$row["order_name"] = $order;
		$row["user_name"] = $name;
		$row["end_date"] = $dDayView;
		$row["finish_date"] = $fn->d($row[finish_date]);;
		$row["view"] = "<div class='ui tiny buttons'>
							<button class='ui inverted brown button' onclick='openWin(\"$seq\")'>보기</btton>	
						</div>";
		$data[] = $row;
		$i++;
	}
	$json_data = array(
		"draw"            => intval($params['draw']),   
		"recordsTotal"    => intval($totalRecords),  
		"recordsFiltered" => intval($totalRecords),
		"data"            => $data
	);
 
	echo json_encode($json_data);
?>

<? 
##############################################
################## function ##################
##############################################
# 검색 조건 얻는 쿼리 script noSearch index 채우면 됌
function getSearchText($columns,$noSearch) {
	$result = "";
	$searchWord = array_map(function ($value) {
		global $text;
		return " ( ".$value ." LIKE '%".$text."%') or ";
	},array_diff_key($columns,array_flip($noSearch)) );
	if($searchWord) {
		$result = substr(implode(" ", $searchWord ),0,-4);
	}
	return $result;
}
// 요청자 
function addTag($val,$seq,$person="") {
	$result = "<a onclick='editIssue(".$seq.")' style='cursor:pointer'>".$val."";
	if($person != "") {
		$result .= unSetView($person);
	}
	return $result."</a>";
}
?>










