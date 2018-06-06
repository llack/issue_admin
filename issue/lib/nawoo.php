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
			$result[$i]["url"] = "/index.php?cs_seq=".$row[seq]."&nAll=N";
			$result[$i]["seq"] = $row[seq];
			$i++;
		}
		
		return $result;
	}
	
	function param_to_array2($param) {
		$param = explode("_",$param);
		$arr[0] = $param[0];
		$arr[1] = $param[1];
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
	
	function allowUser() {
		$que = " select * from member where  user_level <> '' order by user_level desc";
		$res = mysql_query($que) or die(mysql_error());
		while($row = mysql_fetch_array($res)) {
			$result[] = $row;
		}
		return $result;
	}
	
	function auto_link() {
		$str = "";
		$args = func_get_args();
		foreach ($args as $arg) {
			$str .="&$arg=";
			if(is_array($_REQUEST[$arg])) {
				$str .= implode("_",$_REQUEST[$arg]);
			} else {
				$str .= $_REQUEST[$arg];
			}
		}
		return $str;
	}
	
	function myWork($value,$search="user_name") {
		$que = " select * from issue_list where {$search} = '$value' and state = 'N' ";
		$res = mysql_query($que) or die(mysql_error());
		$cnt = mysql_num_rows($res);
		
		$s = mysql_query($que." order by regdate LIMIT 1") or die(mysql_error());
		$sdate = mysql_fetch_array($s);
		
		$e = mysql_query($que." order by regdate desc LIMIT 1") or die(mysql_error());
		$edate = mysql_fetch_array($e);
		
		$obj = new stdClass();
		$obj->cnt = $cnt;
		if($search=="user_name") {
			$obj->url = "nAll=N&user_id=".$value."&sdate=".$sdate[regdate]."&edate=".$edate[regdate];
		} else {
			$obj->url = "nAll=N&cs_seq=".$value."&sdate=".$sdate[regdate]."&edate=".$edate[regdate];
		}
		return $obj;
	}
	
}
class Simple_query {
	function simple_delete($table, $id,$del_data) {
		if(is_array($del_data)) {
			foreach ($del_data as $del) {
				$que = " delete from {$table} where {$id} = '{$del}' ";
				mysql_query($que) or die(mysql_error());
			}
			return count($del_data);
		} else {
			$que = " delete from {$table} where {$id} = '{$del_data}' ";
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
	
	function simple_update($param, $table, $id) { //$id = array
		$que = " update {$table} set ";
		$que_mid = "";
		$que_end = "";
		foreach($param as $key => $value) {
			if(!in_array($key,$id)) { 
				$que_mid .= ", $key = '$value' ";
				
			} else if(in_array($key,$id)) {
				$que_end .= " and {$key} = '$value' ";
			}
		}
		$que = $que.substr($que_mid,1)." where 1=1 ".$que_end;
		mysql_query($que) or die(mysql_error());
		return "수정되었습니다";
	}
	
	function simple_insert($param,$table) {
		$que = "insert into {$table} set ";
		foreach ($param as $key=>$value) {
			$que_mid .= ", $key = '$value' ";
		}
		$que_mid = substr($que_mid,1);
		mysql_query($que.$que_mid) or die(mysql_error());
		return "등록되었습니다.";
	}
}
?>





