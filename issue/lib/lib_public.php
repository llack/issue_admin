<?
function php_timer() {
	static $arr_timer;
	if (!isset($arr_timer)) {
		$arr_timer = explode(" ", microtime());
	}
	else {
		$arr_timer2 = explode(" ", microtime());
		$result = ($arr_timer2[1] - $arr_timer[1]) + ($arr_timer2[0] - $arr_timer[0]);
		$result = sprintf("%.4f",$result);
		return $result;
	}
	return false;
}

function viewQuery($que) {
	
	$queryWord1 = array("select","delete","update","insert");
	$queryWord2 = array("from","limit","where","values","set","order by");
	
	foreach ($queryWord1 as $word) {
		$que = str_replace($word,"<font color='#FF3300'><B>".$word."</B></font>",$que);
	}
	
	foreach ($queryWord2 as $word) {
		$que = str_replace($word,"<BR><font color='blue'><B>".$word."</B></font>",$que);
	}
	
	unset($word);
	
	echo "<b>실행쿼리 :</b><BR><BR>" . $que . "<BR><BR>";
}

function getConfigure($f) {
	$que = "select " . $f . " from tb_configure";
	$res = mysql_query($que);
	$row = mysql_fetch_array($res);
	
	return $row[0];
}

class makehtml {
	function make_left_html($img,$body) {
		echo "
		<table width='100%' border=0 cellpadding=0 cellspacing=0>
		<tr>
		<td>
		<img src='/images/common/$img'></td>
		</tr>
		<tr>
		<td height=7></td>
		</tr>
		<tr>
		<td>$body</td>
		</tr>
		<tr>
		<td height=7></td>
		</tr>
		</table>
		";
	}
	
	function top_link() {
		echo "<A HREF=\"/mrboard/mrboard.php?tablename=notice\">" . txt_title_notice . "</A> |  <A HREF=\"/member/member_detail.php\">" . txt_title_mmodify . "</A> | <A HREF=\"/note/\">" . txt_title_note . "</A> | <A HREF=\"/common/help.php\" target='_blank'>" . txt_title_help . "</A> | <A HREF=\"/common/logout.php\">" . txt_title_logout . "</A>";
	}
}

class dbms {
	function get_total($que) {
		$res = mysql_query($que);
		return mysql_num_rows($res);
	}
	
	function makeres($que) {
		$res = mysql_query($que) or die(mysql_error());
	}
	
	function execute($que) {
		mysql_query($que) or die(mysql_error() . "<br>" . viewQuery($que));
	}
	
	function getrow($que) {
		$res = mysql_query($que);
		return mysql_num_rows($res);
	}
}

class javascript {
	var $msg, $location;
	
	function Alert($msg,$act="",$act2="") {
		echo "
		<SCRIPT LANGUAGE='JavaScript' type='text/javascript'>
		<!--
		alert('$msg');
		$act;
		$act2;
		//-->
		</SCRIPT>
		";
	}
	
	function AlertGo($msg,$location="/") {
		$this->Alert($msg,"location='$location'");
	}
	
	function AlertBack($msg) {
		$this->Alert($msg,"history.back();");
	}
	
	function AlertOpnerGo($msg,$location="/") {
		$this->Alert($msg,"opener.location='$location'","self.close()");
	}
	
	function goURL($url) {
		echo "
		<SCRIPT LANGUAGE='JavaScript' type='text/javascript'>
		<!--
		location = '$url';
		//-->
		</SCRIPT>
		";
		exit;
	}
	
	function location($url) {
		$this->goURL($url);
	}
	
	function selfclose() {
		echo "
		<SCRIPT LANGUAGE='JavaScript' type='text/javascript'>
		<!--
			self.close();
		//-->
		</SCRIPT>
		";
	}
	
	function openerReload($op="") {
		echo "
		<SCRIPT LANGUAGE='JavaScript' type='text/javascript'>
		<!--
			opener.location.reload();
		";
		if ($op!="no") echo "self.close();";
		echo "
		//-->
		</SCRIPT>
		";
	}
	
	function ConfirmGo($msg,$url) {
		echo "
		<SCRIPT LANGUAGE='JavaScript' type='text/javascript'>
		<!--
			if (confirm('" . $msg . "')) {
				location = '" . $url . "';
			}
		//-->
		</SCRIPT>
		";
	}
}

function cut_str($string,$length) {
	$textout=$string;
	$word_len=strlen($textout);
	
	if($word_len < $length) return $textout;
	elseif($word_len > $length) {
		for($i=$length; $i < $word_len; $i--) {
			$lastword=substr($textout,$i,$i);
			if(ord($lastword) < 127) {
				$textout = substr($textout,0, $i) . ".."; # $length 가 $i 였음. 근데 $i 는 바보.
				return $textout;
				break;
			}
		}
	}
}



?>