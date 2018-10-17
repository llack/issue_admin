<?php
function dDay($dday) {
	$dday = intval($dday);
	if($dday >0) {
		return "<font color='red'><strong>(D+" .$dday . ")</strong></font>";
	} else if($dday < 0) {
		return "<font color='green'><strong>(D" .$dday . ")</strong></font>";
	} else {
		return "<font color='red'>오늘 마감</font>";
	}
}
function unSetView($val) {
	if($val == "unset"||$val == "") {
		return "";
	} else {
		return "<br/>(".$val.")";
	}
}
function stateView($text) {
	$stateList = array("완료"=>"green|Y","진행중"=>"blue|G","미완료"=>"red|N","보류"=>"violet|Z");
  	unset($stateList[$text]);
  	return $stateList;
}

function getCsName($refseq){
	$que = " select cs_name from erp_ocsinfo where seq = '".$refseq."' ";
	$res = mysql_query($que) or die(mysql_error());
	$row = mysql_fetch_array($res);
	return $row[cs_name];
}
function getState($state) {
	$result = "";
	if($state == "N") {
		$result = "미완료_red";
	} else if ($state == "Y"){
		$result = "완료_green";
	} else if($state == "Z") {
		$result = "보류_violet";
	}else if($state == "G") {
		$result = "진행중_blue";
	}
	return $result;
}
function getView($state) {
	$setColor = "green";
  	$setText = "완료";
  	$setIcon = "flag";
	if($state=="N") {
  		$setColor = "red";
  		$setText = "미완료";
  		$setIcon = "times";
  	} else if($state == "Z") {
  		$setColor = "violet";
  		$setText = "보류";
  		$setIcon = "pause";
  	} else if($state == "G") {
  		$setColor = "blue";
  		$setText = "진행중";
  		$setIcon = "play";
  	}
  	$result = new stdClass();
  	$result->color = $setColor;
  	$result->text = $setText;
  	$result->icon = $setIcon;
  	return $result;
}
?>