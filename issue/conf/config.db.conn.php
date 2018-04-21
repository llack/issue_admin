<?php
// db 정보
$host='localhost';		   # 호스트명 또는 IP
$user='root';			   # Mysql 유저이름
$dbpass='924509as';		   # DB 패스워드
$dbname='spider';		   # 데이타 베이스 이름
$sock = mysql_connect($host,$user,$dbpass);
$db = mysql_select_db($dbname,$sock);
mysql_query('SET NAMES utf8');
?>