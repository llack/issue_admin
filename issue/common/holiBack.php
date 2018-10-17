<?php
session_start();
header ("Content-Type: text/html; charset=UTF-8");		#다국어지원을 위한 설정

include_once($_SERVER["DOCUMENT_ROOT"]."/conf/config.db.conn.php");//디비연결
include_once($_SERVER["DOCUMENT_ROOT"]."/lib/nawoo.php");//공통라이브러리
include_once($_SERVER["DOCUMENT_ROOT"]."/lib/lib.php");//공통라이브러리
$lib = new LibCode();
echo json_encode($lib->holiBack($_REQUEST[year],$_REQUEST[month]));exit;

