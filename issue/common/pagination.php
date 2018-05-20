<?

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
	
	public function getTotal() {
		return $this->_total;
	}
	public function getData( $page = 1,$limit = 10 ) {
		
		$this->_limit = $limit;

		if($this->_total <= $limit) {
			$page = 1;
		}
		$this->_page = $page;
		
		if ( $this->_limit == 'all' ) {
			$query = $this->_query;
		} else {
			$query = $this->_query . " LIMIT " . ( ( $this->_page - 1 ) * $this->_limit ) . ", $this->_limit";
		}
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
	
	public function createLinks($url="",$links = 10) {
		if ( $this->_limit == 'all' || $this->_total<=$this->_limit) {
			return '';
		} else {
			$last       = ceil( $this->_total / $this->_limit );
			$start      = ( ( $this->_page - $links ) > 0 ) ? $this->_page - $links : 1;
			$end        = ( ( $this->_page + $links ) < $last ) ? $this->_page + $links : $last;
			//$html		= '<div class="ui bottom attached label" style="background-color:rgba(0,0,0,.05)">';
			$html       = '<div class="ui borderless menu pagination floated right inverted purple"> ';
			
			$href = ( $this->_page == 1 ) ? '' : 'href="?page=' . ( $this->_page - 1 ) .$url.'"';// limit=' . $this->_limit . '&
			$html       .= '<a  '.$href.'class="item page">◀</a>';
			
			if ( $start > 1 ) {
				$html   .= '<a href="?page=1" class="item page">1</a>'; //1 page \limit=' . $this->_limit . '&
			}
			
			for ( $i = $start ; $i <= $end; $i++ ) {
				$class  = ( $this->_page == $i ) ? "nowPage" : "";
				$href  = ( $this->_page == $i ) ? '' : 'href="?page=' . ( $i) .$url.'"'; // limit=' . $this->_limit . '&
				$html   .= '<a '.$href.' class="item page '.$class.'">' . $i .'</a>'; // 중간들
			}
			
			if ( $end < $last ) {
				$html   .= '<a href="?page=' . $last .$url.'" class="item page">' . $last . '</a></li>'; // limit=' . $this->_limit . '&
			}
			
			$href = ( $this->_page == $last ) ? '' : 'href="?page=' . ( $this->_page + 1 ) .$url.'"'; // limit=' . $this->_limit . '&
			$html       .= '<a '.$href.' class="item page" >▶</a>';
			$html       .= '</div>'; //</div>
			return $html;
		}
	}
}
?>