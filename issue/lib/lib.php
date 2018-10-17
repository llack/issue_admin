<?php

class LibCode{
	function url_auto_link($str = '', $popup = false) {
		if (empty($str)) {
			return false;
		}
		$target = $popup ? 'target="_blank"' : '';
		$str = str_replace(
				array("&lt;", "&gt;", "&amp;", "&quot;", "&nbsp;", "&#039;"),
				array("\t_lt_\t", "\t_gt_\t", "&", "\"", "\t_nbsp_\t", "'"),
				$str
				);
		$str = preg_replace(
				"/([^(href=\"?'?)|(src=\"?'?)]|\(|^)((http|https|ftp|telnet|news|mms):\/\/[a-zA-Z0-9\.-]+\.[가-힣\xA1-\xFEa-zA-Z0-9\.:&#=_\?\/~\+%@;\-\|\,\(\)]+)/i",
				"\\1<a href=\"\\2\" {$target}>\\2</A>",
				$str
		);
		$str = preg_replace(
				"/(^|[\"'\s(])(www\.[^\"'\s()]+)/i",
				"\\1<a href=\"http://\\2\" {$target}>\\2</A>",
				$str
		);
		$str = preg_replace(
				"/[0-9a-z_-]+@[a-z0-9._-]{4,}/i",
				"<a href=\"mailto:\\0\">\\0</a>",
				$str
				);
		$str = str_replace(
				array("\t_nbsp_\t", "\t_lt_\t", "\t_gt_\t", "'"),
				array("&nbsp;", "&lt;", "&gt;", "&#039;"),
				$str
				);
		return $str;
	}
	
	function nullChk($val) {
		return ($val==0) ? "null" : $val; 
	}
	
	function holiBack($syear,$smonth) {
		$opts = array('http' =>	array('method'  => 'GET','header' => 'TDCProjectKey: e3f534ab-059f-417e-b64c-c591e764dc76'));
		$context = stream_context_create($opts);
		$url = "https://apis.sktelecom.com/v1/eventday/days?year=$syear&month=$smonth&type=h,i";
		$fp = fopen($url, 'r', false, $context);
		$holiArr = json_decode(stream_get_contents($fp),true);
		$holiArr = $this->getHoliApi($holiArr[results]);
		return $holiArr;
	}
	
	function getHoliApi($holiArr) {
		for($i = 0; $i < count($holiArr); $i++) {
			$h = $holiArr[$i];
			$list[$i]['ymd'] = $h["year"]."-".$h["month"]."-".$h["day"];
			$list[$i]['text'] = $h[name];
		}
		return $list;
	}
}
?>