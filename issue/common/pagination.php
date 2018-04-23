<?
// db 정보
$host='localhost';		   # 호스트명 또는 IP
$user='root';			   # Mysql 유저이름
$dbpass='924509as';		   # DB 패스워드
$dbname='spider';		   # 데이타 베이스 이름
$sock = mysql_connect($host,$user,$dbpass);
$db = mysql_select_db($dbname,$sock);
mysql_query('SET NAMES utf8');

class Paginator{
	private $_limit;
	private $_page;
	private $_query;
	private $_total;
	
	public function __construct($query) {
		$this->_query = $query;
		$res= mysql_query($this->_query);
		$this->_total = mysql_num_rows($res);
	}
	
	public function getData( $page = 1,$limit = 10 ) {
		
		$this->_limit = $limit;
		$this->_page = $page;
		
		if ( $this->_limit == 'all' ) {
			$query = $this->_query;
		} else {
			$query = $this->_query . " LIMIT " . ( ( $this->_page - 1 ) * $this->_limit ) . ", $this->_limit";
		}
		echo $query;
		$res = mysql_query($query) or die(mysql_error());
		while ( $row = mysql_fetch_array($res) ) {
			$results[]  = $row;
		}
		
		$result = new stdClass();
		$result->page   = $this->_page;
		$result->limit  = $this->_limit;
		$result->total  = $this->_total;
		$result->data   = $results;
		
		return $result;
	}
	
	public function createLinks( $list_class , $links = 10) {
		if ( $this->_limit == 'all' ) {
			return '';
		}
		$last       = ceil( $this->_total / $this->_limit );
		$start      = ( ( $this->_page - $links ) > 0 ) ? $this->_page - $links : 1;
		$end        = ( ( $this->_page + $links ) < $last ) ? $this->_page + $links : $last;
		$html       = '<div class="' . $list_class . '"> ';
		
		$href = ( $this->_page == 1 ) ? '' : 'href="?limit=' . $this->_limit . '&page=' . ( $this->_page - 1 ) . '"';
		$html       .= '<a  '.$href.'class="item page">◀</a>';
		
		if ( $start > 1 ) {
			$html   .= '<a href="?limit=' . $this->_limit . '&page=1" class="item page">1</a>'; //1 page
		}
		
		for ( $i = $start ; $i <= $end; $i++ ) {
			$class  = ( $this->_page == $i ) ? "nowPage" : "";
			$href  = ( $this->_page == $i ) ? '' : 'href="?limit=' . $this->_limit . '&page=' . ( $i) . '"';
			$html   .= '<a '.$href.' class="item page '.$class.'">' . $i . '</a>'; // 중간들
		}
		
		if ( $end < $last ) {
			$html   .= '<a href="?limit=' . $this->_limit . '&page=' . $last . '" class="item page">' . $last . '</a></li>';
		}
		
		$href = ( $this->_page == $last ) ? '' : 'href="?limit=' . $this->_limit . '&page=' . ( $this->_page + 1 ) . '"';
		$html       .= '<a '.$href.' class="item page" >▶</a>';
		$html       .= '</div>';
		return $html;
	}
}
?>