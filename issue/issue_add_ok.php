<?php
session_start();
header ("Content-Type: text/html; charset=UTF-8");		#다국어지원을 위한 설정

include_once($_SERVER["DOCUMENT_ROOT"]."/conf/config.db.conn.php");//디비연결
include_once($_SERVER["DOCUMENT_ROOT"]."/lib/nawoo.php");//공통라이브러리
$fn = new Simple_query();

if($_REQUEST[mode] == "insert") {
	$max = count($_REQUEST[issue]);
	$issue = $_REQUEST[issue];
	if($max >= 1 ) {
		for($i = 0; $i < $max; $i++) {
			$que = "insert into issue_list set ";
			$que_mid = "";
			foreach ($issue[$i] as $key=>$value) {
				$que_mid .= ", $key = '$value' ";
			}
			
			$que_mid = substr($que_mid,1);
			mysql_query($que.$que_mid) or die(mysql_error());
			
			$seq = mysql_insert_id();
			$que_his = " insert into issue_history set 
						refseq =".$seq."
						, user_name = '".$_SESSION["USER_NAME"]."'
						, memo = '최초등록'
						, regdate = '".date("Y-m-d H:i:s")."'
						";
			mysql_query($que_his) or die(mysql_error());
		}
	}
	echo json_encode("저장되었습니다.");exit;
} else if($_REQUEST[mode] == "modify") {
	$param = $_REQUEST[param]; //변경 후 
	/* 원래있던 것*/
	$que = " select * from issue_list where seq = '".$param[seq]."'";
	$res = mysql_query($que) or die(mysql_error());
	$row = mysql_fetch_assoc($res);
	
	$userid = $param[user_name]; //일단 id 는 담아둔다 
	
	$row["user_name"] = getName($row["user_name"]); // 변경 전 이름
	$param["user_name"] = getName($param[user_name]); // 변경 후 이름
	/* 수정 내용 있을 때 히스토리 남기자 */
	$keys = array_keys($param);
	for($i = 0; $i < count($keys); $i++) {
		$k = $keys[$i];
		$from  = trim($row[$k]); //전
		$to = trim($param[$k]); // 후
		if($from != $to) {
			$save_from = ($from != "unset") ? $from : "미지정";
			$sava_to = ($to != "unset") ? $to : "미지정";
			
			$difList[$k] = "[".parsekey($k)."] ".$save_from." ▶ ".$sava_to; 			
		}
	}
	$param["user_name"] = $userid; // 다시 id로 저장
	/* 수정내용 있을때만 업데이트 하면 될듯 ? */
	if($difList) {
		$que_his = " insert into issue_history set 
						refseq =".$param[seq]."
						, user_name = '".$_SESSION["USER_NAME"]."'
						, memo = '".implode("<br/>",$difList)."'
						, regdate = '".date("Y-m-d H:i:s")."'
						, gubunColor = 'blue'
						";
		mysql_query($que_his) or die(mysql_error());
		$fn->simple_update($_REQUEST[param],$_REQUEST[table],$_REQUEST[id]);
	}
	echo json_encode("수정되었습니다.");exit;
}

function parsekey($key) {
	$result = array("memo"=>"업무내용",
					"regdate"=>"등록일",
					"end_date"=>"마감예정일",
					"user_name"=>"담당자",
					"cs_person"=>"요청자",
					"order_memo"=>"요청 및 지시사항",
					"detail_memo"=>"업무상세"
	);
	return $result[$key];
}
function getName($userId) {
	$que = " select user_name from member where user_id = '".$userId."' ";
	$res = mysql_query($que) or die(mysql_error());
	$row = mysql_fetch_array($res);
	$name = ($row[user_name]!="") ? $row[user_name] : "미지정";
	return $name;
}
?>





