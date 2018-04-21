<?php
define("TITLE","스파이더");

class json_select { 
	function cs_list() {
		$que = " select * from erp_ocsinfo order by cs_name ";
		$res = mysql_query($que) or die(mysql_error());
		$i = 0;
		while($row = mysql_fetch_array($res)) {
			$result[$i]["title"] = $row[cs_name]."";
			$result[$i]["description"] = $row[cs_code]."";
			$result[$i]["url"] = "?cs_code=".$row[cs_code]."";
			$i++;
		}
		
		return $result;
	}
}
?>