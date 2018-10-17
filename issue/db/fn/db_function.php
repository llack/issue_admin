<?php
class db{
	function getDb() {
		$que = " show databases WHERE `Database` not in ('mysql','admin','cdcol','phpmyadmin','information_schema') ";
		$res = mysql_query($que) or die(mysql_error());
		while($row = mysql_fetch_assoc($res)){
			$dbList[] = $row[Database];
		}
		return $dbList;
	}
	function getTables($db) {
		$que = " SELECT table_name as tablename FROM INFORMATION_SCHEMA.TABLES where table_schema='".$db."' ";
		$res = mysql_query($que) or die(mysql_error());
		$cnt = mysql_num_rows($res);
		while($row = mysql_fetch_assoc($res)) {
			$list[] = $row[tablename];
		}
		$ul = "<ul>";
		foreach($list as $value) {
			$ul .= "<li id='d_{$db}_t_{$value}'><a onclick='initDb(\"{$db}\",\"{$value}\")' class='tba'>".$value."</a></li>";
		}
		$ul .= "</ul>";
		
		if($cnt == 0 ) {
			$ul = "<ul><li><a class='tba'>비어 있음</a></li></ul>";
		}
		
		$result = new stdClass();
		$result->tables = $ul;
		$result->count = $cnt;
		return $result;
	}
}
?>