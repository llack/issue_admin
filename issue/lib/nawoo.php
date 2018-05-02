<?php
define("TITLE","스파이더");

class Json_select { 
	function cs_list() {
		$que = " select * from erp_ocsinfo order by cs_name ";
		$res = mysql_query($que) or die(mysql_error());
		$i = 0;
		while($row = mysql_fetch_array($res)) {
			$result[$i]["title"] = $row[cs_name]."";
			$result[$i]["description"] = $row[cs_code]."";
			$result[$i]["url"] = "/?cs_code=".$row[cs_code]."";
			$i++;
		}
		
		return $result;
	}
	
	function param_to_array2($param) {
		$arr = array();
		$param = explode("_",$param);
		array_push($arr,$param[0],$param[1]);
		return $arr;
	}
	
	function add_nbsp($num) {
		
		echo str_repeat("&nbsp;",$num);
	}
	
	function userInfo($user_id="") {
		if($user_id != "") {
			$where = " where user_id = '".$user_id."' ";
		}
		$que = " select * from member $where order by user_level desc";
		$res = mysql_query($que) or die(mysql_error());
		while($row = mysql_fetch_array($res)) {
			$result[] = $row; 
		}
		return $result;
	}
	
}
class Simple_query {
	function delete_complete($table, $column,$del_data) {
		if(is_array($del_data)) {
			foreach ($del_data as $del) {
				$que = " delete from {$table} where {$column} = '{$del}' ";
				mysql_query($que) or die(mysql_error());
			}
			return count($del_data);
		} else {
			$que = " delete from {$table} where {$column} = '{$del_data}' ";
			mysql_query($que) or die(mysql_error());
			return "삭제되었습니다.";
		}
	}
	
	function simple_select($table,$where) {
		$que = " select * from {$table} where 1=1 {$where}";
		$res = mysql_query($que) or die(mysql_error());
		while ($row = mysql_fetch_assoc($res)) {
			$result[] = $row;
		}
		return $result;
	}
	
	function simple_update($param, $table, $id) {
		$que = " update {$table} set ";
		$target = $param[$id]; //나중에 where 조건 추가 될수도 일단 하나만 
		
		unset($param[$id]); 
		
		$que_mid = "";
		foreach($param as $key => $value) {
			$que_mid .= ", $key = '$value' ";
		}
		$que = $que.substr($que_mid,1)." where 1=1 and $id = '$target' ";
		mysql_query($que) or die(mysql_error());
		return "수정되었습니다.";
	}
}
?>





